@extends('home')

@section('admin')
   @include('dashboard.admin')
@endsection


@section('user')
   @include('dashboard.user')
@endsection

@section('chat-support')
  @include('dashboard.chat-support')
@endsection