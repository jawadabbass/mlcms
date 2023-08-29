@extends('errors.mlcms')
@section('title', $title)
@section('code', $code)
@section('message')
{!! $message !!}
@endsection
@section('image')<img src="{!! $image !!}"/>@endsection
