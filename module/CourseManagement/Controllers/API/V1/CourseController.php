<?php

namespace Module\CourseManagement\Controllers\API\V1;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
Use Illuminate\Support\Facades\Log;
use Module\CourseManagement\Models\Course;
use Module\CourseManagement\Models\CourseFAQ;
use Module\CourseManagement\Models\CourseTag;
use Module\CourseManagement\Models\CourseTopic;
use Module\CourseManagement\Models\CourseLesson;
use Module\CourseManagement\Models\LessonTracking;
use Module\CourseManagement\Models\LessonQuizResult;
use Module\CourseManagement\Models\CourseContent;
use Module\CourseManagement\Models\CourseOutcome;
use Module\CourseManagement\Models\CourseInstructor;
use Module\CourseManagement\Resources\CourseResource;
use Module\CourseManagement\Models\CourseIntroduction;
use Module\CourseManagement\Resources\CourseFAQResource;
use Module\CourseManagement\Resources\CourseTopicResource;
use Module\CourseManagement\Resources\CourseLessonResource;
use Module\CourseManagement\Resources\CourseOutcomeResource;
use Module\CourseManagement\Resources\CourseIntroductionResource;
use Module\EnrollmentManagement\Models\Enrollment;
use Module\EnrollmentManagement\Models\EnrollmentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\CourseManagement\Models\CourseReview;
use Module\CourseManagement\Models\LessonsReview;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;


class CourseController extends Controller
{

