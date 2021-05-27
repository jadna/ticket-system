<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use App\Http\Requests;


class TicketsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    /**
     * Display all tickets.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$tickets = Ticket::paginate(10);
        $categories = Category::all();
        $status = Status::all();
        $priorities = Priority::all();
        $totalTickets = Ticket::count();
        $openTickets = Ticket::where('status', 1)->count();
        $closedTickets = Ticket::where('status', 4)->count();

        var_dump($tickets);

        return view('tickets.index', compact('tickets', 'categories', 'status', 'priorities', 'totalTickets', 'openTickets','closedTickets'));
    }

    /**
     * Display all tickets by a user.
     *
     * @return \Illuminate\Http\Response
     */
    public function userTickets()
    {
        $tickets = Ticket::where('user_id', Auth::user()->id)->paginate(10);
        $categories = Category::all();
        $status = Status::all();
        $priorities = Priority::all();

        return view('home', compact('tickets', 'categories', 'status', 'priorities'));
    }

    /**
     * Show the form for opening a new ticket.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$categories = Category::all();
        $status = Status::all();
        $priorities = Priority::all();

        return view('tickets.create', compact('categories', 'status', 'priorities'));
    }

    /**
     * Store a newly created ticket in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**1 - Aberto  2 - Em andamento 3- Atrasado 4- Resolvido */
        $this->validate($request, [
            'title'     => 'required',
            'category'  => 'required',
            'priority'  => 'required',
            'message'   => 'required'
        ]);

      
        $ticket = new Ticket([
            'title'     => $request->input('title'),
            'user_id'   => Auth::user()->id,
            'ticket_id' => strtoupper(str_random(10)),
            'category_id'  => $request->input('category'),
            'priority'  => $request->input('priority'),
            'message'   => $request->input('message'),
            'status'    => 1,
        ]);

        $ticket->save();

        return redirect()->back()->with("status", "O Chamado ID: #$ticket->ticket_id foi aberto.");
    }

    /**
     * Display a specified ticket.
     *
     * @param  int  $ticket_id
     * @return \Illuminate\Http\Response
     */
    public function show($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        print("<pre>".print_r($ticket->status,true)."</pre>"); 
     
        $comments = $ticket->comments;
        $category = $ticket->category;
        $status = $ticket->status;
        $priority = $ticket->priority;
        
        return view('tickets.show', compact('ticket', 'category', 'comments', 'status', 'priority'));
    }

    /**
     * Close the specified ticket.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function close($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $ticket->status = 4;

        $ticket->save();

        $ticketOwner = $ticket->user;

        return redirect()->back()->with("status", "O Chamado foi concluido.");
    }

 
}
