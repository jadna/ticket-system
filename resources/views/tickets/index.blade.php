@extends('layouts.app')
@extends('tickets.create')

@section('title', 'All Tickets')

@section('content')
    <div class="content">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('new_ticket') }}">Abrir Chamado</a>
        </li>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Dashboard
                    </div>

                    <div class="card-body">
                        @if(session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-4">
                                <div class="card text-white bg-primary">
                                    <div class="card-body pb-3">
                                        <div class="text-value">{{ number_format(1) }}</div>
                                        <div>Total Chamados</div>
                                        <br />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card text-white bg-success">
                                    <div class="card-body pb-3">
                                        <div class="text-value">{{ number_format(1) }}</div>
                                        <div>Chamados Abertos</div>
                                        <br />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card text-white bg-danger">
                                    <div class="card-body pb-3">
                                        <div class="text-value">{{ number_format(1) }}</div>
                                        <div>Chamados Fechados</div>
                                        <br />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-ticket"> Tickets</i>
                    </div>

                    <div class="panel-body">
                        @if ($tickets->isEmpty())
                            <p>There are currently no tickets.</p>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Categoria</th>
                                        <th>Assunto</th>
                                        <th>Prioridade</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                        <th style="text-align:center" colspan="2">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>
                                        @foreach ($categories as $category)
                                            @if ($category->id === $ticket->category_id)
                                                {{ $category->name }}
                                            @endif
                                        @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ url('tickets/'. $ticket->ticket_id) }}">
                                                #{{ $ticket->ticket_id }} - {{ $ticket->title }}
                                            </a>
                                        </td>
                                        <td>
                                        @foreach ($status as $statu)
                                            @if ($statu->id === $ticket->status)
                                                @if ($statu->id === 1)
                                                    <span class="label label-success">{{ $statu->name }}</span>
                                                @else
                                                    <span class="label label-danger">{{ $statu->name }}</span>
                                                @endif
                                            @endif
                                        @endforeach
                                        </td>
                                        <td>{{ $ticket->updated_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ url('tickets/' . $ticket->ticket_id) }}" class="btn btn-primary">Comment</a>
                                        </td>
                                        <td>
                                            <form action="{{ url('admin/close_ticket/' . $ticket->ticket_id) }}" method="POST">
                                                {!! csrf_field() !!}
                                                <button type="submit" class="btn btn-danger">Close</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {{ $tickets->render() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection