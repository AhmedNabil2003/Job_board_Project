<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        ini_set('max_execution_time', 3600);
        $notifications = auth()->user()->notifications; // Assuming notifications is a relationship in User model
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->markAsRead();

        return redirect('notifications')->with('status', 'Notification marked as read.');
    }

    // Additional methods for notification functionalities
}
