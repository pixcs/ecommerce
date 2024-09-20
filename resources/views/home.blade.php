@extends('layouts.app')

@section('content')

    @if (Auth::user()->hasRole('super administrator') || Auth::user()->hasRole('administrator'))
        @yield('admin')
    @endif

    @if (Auth::user()->hasRole('user'))
        @yield('user')
    @endif

    @if (Auth::user()->hasRole('chat support'))
       @yield('chat-support')
    @endif
    
@endsection
