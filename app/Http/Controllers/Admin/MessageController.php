<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $conversations = Conversation::with(['user', 'messages' => function($q) {
            $q->latest()->limit(1);
        }])->orderBy('last_message_at', 'desc')->get();
        
        return view('admin.messages.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        $messages = $conversation->messages()->with('sender')->orderBy('created_at', 'asc')->get();
        
        // mark user messages as read
        $conversation->messages()->where('sender_type', 'user')->where('is_read', false)->update(['is_read' => true]);
        
        return response()->json([
            'messages' => $messages, 
            'conversation' => $conversation->load('user')
        ]);
    }

    public function reply(Request $request, Conversation $conversation)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $conversation->messages()->create([
            'sender_type' => 'admin',
            'sender_id' => auth()->id(),
            'message' => $request->message,
            'is_read' => false,
        ]);
        
        $conversation->update([
            'status' => 'replied',
            'last_message_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }
}