    public $lessonReview;
    public $students;
    public $courseReview;
    public $quizResult;
    public $quizUpdate;
    public $lessonTracking;
    /*
    |--------------------------------------------------------------------------
    | POPULAR (METHOD)
    |--------------------------------------------------------------------------
    */
    public function popular()
    {
        try {
            $courses    = CourseResource::collection(
                Course::publishedActive()->popularCourse()->paginate(12)
            )
                ->response()
                ->getData(true);

            return  response()->json([
                'status'    => 1,
                'message'   => count($courses) == 0 ? 'No items found!' : 'Success!',
                'data'      => $courses,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }





    /*
    |--------------------------------------------------------------------------
    | LATEST (METHOD)
    |--------------------------------------------------------------------------
    */
    public function latest()
    {
        try {
            $courses    = CourseResource::collection(
                Course::publishedActive()->idDesc()->paginate(12)
            )
                ->response()
                ->getData(true);

            return  response()->json([
                'status'    => 1,
                'message'   => count($courses) == 0 ? 'No items found!' : 'Success!',
                'data'      => $courses,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }





    /*
    |--------------------------------------------------------------------------
    | COURSES BY CATEGORY (METHOD)
    |--------------------------------------------------------------------------
    */
    public function coursesByCategory($category_slug)
    {
        try {
            $courses    = CourseResource::collection(
                Course::query()
                    ->publishedActive()
                    ->when(request()->filled('fee_type') && Str::lower(request('fee_type')) == 'free', fn ($q) => $q->freeCourse())
                    ->when(request()->filled('fee_type') && Str::lower(request('fee_type')) == 'paid', fn ($q) => $q->paidCourse())
                    ->whereHas('category', fn ($q) => $q->where('slug', $category_slug))
                    ->idDesc()
                    ->paginate(8)
            )
                ->response()
                ->getData(true);

            return  response()->json([
                'status'    => 1,
                'message'   => count($courses) == 0 ? 'No items found!' : 'Success!',
                'data'      => $courses,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }





    /*
    |--------------------------------------------------------------------------
    | COURSE TAGS (METHOD)
    |--------------------------------------------------------------------------
    */
    public function courseTags()
    {
        try {
            $courseTags = CourseTag::groupBy('tag_id')->with('tag:id,name')->get(['id', 'course_id', 'tag_id']);

            return  response()->json([
                'status'    => 1,
                'message'   => count($courseTags) == 0 ? 'No items found!' : 'Success!',
                'data'      => $courseTags,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }





    /*
    |--------------------------------------------------------------------------
    | COURSES BY TAG (METHOD)
    |--------------------------------------------------------------------------
    */
    public function coursesByTag($tag_id)
    {
        try {
            $courses    = CourseResource::collection(
                Course::query()
                    ->publishedActive()
                    ->whereHas('courseTags', fn ($q) => $q->where('tag_id', $tag_id))
                    ->idDesc()
                    ->get()
            )
                ->response()
                ->getData(true);

            return  response()->json([
                'status'    => 1,
                'message'   => count($courses) == 0 ? 'No items found!' : 'Success!',
                'data'      => $courses,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }





    /*
    |--------------------------------------------------------------------------
    | SHOW (METHOD)
    |--------------------------------------------------------------------------
    */
    public function show($slug)
    {
        try {
            $course     = Course::query()
                ->publishedActive()
                ->where('slug', $slug)
                ->with('category:id,name')
                ->with('level:id,name')
                ->with('language:id,name')
                ->with('publishedBy:id,first_name')
                ->first();

            return  response()->json([
                'status'    => 1,
                'message'   => $course ? 'Success' : 'Not Found!????',
                'data'      => $course,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }





    /*
    |--------------------------------------------------------------------------
    | COURSE INTRODUCTIONS (METHOD)
    |--------------------------------------------------------------------------
    */
    public function courseIntroductions($slug)
    {
        try {

            $course_id              = optional(Course::where('slug', $slug)->first())->id;
            $courseIntroductions    = CourseIntroductionResource::collection(
                CourseIntroduction::query()
                    ->where('course_id', $course_id)
                    ->get()
            )
                ->response()
                ->getData(true);

            return  response()->json([
                'status'    => 1,
                'message'   => count($courseIntroductions) > 0 ? 'Success' : 'No introductions found!',
                'data'      => $courseIntroductions,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }





    /*
    |--------------------------------------------------------------------------
    | COURSE INSTRUCTORS (METHOD)
    |--------------------------------------------------------------------------
    */
    public function courseInstructors($slug)
    {
        try {

            $course_id          = optional(Course::where('slug', $slug)->first())->id;
            $courseInstructors  = CourseInstructor::query()
                ->where('course_id', $course_id)
                ->with('instructor.userPrimaryEducation')
                ->get();

            return  response()->json([
                'status'    => 1,
                'message'   => count($courseInstructors) > 0 ? 'Success' : 'No instructors found!',
                'data'      => $courseInstructors,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }





    /*
    |--------------------------------------------------------------------------
    | COURSE OUTCOMES (METHOD)
    |--------------------------------------------------------------------------
    */
    public function courseOutcomes($slug)
    {
        try {

            $course_id      = optional(Course::where('slug', $slug)->first())->id;
            $courseOutcomes = CourseOutcomeResource::collection(
                CourseOutcome::where('course_id', $course_id)->get()
            )
                ->response()
                ->getData(true);

            return  response()->json([
                'status'    => 1,
                'message'   => count($courseOutcomes) > 0 ? 'Success' : 'No outcomes found!',
                'data'      => $courseOutcomes,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }





    /*
    |--------------------------------------------------------------------------
    | COURSE FAQS (METHOD)
    |--------------------------------------------------------------------------
    */
    public function courseFAQs($slug)
    {
        try {

            $course_id      = optional(Course::where('slug', $slug)->first())->id;
            $courseFAQs     = CourseFAQResource::collection(
                CourseFAQ::where('course_id', $course_id)->get()
            )
                ->response()
                ->getData(true);

            return  response()->json([
                'status'    => 1,
                'message'   => count($courseFAQs) > 0 ? 'Success' : 'No faqs found!',
                'data'      => $courseFAQs,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }





    /*
    |--------------------------------------------------------------------------
    | COURSE TOPICS (METHOD)
    |--------------------------------------------------------------------------
    */
    public function courseTopics($slug)
    {
        try {

            $course_id      = optional(Course::where('slug', $slug)->first())->id;
            $courseTopics   = CourseTopicResource::collection(
                CourseTopic::query()
                    ->where('course_id', $course_id)
                    ->publishedActive()
                    ->wherehas('lessons')
                    ->get()
            )
                ->response()
                ->getData(true);

            return  response()->json([
                'status'    => 1,
                'message'   => count($courseTopics) > 0 ? 'Success' : 'No topics found!',
                'data'      => $courseTopics,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | COURSE TOPICS Content (METHOD)
    |--------------------------------------------------------------------------
    */
    public function courseContent($slug)
    {
        try {

            $course_id      = optional(Course::where('slug', $slug)->first())->id;
            $courseLesson   = CourseLessonResource::collection(
                CourseLesson::query()
                    ->where('course_id', $course_id)
                    ->with(['lessonTracking' => function ($query) {
                        $query->select('id', 'lesson_id', 'is_completed');
                    }])
                    ->freeVideos()
                    ->publishedActive()
                    ->get()
            )
                ->response()
                ->getData(true);

            return  response()->json([
                'status'    => 1,
                'message'   => count($courseLesson) > 0 ? 'Success' : 'No topics content found!',
                'data'      => $courseLesson,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }




    /*
    |--------------------------------------------------------------------------
    | COURSE TOPIC LESSONS (METHOD)
    |--------------------------------------------------------------------------
    */
    public function courseTopicLessons($topic_id)
    {
        try {

            $courseLessons  = CourseLessonResource::collection(
                CourseLesson::publishedActive()
                ->where('course_topic_id', $topic_id)
                ->with(['lessonTracking' => function ($query) {
                    $query->select('id', 'lesson_id', 'is_completed');
                }])->get()
            )
                ->response()
                ->getData(true);

            return  response()->json([
                'status'    => 1,
                'message'   => count($courseLessons) > 0 ? 'Success' : 'No lessons found!',
                'data'      => $courseLessons,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }





    /*
    |--------------------------------------------------------------------------
    | ACCOUNT COURSES (METHOD)
    |--------------------------------------------------------------------------
    */
    public function accountCourses()
    {

        try {


            $course_ids = EnrollmentItem::query()
                ->whereHas('enrollment', fn ($q) => $q->where('student_id', auth()->id())
                    ->where('payment_status', '=', 'Paid'))
                ->groupBy('course_id')
                ->pluck('course_id');



            $courses    = Course::query()
                ->publishedActive()
                ->whereIn('id', $course_ids)
                ->likeSearch('title')
                ->with('category:id,name')
                ->with('level:id,name')
                ->with('language:id,name')
                ->paginate(20);

            return  response()->json([
                'status'    => 1,
                'message'   => count($courses) > 0 ? 'Success' : 'No courses found!',
                'data'      => $courses,
                'errors'    => null
            ]);

            dd($course_ids);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => '',
                    'error'     => $th->getMessage()
                ]);
        }
    }




    /*
    |--------------------------------------------------------------------------
    | ACCOUNT COURSE TOPIC LESSON (METHOD)
    |--------------------------------------------------------------------------
    */
    public function accountCourseTopicLesson($id)
    {
        try {
            $course     = CourseLesson::query()
            ->where('id', $id)
            ->with('course:id,slug')
            ->withCount('lessonReview as totalReview')
            ->with(['lessonReview' => function ($query) {
                $query->select('id', 'lesson_id', 'user_id', 'comment')
                    ->with('student')->idDesc();
            }])
            ->with(['lessonQuiz' => function ($query) {
                $query->select('id', 'lesson_id', 'name')
                    ->with('lessonQuizOption');
            }])
            ->with(['lessonTracking' => function ($query) {
                $query->select('id', 'lesson_id', 'is_completed');
            }])
            ->first();
            // dd($course);

            return  response()->json([
                'status'    => 1,
                'message'   => $course ? 'Success' : 'Not Found!???',
                'data'      => $course,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }

    public function downloadPdf($attachment)
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
        $key = $attachment;
     
    
        try {
            $result = $s3->getObject([
                'Bucket' => $bucket,
                'Key' => $key,
            ]);
    
            return response($result['Body'])
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="downloaded-file.pdf"');
        } catch (\Exception $e) {
            // Handle the error response
            return response('Error retrieving the PDF file', 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH BY TITLE METHOD (METHOD)
    |--------------------------------------------------------------------------
    */

    public function SearchByTitle($title)
    {
        try {
            $result     = Course::query()
                ->publishedActive()
                ->where('title', 'LIKE', '%' . $title . '%')
                ->with('category:id,slug')
                ->get();

            return  response()->json([
                'status'    => 1,
                'message'   => $result ? 'Success' : 'Not Found!___',
                'data'      => $result,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | All COURSE (METHOD)
    |--------------------------------------------------------------------------
    */
    public function AllCourse()
    {
        try {
            $courses    = CourseResource::collection(
                Course::publishedActive()->paginate(20)
            )
                ->response()
                ->getData(true);

            return  response()->json([
                'status'    => 1,
                'message'   => count($courses) == 0 ? 'No items found!' : 'Success!',
                'data'      => $courses,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }



    // lesson review
    public function lessonReview(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->lessonReview = LessonsReview::create([
                    'lesson_id'                   => $request->lesson_id,
                    'user_id'                     => auth()->id(),
                    'comment'                     => $request->comment

                ]);
                $this->students = LessonsReview::where('user_id', auth()->id())->get();
            });

            return  response()->json([
                'status'    => 1,
                'message'   => 'Lesson Review Successfully',
                'data'      => $this->lessonReview,
                'student'   => $this->students,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => '',
                    'error'     => $th->getMessage()
                ]);
        }
    }


    // lesson review get
    public function getLessonReview($lessonId)
    {
        try {
            $lessonReview    =  LessonsReview::where('lesson_id',$lessonId)->with('student')->idDesc()->get();

            return  response()->json([
                'status'    => 1,
                'message'   => count($lessonReview) == 0 ? 'No items found!' : 'Success!',
                'data'      => $lessonReview,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }




     /*
    |--------------------------------------------------------------------------
    | Course Review Post (METHOD)
    |--------------------------------------------------------------------------
    */
    public function courseReview(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->courseReview = CourseReview::create([
                    'course_id'                   => $request->course_id,
                    'user_id'                     => auth()->id(),
                    'comment'                     => $request->comment

                ]);
            });

            return  response()->json([
                'status'    => 1,
                'message'   => 'Course Review Successfully',
                'data'      => $this->courseReview,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => '',
                    'error'     => $th->getMessage()
                ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Course Review get (METHOD)
    |--------------------------------------------------------------------------
    */
    public function getCourseReview($course_id)
    {
        try {

            $courseReview    =  CourseReview::where('course_id',$course_id)->with('student')->idDesc()->get();
            // dd($courseReview);

            return  response()->json([
                'status'    => 1,
                'message'   => count($courseReview) == 0 ? 'No items found!' : 'Success!',
                'data'      => $courseReview,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }
    public function getLessonResult(Request $request, $lessonId, $studentId )
    {
        try {

        $lessonResult = LessonQuizResult::query()
            ->where('student_id', $studentId)
            ->where('lesson_id', $lessonId)
            ->where('is_completed', 1)
            ->first();


            return  response()->json([
                'status'    => 1,
                'message'   =>  'Success!',
                'data'      => $lessonResult,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }

    public function quizResult(Request $request)
    {
        try {

            DB::transaction(function () use ($request) {
                $student_verify= LessonQuizResult::query()
                ->where('student_id',auth()->id())
                ->where('lesson_id',$request->lesson_id)->first();

                if($student_verify != null){
                      $student_verify->update([
                        'student_id'           => auth()->id(),
                        'lesson_id'            => $request->lesson_id,
                        'total_quiz'           => $request->total_quiz,
                    ]);
                    $this->quizResult = $student_verify;
                }else{
                    $this->quizResult          = LessonQuizResult::create([
                        'student_id'           => auth()->id(),
                        'lesson_id'            => $request->lesson_id,
                        'total_quiz'           => $request->total_quiz,
                    ]);
                }
                
            });


            return  response()
                ->json([
                    'status'        => 1,
                    'message'       => 'Quiz result create successfully !',
                    'data'          => $this->quizResult,

                ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'        => 0,
                    'message'       => $th->getMessage(),
                    'user'          => null,

                ]);
        }
    }

    public function quizResultUpdate(Request $request, $id)
{
    try {
        // Get the correct answers from the request
        $correctAnswers = $request->input('correctAnswers', []);
        $student_verify = LessonQuizResult::find($id);

        DB::transaction(function () use ($request, $id, $correctAnswers, $student_verify ) {

            $student_verify->update([
                'total_marks' => $request->totalMarks,
                'is_completed' => $request->is_completed,
            ]);
        });

        return response()
            ->json([
                'status' => 1,
                'message' => 'quiz test updated successfully!',
                'data' => $student_verify,
            ]);
    } catch (\Throwable $th) {
        return response()
            ->json([
                'status' => 0,
                'message' => $th->getMessage(),
                'user' => null,
            ]);
    }
}
public function getLessonTracking(Request $request, $studentId, $courseId, $lessonId )
    {
        try {

        $lessonTracking = LessonTracking::query()
            ->where('student_id', $studentId)
            ->where('course_id',$courseId)
            ->where('lesson_id', $lessonId)
            ->where('is_completed', 1)
            ->first();

            Log::info([$request->all(), $studentId,$courseId, $lessonId]);
            return  response()->json([
                'status'    => 1,
                'message'   =>  'Success!',
                'data'      => $lessonTracking,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }

    public function lessonTracking(Request $request)
    {
        try {

            DB::transaction(function () use ($request) {
                $student_verify= LessonTracking::query()
                ->where('student_id',auth()->id())
                ->where('lesson_id',$request->lesson_id)
                ->where('course_id',$request->course_id)
                ->first();

                if($student_verify == null){
                    $this->lessonTracking          = LessonTracking::create([
                        'student_id'           => auth()->id(),
                        'lesson_id'            => $request->lesson_id,
                        'course_id'            => $request->course_id,
                        'is_completed'         => $request->is_completed,
                    ]);
                }
                
            });


            return  response()
                ->json([
                    'status'        => 1,
                    'message'       => 'Lesson Tracking create successfully !',
                    'data'          => $this->lessonTracking,

                ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'        => 0,
                    'message'       => $th->getMessage(),
                    'user'          => null,

                ]);
        }
    }
    public function getCertificate()
    {
        try {
            $enrollmentItems = EnrollmentItem::query()
                ->whereHas('enrollment', function ($q) {
                    $q->where('payment_status', 'Paid')->authorize();
                })
                ->whereHas('course', function ($q) {
                    $q->where('is_certificate', '1');
                })
                ->with('enrollment.student:id,first_name,last_name,username,image')
                ->has('course.courseLessons.lessonTracking')
                ->orderBy('id', 'DESC')
                ->paginate(20);
    
            $sumTotalLecture = $enrollmentItems->sum(function ($enrollmentItem) {
                return optional($enrollmentItem->course)->total_lecture ?? 0;
            });
    
            $countLessonTracking = $enrollmentItems->sum(function ($enrollmentItem) {
                return optional($enrollmentItem->course->courseLessons)->sum(function ($lesson) {
                    return optional($lesson->lessonTracking)->count() ?? 0;
                });
            });
    
            if ($sumTotalLecture == $countLessonTracking) {
                return response()->json([
                    'status'  => 1,
                    'message' => count($enrollmentItems) > 0 ? 'Success' : 'No enrollment items found!',
                    'data'    => $enrollmentItems,
                    'errors'  => null,
                ]);
            } else {
                return response()->json([
                    'status'  => 0,
                    'message' => 'Mismatch in lecture counts!',
                    'data'    => null,
                    'errors'  => null,
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => 0,
                'message' => 'There was an error!',
                'data'    => null,
                'error'   => $th->getMessage(),
            ]);
        }
    }
    private function generateCertificate($enrollmentItem)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true); // Enable fetching remote images

        $dompdf = new Dompdf($options);
    
        // Load the HTML view
        $html = view('certificate', ['enrollmentItem' => $enrollmentItem])->render();
    
        // Load the HTML into Dompdf
        $dompdf->loadHtml($html);
    
        // Set paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
    
        // Render the PDF (output)
        $dompdf->render();
    
        // Output the PDF as a string
        $pdfContent = $dompdf->output();
    
        return $pdfContent;
    }

public function downloadCertificate($enrollmentItemId)
{
    try {
        // Find the enrollment item by ID
        $enrollmentItem = EnrollmentItem::find($enrollmentItemId);

        if (!$enrollmentItem) {
            return response()->json([
                'status'  => 0,
                'message' => 'Enrollment item not found!',
            ], 404);
        }

        // Generate the certificate file content
        $certificateContent = $this->generateCertificate($enrollmentItem);

        // Generate a unique filename for the certificate (e.g., using enrollment item ID)
        $filename = "certificate_{$enrollmentItemId}.pdf";

        // Store the certificate file in a temporary storage location
        Storage::put($filename, $certificateContent);

        // Define the file path
        $filePath = storage_path("app/{$filename}");

        // Return the certificate as a downloadable file
        return response()->download($filePath, $filename)->deleteFileAfterSend(true);
    } catch (\Throwable $th) {
        return response()->json([
            'status'  => 0,
            'message' => 'There was an error generating the certificate!',
            'error'   => $th->getMessage(),
        ]);
    }
}

}
