<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8">
    	<meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <base href="/" target="_self">
@section('css')
	{{ Html::style('css/jquery-ui/themes/base/jquery.ui.all.css') }}
@if (isset($theme))
    {{ Html::style('css/jquery-ui/themes/'.$theme.'/jquery-ui.min.css') }}
    {{ Html::style('css/jquery-ui/themes/'.$theme.'/jquery.ui.theme.css') }}
@endif	
	{{ Html::style('css/app.css') }}
@show
@section('script')
	{{ Html::script('js/browser.min.js', ['type' => 'text/javascript']) }}
	{{ Html::script('js/libraries.js', ['type' => 'text/javascript']) }}
	{{ Html::script('js/app.js', ['type' => 'text/javascript']) }}
	<script type="text/javascript">
@if (!$isGuest)
		var user = {!! $user !!};
@endif
		var ezsellMessage = '{{ $ezsellMessage }}';
		var cats = {!! $cats !!};
	</script>
@show
    </head>
    <body>
@section('top')
		<div class="container">
			<div id="leftmenu"></div>
			<div id="rightmenu">
				{!! $menu !!}
			</div>
		</div>
@show
        <div class="container" id="container">
@yield('content')
        </div>
@section('bottomscripts')
@show
    </body>
</html>