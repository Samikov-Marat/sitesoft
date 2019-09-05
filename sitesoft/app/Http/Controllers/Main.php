<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;

class Main extends Controller
{

    public function index()
    {
        $messages = Message::select('id', 'user_id', 'text', 'created_at')
            ->orderBy('created_at', 'desc')
            ->with('user')
            ->get();
        return view('main')
            ->with('messages', $messages);
    }

    public function save(Request $request)
    {
        $message = new Message();
        $message->user_id = auth()->user()->id;
        $message->text = $request->input('text');
        $message->save();
        return response()->redirectToRoute('index');
    }


}
