<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function inbox()
    {
        $messages = auth()->user()->messages; // Assuming messages is a relationship in User model
        return view('messages.inbox', compact('messages'));
    }

    public function conversation($id)
    {
        $conversation = Message::where('conversation_id', $id)->get();
        return view('messages.conversation', compact('conversation'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|integer',
            'message' => 'required|string',
        ]);

        Message::create([
            'user_id' => auth()->id(),
            'conversation_id' => $request->conversation_id,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('status', 'Message sent successfully.');
    }

    // Additional methods for messaging functionalities
}
