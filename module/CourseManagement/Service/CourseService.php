<?php

namespace Module\CourseManagement\Service;

use Carbon\Carbon;
use App\Traits\FileUploader;
use Module\CourseManagement\Models\Course;
use Module\CourseManagement\Models\CourseTopic;
use Module\CourseManagement\Models\CourseLesson;
use Illuminate\Support\Facades\DB;

class CourseService
{
    use FileUploader;





    /*
     |--------------------------------------------------------------------------
     | TOPICS UPDATE OR CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function topicsUpdateOrCreate($request, $course)
    {
        foreach($request->topic_title ?? [] as $key => $topic_title) {

            if ($topic_title != '') {
                $courseTopic = CourseTopic::find($request->topic_id[$key]);

                $isEdit = $courseTopic != null && $courseTopic->is_published ? true : false;

                $course->courseTopics()->updateOrCreate([
                    'id'                => $request->topic_id[$key]
                ],[
                    'title'             => $topic_title,
                    'is_published'      => $isEdit ? optional($courseTopic)->is_published : $request->topic_is_published[$key],
                    'is_auto_published' => $isEdit ? optional($courseTopic)->is_auto_published : $request->topic_is_auto_published[$key],
                    'published_at'      => $isEdit ? optional($courseTopic)->published_at : ($request->topic_is_published[$key] == 1 ? Carbon::now() : $request->topic_published_at[$key]),
                    'published_by'      => $isEdit ? optional($courseTopic)->published_by : auth()->id(),
                    'serial_no'         => $request->topic_id[$key] == '' ? nextSerialNo(CourseTopic::class) : optional($courseTopic)->serial_no,
                ]);
            }
        }
    }





    /*
     |--------------------------------------------------------------------------
     | LESSONS UPDATE OR CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function lessonsUpdateOrCreate($request, $course)
    {
        foreach($request->course_lesson_course_topic_id ?? [] as $key => $course_topic_id) {
            if ($course_topic_id != '') {

                $courseLesson = CourseLesson::find($request->course_lesson_id[$key]);

                $courseLesson = $course->courseLessons()->updateOrCreate([
                    'id'                        => $request->course_lesson_id[$key]
                ], [
                    'course_topic_id'           => $course_topic_id,
                    'title'                     => $request->course_lesson_title[$key],
                    'duration'                  => $request->course_lesson_duration[$key],
                    // 'video'                     => $request->lesson_video[$key],
                    // 'attachment'                => $courseLesson ? optional($courseLesson)->attachment : 'attachment.pdf',
                    'description'               => $request->lesson_description[$key],
                    'assignment_description'    => $request->lesson_assignment_description[$key],
                    'is_video'                  => $request->lesson_is_video[$key],
                    'is_attachment'             => $request->lesson_is_attachment[$key],
                    'is_free'                   => $request->lesson_is_free[$key],
                    'is_quiz'                   => $request->lesson_is_quiz[$key],
                    'is_assignment'             => $request->lesson_is_assignment[$key],
                    'is_auto_published'         => $request->lesson_is_auto_published[$key],
                    'is_published'              => $request->lesson_is_published[$key],
                    'published_at'              => $request->lesson_published_at[$key],
                ]);

                // if ($request->lesson_is_video[$key] == 1 && isset($request->lesson_video[$key])) {
                //     $this->uploadFile($request->lesson_video[$key], $courseLesson, 'video', 'video/course/lesson');
                // }
                
                // if ($request->lesson_is_attachment[$key] == 1 && isset($request->lesson_attachment[$key])) {
                //     $this->uploadFile($request->lesson_attachment[$key], $courseLesson, 'attachment', 'attachment/course/lesson');
                // }
            }
        }
    }





    /*
     |--------------------------------------------------------------------------
     | UPDATE TOPIC TOTAL LECTURE AND TOTAL DURATION METHOD
     |--------------------------------------------------------------------------
    */
    public function updateTopicTotalLectureAndTotalDuration($request)
    {
        foreach($request->course_lesson_course_topic_id ?? [] as $key => $course_topic_id) {
            if ($course_topic_id != '') {

                $courseLessonDurations  = CourseLesson::where('course_topic_id', $course_topic_id)->where('status', 1)->pluck('duration')->toArray();
                
                CourseTopic::where('id', $course_topic_id)->where('status', 1)->update([
                    'total_lecture'     => count($courseLessonDurations),
                    'total_duration'    => calculateTotalDurations($courseLessonDurations),
                ]);
            }
        }
    }





    /*
     |--------------------------------------------------------------------------
     | UPDATE TOPIC TOTAL LECTURE AND TOTAL DURATION METHOD
     |--------------------------------------------------------------------------
    */
    // public function updateCourseTotalLectureAndTotalDuration($course_id)
    // {
    //     $courseTopicDurations   = CourseLesson::where('course_id', $course_id)->where('status', 1)
    //     ->whereHas('courseTopics', fn ($q) => $q->where('course_topic_id', $courseTopicDurations->id))
    //     ->pluck('total_duration')->toArray();

    //     Course::where('id', $course_id)->where('status', 1)->update([
    //         'total_lecture'     => count($courseTopicDurations),
    //         'total_duration'    => calculateTotalDurations($courseTopicDurations),
    //     ]);
    // }
    public function updateCourseTotalLectureAndTotalDuration($course_id)
    {
        // Calculate total lecture count for the course
        $totalLecture = CourseLesson::where('course_id', $course_id)
            ->where('status', 1)
            ->count();
    
        // Calculate total duration for the course
        $totalDuration = CourseLesson::whereHas('courseTopics', function ($query) use ($course_id) {
                $query->where('course_id', $course_id)->where('status', 1);
            })
            ->where('status', 1)
            ->pluck('duration')
            ->toArray();
    
        // Update the Course model with the calculated values
        Course::where('id', $course_id)
            ->where('status', 1)
            ->update([
                'total_lecture' => $totalLecture,
                'total_duration' => calculateTotalDurations($totalDuration),
            ]);
    }
    
}