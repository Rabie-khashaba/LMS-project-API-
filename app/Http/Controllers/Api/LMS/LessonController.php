<?php

namespace App\Http\Controllers\Api\LMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonRequest;
use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use App\TraitApiResource;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    use TraitApiResource;

    public function index()
    {
        $courses = LessonResource::collection(Lesson::get());

        return $this->apiResponse($courses , 'Ok'  , '200');

    }
    public function store(LessonRequest $request)
    {
        try {
            $course = Lesson::create([
                'course_id'=>$request->course_id,
                'title'=>$request->title,
                'content'=>$request->body
            ]);

            if(!$course){
                return response()->json([
                    'success'=>false,
                ]);
            }

            return response()->json([
                'status'=>"200",
                'message'=>"Lesson created successfully",
                'data'=>$course
            ]);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }


    public function show($id)
    {
        $course = new LessonResource(Lesson::find($id));

        return $this->apiResponse($course , 'Ok'  , '200');
    }

    public function update(LessonRequest $request ,$id)
    {
        try {

            $course = Lesson::where('id' ,$id)->first()->update([
                'title'=>$request->title,
                'description'=>$request->description,
            ]);


            if(!$course){
                return response()->json([
                    'success'=>false,
                ]);
            }

            return response()->json([
                'status'=>"200",
                'message'=>"Lesson updated successfully",
                'data'=>$course
            ]);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }


    public function destroy($id){

        $course = Lesson::findorfail($id)->delete();

        return response()->json([
            'status'=>"200",
            'message'=>"Lesson deleted successfully",
        ]);

    }

}
