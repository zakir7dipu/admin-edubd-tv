<?php

namespace Module\CourseManagement\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\User;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Module\CourseManagement\Models\Course;
use Module\CourseManagement\Models\CourseFAQ;
use Module\CourseManagement\Models\CourseLevel;
use Module\CourseManagement\Models\CourseTopic;
use Module\CourseManagement\Models\CourseLesson;
use Module\CourseManagement\Models\CourseOutcome;
use Module\CourseManagement\Models\CourseLanguage;
use Module\CourseManagement\Service\CourseService;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Module\CourseManagement\Models\CourseInstructor;
use Module\CourseManagement\Service\CategoryService;
use Module\CourseManagement\Models\CourseIntroduction;
use Module\CourseManagement\Requests\CourseStoreRequest;
use Module\CourseManagement\Requests\CourseUpdateRequest;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use App\Traits\CheckPermission;

class CourseController extends Controller
{
    use FileUploader;

    public $course;
    public $courseService;
    use CheckPermission;





    public function __construct()
    {
        $this->courseService = new CourseService;
    }





    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $this->hasAccess("course-view");

        $categories_id              = (new CategoryService)->getCategoryIds($request);
// dd($categories_id);
        $data['courseLevels']       = CourseLevel::pluck('name', 'id');
        $data['courseLanguages']    = CourseLanguage::pluck('name', 'id');

        $data['courses']            = Course::query()
            ->with('level','language','category')
            ->searchByField('course_type')
            ->searchByField('course_category_id')
            ->searchByField('course_level_id')
            ->searchByField('course_language_id')
            ->likeSearch('title')
            ->idDesc()
            ->paginate(20);

        $data['table']              = Course::getTableName();

        return view('course/index', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("course-create");

        $data['courseLevels']       = CourseLevel::pluck('name', 'id');
        $data['courseLanguages']    = CourseLanguage::get(['id', 'name', 'is_default']);
        $data['course_id']          = 0;
        $data['tags']               = Tag::pluck('name', 'id');

        return view('course/create', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(CourseStoreRequest $request)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request) {
                $this->course = Course::create([
                    'course_category_id'    => $request->course_category_id,
                    'course_level_id'       => $request->course_level_id,
                    'course_language_id'    => $request->course_language_id,
                    'course_type'           => $request->course_type,
                    'title'                 => $request->course_title,
                    'slug'                  => $request->course_slug,
                    'regular_fee'           => $request->regular_fee ?? 0,
                    'discount_amount'       => $request->discount_amount ?? 0,
                    'course_fee'            => $request->regular_fee - $request->discount_amount ?? 0,
                    'short_description'     => $request->course_short_description ?? null,
                    'is_certificate'            => $request->is_certificate ?? 0,
                    'is_popular'            => $request->is_popular ?? 0,
                    'is_slider'             => $request->is_slider ?? 0,
                    'is_draft'              => 1,
                    'thumbnail_image'       => 'default.png',
                    'thumbnail_image_big'   => 'default.png',
                    // 'intro_video'           => 'https://www.youtube.com/embed/' . $request->intro_video,
                ]);

                foreach ($request->tag_id ?? [] as $tag_id) {
                    $this->course->courseTags()->create([
                        'tag_id' => $tag_id
                    ]);
                }

                $this->uploadImage($request->thumbnail_image, $this->course, 'thumbnail_image', 'course/thumbnail', 450, 400);
                $this->uploadImage($request->thumbnail_image_big, $this->course, 'thumbnail_image_big', 'course/thumbnail-big', 400, 592);
                // $this->uploadFile($request->intro_video, $this->course, 'intro_video', 'video/course');
            });

            return redirect()->route('cm.courses.intro-video', $this->course->id);
        } catch (\Throwable $th) {

            return redirect()->back()->withErrors($th->getMessage());
        }
    }


