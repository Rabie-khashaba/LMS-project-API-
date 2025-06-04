<?php

namespace App\Http\Controllers\Api\LMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\TraitApiResource;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use TraitApiResource;

    public function index()
    {
        $courses = CourseResource::collection(Course::get());

        return $this->apiResponse($courses , 'Ok'  , '200');

    }
    public function store(CourseRequest $request)
    {
        try {
            $course = Course::create([
                'user_id'=>$request->user_id,
                'title'=>$request->title,
                'description'=>$request->description
            ]);

            if(!$course){
                return response()->json([
                    'success'=>false,
                ]);
            }

            return response()->json([
                'status'=>"200",
                'message'=>"Course created successfully",
                'data'=>$course
            ]);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }


    public function show($id)
    {
        $course = new CourseResource(Course::find($id));

        return $this->apiResponse($course , 'Ok'  , '200');
    }

    public function update(CourseRequest $request ,$id)
    {
        try {

            $course = Course::where('id' ,$id)->first()->update([
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
                'message'=>"Course updated successfully",
                'data'=>$course
            ]);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }


    public function destroy($id){

        $course = Course::findorfail($id)->delete();

        return response()->json([
            'status'=>"200",
            'message'=>"Course deleted successfully",
        ]);

    }




}
