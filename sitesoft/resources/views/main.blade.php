@extends('layout')


@section('content')

    @if(auth()->check())
        @include('main.form')
    @endif
    @include('main.messages')

@endsection