/*
     |--------------------------------------------------------------------------
     | UPLOAD METHOD
     |--------------------------------------------------------------------------
    */
    public function introVideo(Request $request, $id)
    {
        if ($request->isMethod('GET')) {

            $data['course']         = optional(Course::find($id));
            $data['course_id']      = $id;

            if (!$data['course'] && $id != 0) {
                return redirect()->route('cm.courses.create')->with('warning', 'Please fill up Basic Information first!');
            }

            return view('course/intro-video', $data);
        }

        if ($request->isMethod('POST')) {

            try {

                DB::transaction(function () use ($request) {
                        $courseLesson = Course::where('id', $request)->first();
                });

                return redirect()->route('cm.courses.introductions-update-or-create', $id);
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors($th->getMessage());
            }
        }
    }



    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $this->hasAccess("course-edit");

        $data['courseLevels']       = CourseLevel::pluck('name', 'id');
        $data['courseLanguages']    = CourseLanguage::get(['id', 'name', 'is_default']);
        $data['course']             = Course::where('id', $id)->with('courseTags')->first();
        $data['course_id']          = $id;
        $data['tags']               = Tag::pluck('name', 'id');

        return view('course/edit', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(CourseUpdateRequest $request, Course $course)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($course, $request) {
                $course->update([
                    'course_category_id'    => $request->course_category_id,
                    'course_level_id'       => $request->course_level_id,
                    'course_language_id'    => $request->course_language_id,
                    'course_type'           => $request->course_type,
                    'title'                 => $request->course_title,
                    'slug'                  => $request->course_slug,
                    'regular_fee'           => $request->regular_fee ?? 0,
                    'discount_amount'       => $request->discount_amount ?? 0,
                    'course_fee'            => $request->regular_fee - $request->discount_amount ?? 0,
                    'short_description'     => $request->course_short_description ?? null,
                    'is_certificate'        => $request->is_certificate ?? 0,
                    'is_popular'            => $request->is_popular ?? 0,
                    'is_slider'             => $request->is_slider ?? 0,
                    'thumbnail_image'       => $course->thumbnail_image,
                    'thumbnail_image_big'   => $course->thumbnail_image_big,
                    // 'intro_video'           => 'https://www.youtube.com/embed/' . $request->intro_video,
                ]);

                $course->courseTags()->delete();
                foreach ($request->tag_id ?? [] as $tag_id) {
                    $course->courseTags()->create([
                        'tag_id' => $tag_id
                    ]);
                }

                $this->uploadImage($request->thumbnail_image, $course, 'thumbnail_image', 'course/thumbnail', 450, 400);
                $this->uploadImage($request->thumbnail_image_big, $course, 'thumbnail_image_big', 'course/thumbnail-big', 400, 592);
                // $this->uploadFile($request->intro_video, $course, 'intro_video', 'video/course');
            });

            return redirect()->route('cm.courses.intro-video', $course->id);
        } catch (\Throwable $th) {

            return redirect()->back()->withErrors($th->getMessage());
        }
    }





    /*
     |--------------------------------------------------------------------------
     | INTRODUCTIONS UPDATE OR CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function introductionsUpdateOrCreate(Request $request, $id)
    {
        if ($request->isMethod('GET')) {

            if (!Course::find($id) && $id != 0) {
                return redirect()->route('cm.courses.create')->with('warning', 'Please fill up Basic Information first!');
            }

            $data['courseIntroductions']    = CourseIntroduction::where('course_id', $id)->get();
            $data['course_id']              = $id;

            return view('course/introductions', $data);
        }


        if ($id == 0) {
            return redirect()->back()->withErrors('Please fill up Basic Information first!');
        }


        if ($request->isMethod('POST')) {
            try {
                DB::transaction(function () use ($request, $id) {

                    $course = Course::where('id', $id)->with('courseIntroductions')->first();

                    $course->courseIntroductions()->delete();

                    foreach ($request->introduction_icon ?? [] as $key => $introductionIcon) {
                        if ($introductionIcon != '') {
                            $course->courseIntroductions()->create([
                                'icon' => $introductionIcon,
                                'text' => $request->introduction_text[$key]
                            ]);
                        }
                    }
                });

                return redirect()->route('cm.courses.instructors-update-or-create', $id);
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors($th->getMessage());
            }
        }
    }





    /*
     |--------------------------------------------------------------------------
     | INSTRUCTORS UPDATE OR CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function instructorsUpdateOrCreate(Request $request, $id)
    {
        if ($request->isMethod('GET')) {

            if (!Course::find($id) && $id != 0) {
                return redirect()->route('cm.courses.create')->with('warning', 'Please fill up Basic Information first!');
            }

            $data['instructors']        = User::instructor()->get();
            $data['courseInstructors']  = CourseInstructor::where('course_id', $id)->get();
            $data['course_id']          = $id;

            return view('course/instructors', $data);
        }


        if ($id == 0) {
            return redirect()->back()->withErrors('Please fill up Basic Information first!');
        }


        if ($request->isMethod('POST')) {
            try {
                DB::transaction(function () use ($request, $id) {

                    $course = Course::where('id', $id)->with('courseInstructors')->first();

                    $course->courseInstructors()->delete();

                    foreach ($request->course_instructor_id ?? [] as $instructor_id) {
                        if ($instructor_id != '') {
                            $course->courseInstructors()->create([
                                'instructor_id' => $instructor_id,
                            ]);
                        }
                    }
                });

                return redirect()->route('cm.courses.outcomes-update-or-create', $id);
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors($th->getMessage());
            }
        }
    }





    /*
     |--------------------------------------------------------------------------
     | OUTCOMES UPDATE OR CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function outcomesUpdateOrCreate(Request $request, $id)
    {
        if ($request->isMethod('GET')) {

            if (!Course::find($id) && $id != 0) {
                return redirect()->route('cm.courses.create')->with('warning', 'Please fill up Basic Information first!');
            }

            $data['courseOutcomes'] = CourseOutcome::where('course_id', $id)->get();
            $data['course_id']      = $id;

            return view('course/outcomes', $data);
        }


        if ($id == 0) {
            return redirect()->back()->withErrors('Please fill up Basic Information first!');
        }


        if ($request->isMethod('POST')) {
            try {
                DB::transaction(function () use ($request, $id) {

                    $course = Course::where('id', $id)->with('courseOutcomes')->first();

                    $course->courseOutcomes()->delete();

                    foreach ($request->outcome_text ?? [] as $outcome_text) {
                        if ($outcome_text != '') {
                            $course->courseOutcomes()->create([
                                'text'      => $outcome_text,
                                'serial_no' => nextSerialNo(CourseOutcome::class),
                            ]);
                        }
                    }
                });

                return redirect()->route('cm.courses.faqs-update-or-create', $id);
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors($th->getMessage());
            }
        }
    }





    /*
     |--------------------------------------------------------------------------
     | FAQS UPDATE OR CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function faqsUpdateOrCreate(Request $request, $id)
    {
        if ($request->isMethod('GET')) {

            if (!Course::find($id) && $id != 0) {
                return redirect()->route('cm.courses.create')->with('warning', 'Please fill up Basic Information first!');
            }

            $data['courseFAQs'] = CourseFAQ::where('course_id', $id)->get();
            $data['course_id']  = $id;

            return view('course/faqs', $data);
        }


        if ($id == 0) {
            return redirect()->back()->withErrors('Please fill up Basic Information first!');
        }


        if ($request->isMethod('POST')) {
            try {
                DB::transaction(function () use ($request, $id) {

                    $course = Course::where('id', $id)->with('courseFAQs')->first();

                    $course->courseFAQs()->delete();

                    foreach ($request->faq_title ?? [] as $key => $faq_title) {
                        if ($faq_title != '') {
                            $course->courseFAQs()->create([
                                'title'         => $faq_title,
                                'description'   => $request->faq_description[$key],
                                'serial_no'     => nextSerialNo(CourseOutcome::class),
                            ]);
                        }
                    }
                });

                return redirect()->route('cm.courses.topics-update-or-create', $id);
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors($th->getMessage());
            }
        }
    }





    /*
     |--------------------------------------------------------------------------
     | TOPICS UPDATE OR CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function topicsUpdateOrCreate(Request $request, $id)
    {
        if ($request->isMethod('GET')) {

            if (!Course::find($id) && $id != 0) {
                return redirect()->route('cm.courses.create')->with('warning', 'Please fill up Basic Information first!');
            }

            $data['courseTopics']   = CourseTopic::where('course_id', $id)->get();
            $data['course_id']      = $id;

            return view('course/topics', $data);
        }


        if ($id == 0) {
            return redirect()->back()->withErrors('Please fill up Basic Information first!');
        }


        if ($request->isMethod('POST')) {

            try {
                DB::transaction(function () use ($request, $id) {
                    $course = Course::where('id', $id)->with('courseTopics')->first();
                    $this->courseService->topicsUpdateOrCreate($request, $course);
                });

                return redirect()->route('cm.courses.lessons-update-or-create', $id);
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors($th->getMessage());
            }
        }
    }





    /*
     |--------------------------------------------------------------------------
     | LESSONS UPDATE OR CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function lessonsUpdateOrCreate(Request $request, $id)
    {
        if ($request->isMethod('GET')) {

            if (!Course::find($id) && $id != 0) {
                return redirect()->route('cm.courses.create')->with('warning', 'Please fill up Basic Information first!');
            }

            $data['courseTopics']   = CourseTopic::where('course_id', $id)->pluck('title', 'id');
            $data['courseLessons']  = CourseLesson::where('course_id', $id)->paginate(10);
            $data['course_id']      = $id;

            return view('course/lessons', $data);
        }


        if ($id == 0) {
            return redirect()->back()->withErrors('Please fill up Basic Information first!');
        }


        if ($request->isMethod('POST')) {
            try {
                DB::transaction(function () use ($request, $id) {
                    $course = Course::where('id', $id)->with('courseLessons')->first();
                    $this->courseService->lessonsUpdateOrCreate($request, $course);
                    $this->courseService->updateTopicTotalLectureAndTotalDuration($request);
                    $this->courseService->updateCourseTotalLectureAndTotalDuration($id);
                });

                return redirect()->route('cm.courses.upload', $id);
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors($th->getMessage());
            }
        }
    }





    /*
     |--------------------------------------------------------------------------
     | UPLOAD METHOD
     |--------------------------------------------------------------------------
    */
    public function upload(Request $request, $id)
    {
        if ($request->isMethod('GET')) {

            $data['course']         = optional(Course::find($id));
            $data['courseLessons']  = CourseLesson::query()
                ->publishedActive()
                ->where('course_id', $id)
                ->select('id', 'title', 'is_video', 'is_youtube_embed_link', 'is_attachment', 'video', 'attachment')
                ->paginate(10);

            $data['course_id']      = $id;

            if (!$data['course'] && $id != 0) {
                return redirect()->route('cm.courses.create')->with('warning', 'Please fill up Basic Information first!');
            }

            return view('course/upload', $data);
        }

        if ($request->isMethod('POST')) {

            try {

                DB::transaction(function () use ($request) {
                    foreach ($request->course_lesson_id as $key => $course_lesson_id) {
                        $courseLesson = CourseLesson::where('id', $course_lesson_id)->first();
                        $this->uploadFileToGoogleDrive($request->video[$key], $courseLesson, 'video');
                    }
                });

                return redirect()->route('cm.courses.upload', $id);
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors($th->getMessage());
            }
        }
    }





    /*
     |--------------------------------------------------------------------------
     | PUBLISH METHOD
     |--------------------------------------------------------------------------
    */
    public function publish(Request $request, $id)
    {
        if ($request->isMethod('GET')) {

            $data['course']     = optional(Course::find($id));
            $data['course_id']  = $id;

            if (!$data['course'] && $id != 0) {
                return redirect()->route('cm.courses.create')->with('warning', 'Please fill up Basic Information first!');
            }

            return view('course/publish', $data);
        }


        if ($id == 0) {
            return redirect()->back()->withErrors('Please fill up Basic Information first!');
        }


        if ($request->isMethod('POST')) {
            try {

                $isPublished = !$request->is_auto_published ? true : false;

                Course::where('id', $id)->update([
                    'is_published'      => $isPublished ? 1 : 0,
                    'is_auto_published' => $request->is_auto_published ?? 0,
                    'published_at'      => $request->is_auto_published ? $request->published_at : Carbon::now(),
                    'published_by'      => $isPublished ? auth()->id() : null,
                    'status'            => $isPublished ? 1 : 0,
                    'is_draft'          => $isPublished ? 0 : 1
                ]);

                return redirect()->route('cm.courses.index')->withMessage('Course has been published successfully!');
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors($th->getMessage());
            }
        }
    }





    /*
     |--------------------------------------------------------------------------
     | DELETE TOPIC
     |--------------------------------------------------------------------------
    */
    public function deleteTopic($id)
    {
        try {

            CourseTopic::destroy($id);

            return redirect()->back()->withMessage('Topic has been deleted successfully!');
        } catch (\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Topic');
        }
    }





    /*
     |--------------------------------------------------------------------------
     | DELETE LESSON
     |--------------------------------------------------------------------------
    */
    public function deleteLesson($id)
    {
        try {
            $lesson = CourseLesson::find($id);

            DB::transaction(function () use ($lesson) {

                $course_topic_id    = $lesson->course_topic_id;
                $video              = $lesson->video;
                $attachment         = $lesson->attachment;
                $url         = $lesson->url;
                $lesson             = $lesson->delete();

                if ($lesson && file_exists($video)) {
                    unlink($video);
                }
                $filename = pathinfo(parse_url($video, PHP_URL_PATH), PATHINFO_BASENAME);

                if ($filename) {
                    $this->deleteS3File($filename);
                }

                // $attachmentname = pathinfo(parse_url($attachment, PHP_URL_PATH), PATHINFO_BASENAME);
                if ($url) {
                    $this->deleteS3File($url);
                }

                if ($lesson && file_exists($attachment)) {
                    unlink($attachment);
                }

                if ($lesson && $course_topic_id) {
                    $courseLessonDurations  = CourseLesson::where('course_topic_id', $course_topic_id)->pluck('duration')->toArray();

                    $courseTopic = CourseTopic::where('id', $course_topic_id)->where('status', 1)->first();
                    $courseTopic->update([
                        'total_lecture'     => count($courseLessonDurations),
                        'total_duration'    => calculateTotalDurations($courseLessonDurations),
                    ]);

                    $this->courseService->updateCourseTotalLectureAndTotalDuration($courseTopic->course_id);
                }
            });

            return redirect()->back()->withMessage('Lesson has been deleted successfully!');
        } catch (\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Lesson');
        }
    }
    public function deleteS3File($path)
    {
        $s3 = new S3Client([
            'version' => 'latest',
            'region' => 'ap-southeast-1',
            'credentials' => [
                'key' => 'AKIA3GRJ74FXKIVU2ZVV',
                'secret' => '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',

            ],
        ]);
    
        $bucket = 'bsledutv';
    
        return $s3->deleteObject([
            'Bucket' => $bucket,
            'Key' => $path,
        ]);
    }




    /*
     |--------------------------------------------------------------------------
     | DESTROY (METHOD)
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        try {
            $course = Course::query()
                ->with('courseIntroductions')
                ->with('courseInstructors')
                ->with('courseOutcomes')
                ->with('courseFAQs')
                ->with('courseTopics')
                ->with('courseLessons')
                ->where('id', $id)
                ->first();

            DB::transaction(function () use ($course) {

                $course->courseTags()->delete();
                $course->courseIntroductions()->delete();
                $course->courseInstructors()->delete();
                $course->courseOutcomes()->delete();
                $course->courseFAQs()->delete();


                foreach ($course->courseLessons as $courseLesson) {
                    $video = $courseLesson->video;
                    $attachment = $courseLesson->attachment;
                    $url = $courseLesson->url;

                    $courseLesson = $courseLesson->delete();

                    if ($courseLesson && file_exists($video)) {
                        unlink($video);
                    }
                    $filename = pathinfo(parse_url($video, PHP_URL_PATH), PATHINFO_BASENAME);

                    if ($filename) {
                        $this->deleteS3File($filename);
                    }

                    if ($courseLesson && file_exists($attachment)) {
                        unlink($attachment);
                    }
                    if ($url) {
                        $this->deleteS3File($url);
                    }
                }


                $course->courseTopics()->delete();


                $thumbnailImage = $course->thumbnail_image;
                $introVideo = $course->intro_video;


                $course = $course->delete();

                if ($course && file_exists($thumbnailImage)) {
                    unlink($thumbnailImage);
                }

                if ($course && file_exists($introVideo)) {
                    unlink($introVideo);
                }
                $introVideo = pathinfo(parse_url($introVideo, PHP_URL_PATH), PATHINFO_BASENAME);

                if ($introVideo) {
                    $this->deleteS3File($introVideo);
                }
            });

            return redirect()->route('cm.courses.index')->withMessage('Course has been deleted successfully!');
        } catch (\Exception $ex) {
            return redirect()->back()->withWarning('An error occurred: '.$ex->getMessage());
        }
    }





    /*
     |--------------------------------------------------------------------------
     | STORE YOUTUBE EMBED LINK (METHOD)
     |--------------------------------------------------------------------------
    */
    public function storeYoutubeEmbedLink(Request $request)
    {
        try {
            $video = 'https://www.youtube.com/embed/' . $request->video;
            $courseLesson = CourseLesson::where('id', $request->id)->first();
            $courseLesson->update(['video' => $video,
            'is_youtube_embed_link' => 1
        ]);
            $courseLesson = $courseLesson->refresh();

            return response()->json(['status' => 1, 'title' => $courseLesson->title, 'video' => $video]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'title' => '', 'video' => '']);
        }
    }

    public function storeIntroYoutubeEmbedLink(Request $request)
    {
        try {
            $intro_video = 'https://www.youtube.com/embed/' . $request->intro_video;
            $course = Course::where('id', $request->id)->first();
            $course->update([
            'intro_video' => $intro_video,
            'is_video_or_link' => 1

        ]);
            $course = $course->refresh();

            return response()->json(['status' => 1, 'title' => $course->title, 'intro_video' => $intro_video]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'title' => '', 'intro_video' => '']);
        }
    }

    public function storeAllLink(Request $request)
    {
        try {
            $video = $request->video;
            $courseLesson = CourseLesson::where('id', $request->id)->first();
            $courseLesson->update(['video' => $video,
            'is_youtube_embed_link' => 2
        ]);
            $courseLesson = $courseLesson->refresh();

            return response()->json(['status' => 1, 'title' => $courseLesson->title, 'video' => $video]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'title' => '', 'video' => '']);
        }
    }
    public function storeIntroAllLink(Request $request)
    {
        try {
            $intro_video = $request->intro_video;
            $course = Course::where('id', $request->id)->first();
            $course->update(['intro_video' => $intro_video,
            'is_video_or_link' => 2
        ]);
            $course = $course->refresh();

            return response()->json(['status' => 1, 'title' => $course->title, 'intro_video' => $intro_video]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'title' => '', 'intro_video' => '']);
        }
    }




    /*
     |--------------------------------------------------------------------------
     | INSERT OR UPDATE ATTACHMENT (METHOD)
     |--------------------------------------------------------------------------
    */
    public function insertOrUpdateAttachment(Request $request)
    {
      
        $attachment = $request->file('attachment');
        $filename = uniqid('attachment_') . '.' . $attachment->getClientOriginalExtension();
        $bucket = 'bsledutv';
        $s3 = new S3Client([
            'version' => 'latest',
            'region' => 'ap-southeast-1',
            'credentials' => [
                'key' => 'AKIA3GRJ74FXKIVU2ZVV',
                'secret' => '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',

            ],
        ]);

        try {
            $s3->putObject([
                'Bucket' => $bucket,
                'Key' => $filename,
                'SourceFile' => $attachment->getPathname(),
                // 'ACL' => 'public-read',
            ]);

        $url = $s3->getObjectUrl($bucket, $filename);
        $courseLesson = CourseLesson::where('id', $request['course_id'])->first();
        $courseLesson->update(['url' => $filename]);

            $courseLesson = $courseLesson->refresh();

            return response()->json(['status' => 1, 'title' => $courseLesson->title, 'attachment' => $courseLesson->attachment]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'title' => '', 'attachment' => '']);
        }
    }
    
    // public function insertOrUpdateAttachment(Request $request)
    // {
    //     try {

    //         $courseLesson = CourseLesson::where('id', $request['course_id'])->first();

    //         if ($courseLesson->attachment != null) {
    //             $this->deleteGoogleDriveFileByPath($courseLesson->attachment);
    //         }
    //         $this->uploadFileToGoogleDrive($request['attachment'], $courseLesson, 'attachment');

    //         $courseLesson = $courseLesson->refresh();

    //         return response()->json(['status' => 1, 'title' => $courseLesson->title, 'attachment' => $courseLesson->attachment]);
    //     } catch (\Throwable $th) {
    //         return response()->json(['status' => 0, 'title' => '', 'attachment' => '']);
    //     }
    // }

    /*
     |--------------------------------------------------------------------------
     | Insert and update quiz (METHOD)
     |--------------------------------------------------------------------------
    */
    public function insertOrUpdateQuiz(Request $request)
    {
        try {



            // return response()->json(['status' => 1, 'title' => $courseLesson->title, 'attachment' => $courseLesson->attachment]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'title' => '', 'attachment' => '']);
        }
    }


    /*
     |--------------------------------------------------------------------------
     | FILE UPLOAD (METHOD)
     |--------------------------------------------------------------------------
    */
    // public function fileUpload(Request $request) {
    //     $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

    //     if (!$receiver->isUploaded()) {
    //         // file not uploaded
    //     }


    //     $fileReceived = $receiver->receive(); // receive file

    //     if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
    //         $file = $fileReceived->getFile(); // get file

    //         $extension = $file->getClientOriginalExtension();
    //         $fileName = str_replace('.'.$extension, '', $file->getClientOriginalName()); //file name without extenstion
    //         $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name

    //         $disk = Storage::disk(config('filesystems.default'));
    //         $path = $disk->putFileAs('videos', $file, $fileName);

    //         $file->store("", 'google');
    //         // delete chunked file
    //         unlink($file->getPathname());
    //         return [
    //             'path' => asset('storage/' . $path),
    //             'filename' => $fileName
    //         ];
    //     }

    //     // otherwise return percentage information
    //     $handler = $fileReceived->handler();
    //     return [
    //         'done' => $handler->getPercentageDone(),
    //         'status' => true
    //     ];
    // }

