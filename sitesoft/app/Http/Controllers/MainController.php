<?php

namespace App\Http\Controllers;

use App\Events\MessageAdded;
use App\Http\Requests\MessageAdd as RequestMessageAdd;
use App\Message;
use Illuminate\Http\Request;
use Pusher\Pusher;

class MainController extends Controller
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

    public function save(RequestMessageAdd $request)
    {
        $message = new Message();
        $message->user_id = auth()->user()->id;
        $message->text = $request->input('text');
        $message->save();

        $message->load('user');

        event(new MessageAdded($message));

        return response()->redirectToRoute('index');
    }

    public function delete(Request $request)
    {
        $message = new Message();
        $message->user_id = auth()->user()->id;
        $message->text = $request->input('text');
        $message->save();

        event(new MessageAdded($message));

        return response()->redirectToRoute('index');
    }

    public function truncate(Request $request)
    {
        Message::truncate();
        return response()->redirectToRoute('index');
    }

}
