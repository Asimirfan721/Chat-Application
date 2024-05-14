<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return response()->json(['message' => 'Message sent successfully', 'data' => $message]);
    }

    public function getAllMessages()
    {
        $messages = Message::with('user')->orderBy('created_at', 'asc')->get();

        return response()->json(['messages' => $messages]);
    }
    
    public function getUserMessages($user_id)
    {
        $messages = Message::where('user_id', $user_id)->with('user')->orderBy('created_at', 'asc')->get();

        return response()->json(['messages' => $messages]);
    }
}