//     public function fileUpload(Request $request)
// {
//     // Validate the uploaded file
//     // $request->validate([
//     //     'video' => 'required|mimetypes:video/avi,video/mpeg,video/quicktime|max:50000',
//     // ]);

//     $video = $request->file('video');
//     $filename = uniqid('video_') . '.' . $video->getClientOriginalExtension();
//     $bucket = 'bsledutv';
//     $s3 = new S3Client([
//         'version' => 'latest',
//         'region' => 'ap-southeast-1',
//         'credentials' => [
//             'key' => 'AKIA3GRJ74FXKIVU2ZVV',
//             'secret' => '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',

//         ],
//     ]);

//     try {
//         $s3->putObject([
//             'Bucket' => $bucket,
//             'Key' => $filename,
//             'SourceFile' => $video->getPathname(),
//             // 'ACL' => 'public-read',
//         ]);

//         $url = $s3->getObjectUrl($bucket, $filename);
//         $courseLesson = CourseLesson::where('id', $request->course_id)->first();
//         $courseLesson->update(['video' => 'https://d3akx1ripsfmw0.cloudfront.net/'.$filename]);

//         return redirect()->route('cm.courses.upload', $courseLesson->course_id)->withMessage('Video uploaded successfully!');
//     } catch (S3Exception $e) {
//         // Handle any errors that occur during the S3 upload
//         return response()->json(['error' => $e->getMessage()], 500);
//     }
// }
// public function fileUpload(Request $request)
// {
//     $video = $request->file('video');
//     $filename = uniqid('video_') . '.' . $video->getClientOriginalExtension();
//     $bucket = 'bsledutv';
//     $s3 = new S3Client([
//         'version' => 'latest',
//         'region' => 'ap-southeast-1',
//         'credentials' => [
//             'key' => 'AKIA3GRJ74FXKIVU2ZVV',
//             'secret' => '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',
//         ],
//     ]);

