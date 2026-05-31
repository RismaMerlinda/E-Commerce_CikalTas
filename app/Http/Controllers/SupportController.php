<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        $conversation = Conversation::firstOrCreate(
            ['user_id' => auth()->id()]
        );
        
        $messages = $conversation->messages()->with('sender')->orderBy('created_at', 'asc')->get();
        
        return view('support', compact('conversation', 'messages'));
    }

    public function reply(Request $request)
    {
        $request->validate(['message' => 'required|string']);
        
        $conversation = Conversation::firstOrCreate(
            ['user_id' => auth()->id()]
        );
        
        $conversation->update([
            'status' => 'pending',
            'last_message_at' => now(),
        ]);
        
        $conversation->messages()->create([
            'sender_type' => 'user',
            'sender_id' => auth()->id(),
            'message' => $request->message,
            'is_read' => false,
        ]);
        
        return response()->json(['success' => true]);
    }

    public function fetchMessages()
    {
        $conversation = Conversation::where('user_id', auth()->id())->first();
        if (!$conversation) {
            return response()->json(['messages' => []]);
        }
        
        $messages = $conversation->messages()->with('sender')->orderBy('created_at', 'asc')->get();
        
        // Mark admin messages as read
        $conversation->messages()->where('sender_type', 'admin')->where('is_read', false)->update(['is_read' => true]);
        
        return response()->json(['messages' => $messages, 'status' => $conversation->status]);
    }

    public function contactAdmin()
    {
        $conversation = Conversation::firstOrCreate(
            ['user_id' => auth()->id()]
        );
        $conversation->update(['status' => 'pending']);
        return response()->json(['success' => true]);
    }
}
