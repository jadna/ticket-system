<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Comment;
use App\Mailers\AppMailer;


class CommentsController extends Controller
{
    public function postComment(Request $request, AppMailer $mailer)
    {
        $this->validate($request, [
            'comment'   => 'required'
        ]);

            $comment = Comment::create([
                'ticket_id' => $request->input('ticket_id'),
                'user_id'    => Auth::user()->id,
                'comment'    => $request->input('comment'),
            ]);


            return redirect()->route('home')->with("status", "Comentario salvo com sucesso.");
    }
}
