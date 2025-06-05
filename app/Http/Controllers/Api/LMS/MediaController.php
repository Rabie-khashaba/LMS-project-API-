<?php

namespace App\Http\Controllers\Api\LMS;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function uploadFiles(Request $request)
    {
        try {

            $request->validate([
                'video' => 'required|file|mimetypes:video/mp4,video/avi,video/mpeg',
            ]);

            $videoFile = $request->file('video');

            // تخزين الفيديو داخل storage/app/videos
            $path = $videoFile->store('videos');

            // حفظ اسم الملف الأصلي والمسار داخل قاعدة البيانات
            $video = Lesson::where('id' , $request->lesson_id)->update([
                'video_url' => $videoFile->getClientOriginalName(),
            ]);


            return response()->json([
                'message' => 'Video uploaded successfully.',
                'video' => $video,
            ]);

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }


    public function show(Request $request)
    {

        try {

            //return video
            return  response()->file(storage_path('app/' . 'private/'.'videos/'. $request->path));

            // or return json
//            if(!$video){
//                return response()->json([
//                    'status' => "Not Found",
//                ]);
//            }
//
//            return response()->json([
//                'status' => "OK",
//            ]);

        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

}
