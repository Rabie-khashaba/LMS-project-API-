<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FirebaseV1NotificationService;
use Illuminate\Http\Request;

class FirebaseNotificationController extends Controller
{
    public function sendN(Request $request, FirebaseV1NotificationService $firebase)
    {
        $request->validate([
            'token' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

//        return response()->json([
//            'token' => $request->token,
//            'title' => $request->title,
//            'body' => $request->body
//        ]);

        $response = $firebase->sendNotification(
            $request->token,
            $request->title,
            $request->body
        );

        return response()->json($response);
}
}
