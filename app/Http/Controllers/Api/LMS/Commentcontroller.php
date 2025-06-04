<?php

namespace App\Http\Controllers\Api\LMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\TraitApiResource;
use Illuminate\Http\Request;

class Commentcontroller extends Controller
{
    use TraitApiResource;

    public function index()
    {
        $courses = CommentResource::collection(Comment::get());

        return $this->apiResponse($courses , 'Ok'  , '200');

    }
    public function store(CommentRequest $request)
    {
        try {
            $course = Comment::create([
                'course_id'=>$request->course_id,
                'user_id'=>$request->user_id,
                'body'=>$request->body
            ]);

            if(!$course){
                return response()->json([
                    'success'=>false,
                ]);
            }

            return response()->json([
                'status'=>"200",
                'message'=>"Comment created successfully",
                'data'=>$course
            ]);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }


    public function show($id)
    {
        $course = new CommentResource(Comment::find($id));

        return $this->apiResponse($course , 'Ok'  , '200');
    }

    public function update(CommentRequest $request ,$id)
    {
        try {

            $course = Comment::where('id' ,$id)->first()->update([
                'body'=>$request->body,
            ]);


            if(!$course){
                return response()->json([
                    'success'=>false,
                ]);
            }

            return response()->json([
                'status'=>"200",
                'message'=>"Comment updated successfully",
                'data'=>$course
            ]);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }


    public function destroy($id){

        $course = Comment::findorfail($id)->delete();

        return response()->json([
            'status'=>"200",
            'message'=>"Comment deleted successfully",
        ]);

    }
}
