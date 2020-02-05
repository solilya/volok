@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')

@section('message')
Из-за долгой неактивности, отправленные данные устарели. <BR>
Вернитесь на обратно на <a href="{{ route("volok") }}">главную страницу</a>.
@endsection
