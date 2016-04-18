@extends('IM.email.html_template')

@section('title'){{ $title }}@endsection

@section('css')
	{{ Html::style('css/im.css') }}
@endsection

@section('script')
	{{ Html::script('js/im.js') }}
@endsection

@section('sidebar')
    @parent
@endsection

@section('content')
	<div class="content">
    	<div class="title">{{ $title }}</div>
    	<br/>
    	<br/>
    	<div>Your email account has been changed to {{ $email }}. Please login to {{ $email }} to activate it.</div>
    </div>
@endsection