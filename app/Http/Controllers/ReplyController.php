<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $reply = Reply::create([
            'body' => $request->input('body'),
            'user_id' => $request->user()->id,
            'ticket_id' => $ticket->id,
        ]);

        return response()->json(['reply' => $reply]);
    }
}
