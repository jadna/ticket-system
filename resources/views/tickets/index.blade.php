@extends('layouts.app')


@section('title', 'All Tickets')

@section('content')
    <div class="content">
        <a href="{{ route('new_ticket') }}" class="btn btn-primary">Abrir Chamado</a>
        <br/>
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
                            <div class="col-md-3">
                                <div class="card text-white bg-secondary">
                                    <div class="card-body pb-3">
                                        <div class="text-value">{{ number_format($totalTickets) }}</div>
                                        <div>Total Chamados</div>
                                        <br />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card text-white bg-primary">
                                    <div class="card-body pb-3">
                                        <div class="text-value">{{ number_format($openTickets) }}</div>
                                        <div>Chamados Abertos</div>
                                        <br />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-white bg-danger">
                                    <div class="card-body pb-3">
                                        <div class="text-value">{{ number_format($lateTickets) }}</div>
                                        <div>Chamados Atrasados</div>
                                        <br />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card text-white bg-success">
                                    <div class="card-body pb-3">
                                        <div class="text-value">{{ number_format($closedTickets) }}</div>
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
                                        <th>Responsavel</th>
                                        <th>Data Aberto</th>
                                        <th>Data Alterado</th>
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
                                        @foreach ($priorities as $priority)
                                            @if ($priority->id === $ticket->priority_id)
                                                {{ $priority->name }}
                                            @endif
                                        @endforeach
                                        </td>
                                        <td>
                                        @foreach ($statuses as $status)
                                            @if ($status->id === $ticket->status_id)
                                                @if ($status->id === 1)
                                                    <span class="label label-success">{{ $status->name }}</span>
                                                @else
                                                    <span class="label label-danger">{{ $status->name }}</span>
                                                @endif
                                            @endif
                                        @endforeach
                                        </td>
                                        <td>
                                        @foreach ($employees as $employee)
                                            @if ($employee->id === $ticket->user_id)
                                                {{ $employee->name }}
                                            @endif
                                        @endforeach
                                        </td>
                                        <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
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