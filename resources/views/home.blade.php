@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">

                    @if (Auth::user()->is_admin)
                        @include('tickets.index')
                    @else
                        @include('tickets.user_tickets')
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection