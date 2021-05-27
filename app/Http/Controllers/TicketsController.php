<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use App\Http\Requests;
use App\Http\ReflectionClass;


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
        $tickets = Ticket::orderBy('updated_at', 'desc')->paginate(10);
        $categories = Category::all();
        $statuses  = Status::all();
        $priorities = Priority::all();
        $employees = User::all();
        $totalTickets = Ticket::count();
        $openTickets = Ticket::where('status_id', 1)->count();
        $lateTickets = Ticket::where('status_id', 3)->count();
        $closedTickets = Ticket::where('status_id', 4)->count();
        /*$employee = DB::table('tickets')
        ->join('users', 'users.id', '=', 'tickets.user_id')
        ->select('users.name as user')
        ->get();*/

        $now = date('Y-m-d');
        $res = Ticket::where('created_at', '<', $now)
            ->update(['status_id' => 3]);

        //print("<pre>".print_r($res,true)."</pre>"); 

        return view('tickets.index', compact('tickets', 'categories', 'statuses', 'priorities','employees', 'totalTickets', 'openTickets','closedTickets', 'lateTickets'));
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
        
        $qnty_user = Ticket::join('users', 'users.id', '=', 'tickets.user_id')
        ->selectRaw('COUNT(tickets.id) as qnty, users.id as userId')
        ->groupBy('tickets.user_id')
        ->orderBy('qnty')
        ->get(['qnty', 'users.id as userId']);

        $qnty_user = $qnty_user->toArray();
        //print("<pre>".print_r($qnty_user[0]['userId'],true)."</pre>"); 
 
        $ticket = new Ticket([
            'title'     => $request->input('title'),
            //'user_id'   => Auth::user()->id,
            'user_id'   => $qnty_user[0]['userId'],
            'ticket_id' => strtoupper(str_random(10)),
            'category_id'  => $request->input('category'),
            'priority_id'  => $request->input('priority'),
            'message'   => $request->input('message'),
            'status_id'    => 1,
        ]);

        $ticket->save();

        return redirect()->route('home')->with("status", "O Chamado ID: #$ticket->ticket_id foi aberto.");

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
        //print("<pre>".print_r($ticket->status,true)."</pre>"); 
     
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

        $ticket->status_id = 4;

        $ticket->save();

        $ticketOwner = $ticket->user;

        return redirect()->back()->with("status", "O Chamado foi concluido.");
    }

 
}
