<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        $ticket = Ticket::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
            'user_id' => $request->user()->id,
            'agent_id' => null,
        ]);

        return response()->json(['ticket' => $ticket], 201);
    }

    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'agente') {
            $tickets = Ticket::all();
        } elseif (($user->role === 'cliente')) {
            $tickets = Ticket::where('user_id', $user->id)->get();
        } else {
            return response()->json([
                'message' => 'Acesso negado. Nível de permissão inválido.'
            ], 403); 
        }

        return response()->json(['tickets' => $tickets]);
    }

    public function show(Ticket $ticket)
    {
        $ticket->load('replies');

        return response()->json(['ticket' => $ticket]);
    }

    public function close(Ticket $ticket)
    {
        $ticket->update(['status' => 'resolvido']);

        return response()->json(['ticket' => $ticket]);
    }

    public function assign(Request $request, Ticket $ticket)
    {
        $user = $request->user();

        if ($user->role === 'agente') {
            $ticket->update([
                'status' => 'em_andamento',
                'agent_id' => $user->id,
            ]);
        } else {
            return response()->json([
                'message' => 'Acesso negado. Nível de permissão inválido.'
            ], 403); 
        }

        return response()->json(['ticket' => $ticket]);
    }
}
