<?php

namespace App\Http\Controllers\Api\LMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\RateRequest;
use App\Http\Resources\RateResource;
use App\Models\Rate;
use App\TraitApiResource;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    use TraitApiResource;

    public function index()
    {
        $courses = RateResource::collection(Rate::get());

        return $this->apiResponse($courses , 'Ok'  , '200');

    }
    public function store(RateRequest $request)
    {
        try {
            $course = Rate::create([
                'course_id'=>$request->course_id,
                'user_id'=>$request->user_id,
                'value'=>$request->value
            ]);

            if(!$course){
                return response()->json([
                    'success'=>false,
                ]);
            }

            return response()->json([
                'status'=>"200",
                'message'=>"Rate created successfully",
                'data'=>$course
            ]);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }


    public function show($id)
    {
        $course = new RateResource(Rate::find($id));

        return $this->apiResponse($course , 'Ok'  , '200');
    }

    public function update(RateRequest $request ,$id)
    {
        try {

            $course = Rate::where('id' ,$id)->first()->update([
                'value'=>$request->value,
            ]);


            if(!$course){
                return response()->json([
                    'success'=>false,
                ]);
            }

            return response()->json([
                'status'=>"200",
                'message'=>"Rate updated successfully",
                'data'=>$course
            ]);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }


    public function destroy($id){

        $course = Rate::findorfail($id)->delete();

        return response()->json([
            'status'=>"200",
            'message'=>"Rate deleted successfully",
        ]);

    }
}
