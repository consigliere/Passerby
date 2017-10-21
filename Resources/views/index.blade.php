@extends('passerby::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from component: {!! config('passerby.name') !!}
    </p>
@stop
