<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Notifications\DatabaseNotification;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function markNotificationAsRead($id) {
        $notify = DatabaseNotification::find($id);
        //dd($notify);
        $notify->markAsRead();

        // $notify->delete();

        return response()->json([
            
            'status' => 'Notification has been read'
        ]);
    }
}