//     try {
//         $s3->putObject([
//             'Bucket' => $bucket,
//             'Key' => $filename,
//             'SourceFile' => $video->getPathname(),
//             // 'ACL' => 'public-read', // Uncomment this line to make the file publicly accessible
//         ]);

//         $url = $s3->getObjectUrl($bucket, $filename);
//         $courseLesson = CourseLesson::where('id', $request->course_id)->first();
//         $courseLesson->update(['video' => 'https://d3akx1ripsfmw0.cloudfront.net/'.$filename,
//     ]);

//         return redirect()->route('cm.courses.upload', $courseLesson->course_id)->withMessage('Video uploaded successfully!');
//         } catch (S3Exception $e) {
//         return response()->json(['error' => $e->getMessage()], 500);
//     }
// }


public function fileUpload(Request $request)
{
    $video = $request->file('video');
    $filename = uniqid('video_') . '.' . $video->getClientOriginalExtension();
    $bucket = 'bsledutv';
    $s3 = new S3Client([
        'version' => 'latest',
        'region' => 'ap-southeast-1',
        'credentials' => [
            'key' => 'AKIA3GRJ74FXKIVU2ZVV',
            'secret' => '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',
        ],
    ]);

    try {
        // Initiate the multipart upload
        $result = $s3->createMultipartUpload([
            'Bucket' => $bucket,
            'Key' => $filename,
            'ACL' => 'private', // Set ACL to control access to the uploaded file
        ]);

        $uploadId = $result['UploadId'];

        // Upload the parts
        $parts = [];
        $file = fopen($video->getPathname(), 'r');
        $partNumber = 1;

        while (!feof($file)) {
            $result = $s3->uploadPart([
                'Bucket' => $bucket,
                'Key' => $filename,
                'UploadId' => $uploadId,
                'PartNumber' => $partNumber,
                'Body' => fread($file, 10 * 1024 * 1024), // Set the part size (5 MB in this example)
            ]);

            $parts[] = [
                'PartNumber' => $partNumber,
                'ETag' => $result['ETag'],
            ];

            $partNumber++;
        }

        fclose($file);

        // Complete the multipart upload
        $s3->completeMultipartUpload([
            'Bucket' => $bucket,
            'Key' => $filename,
            'UploadId' => $uploadId,
            'MultipartUpload' => [
                'Parts' => $parts,
            ],
        ]);

        // Get the URL of the uploaded file
        $url = $s3->getObjectUrl($bucket, $filename);

        // Update the course lesson with the video URL
        $courseLesson = CourseLesson::where('id', $request->course_id)->first();
        $courseLesson->update([
            'video' => 'https://d3akx1ripsfmw0.cloudfront.net/'.$filename,
            'is_youtube_embed_link' => 0
        ]
    );

        return redirect()->route('cm.courses.upload', $courseLesson->course_id)->withMessage('Video uploaded successfully!');
    } catch (S3Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
public function introFileUpload(Request $request)
{
    $intro_video = $request->file('intro_video');
    $filename = uniqid('intro_video_') . '.' . $intro_video->getClientOriginalExtension();
    $bucket = 'bsledutv';
    $s3 = new S3Client([
        'version' => 'latest',
        'region' => 'ap-southeast-1',
        'credentials' => [
            'key' => 'AKIA3GRJ74FXKIVU2ZVV',
            'secret' => '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',
        ],
    ]);

    try {
        // Initiate the multipart upload
        $result = $s3->createMultipartUpload([
            'Bucket' => $bucket,
            'Key' => $filename,
            'ACL' => 'private', // Set ACL to control access to the uploaded file
        ]);

        $uploadId = $result['UploadId'];

        // Upload the parts
        $parts = [];
        $file = fopen($intro_video->getPathname(), 'r');
        $partNumber = 1;

        while (!feof($file)) {
            $result = $s3->uploadPart([
                'Bucket' => $bucket,
                'Key' => $filename,
                'UploadId' => $uploadId,
                'PartNumber' => $partNumber,
                'Body' => fread($file, 10 * 1024 * 1024), // Set the part size (5 MB in this example)
            ]);

            $parts[] = [
                'PartNumber' => $partNumber,
                'ETag' => $result['ETag'],
            ];

            $partNumber++;
        }

        fclose($file);

        // Complete the multipart upload
        $s3->completeMultipartUpload([
            'Bucket' => $bucket,
            'Key' => $filename,
            'UploadId' => $uploadId,
            'MultipartUpload' => [
                'Parts' => $parts,
            ],
        ]);

        // Get the URL of the uploaded file
        $url = $s3->getObjectUrl($bucket, $filename);

        // Update the course lesson with the video URL
        $course = Course::where('id', $request->id)->first();
        $course->update([
            'intro_video' => 'https://d3akx1ripsfmw0.cloudfront.net/'.$filename,
            'is_video_or_link' => 0
        ]
    );

        return redirect()->route('cm.courses.intro-video', $course->id)->withMessage('Video uploaded successfully!');
    } catch (S3Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
