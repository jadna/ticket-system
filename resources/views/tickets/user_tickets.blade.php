@extends('layouts.app')

@section('title', 'My Tickets')

@section('content')
    <div class="row">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('new_ticket') }}">Abrir Chamado</a>
        </li>
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-ticket">Chamados</i>
                </div>

                <div class="panel-body">
                    @if ($tickets->isEmpty())
                        <p>Não existem chamados.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Categoria</th>
                                    <th>Assunto</th>
                                    <th>Prioridade</th>
                                    <th>Status</th>
                                    <th>Data</th>
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
                                        @if ($priority->id === $ticket->priority)
                                            {{ $priority->name }}
                                        @endif
                                    @endforeach
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
@endsection