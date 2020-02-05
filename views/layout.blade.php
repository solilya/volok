<HTML>
<HEAD>
<TITLE>CRM система "Волоколамск"</TITLE>
<meta name="viewport" content="initial-scale=1.0">
<link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/main.css') }}" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>

<style type="text/css">
@yield('css')
</style>

<script>
@yield('script')
</script>

</HEAD>

<BODY BACKGROUND="" BGCOLOR="#C0c0c0" TEXT="#000000" LINK="#0000ff" VLINK="#800080" ALINK="#ff0000">
<div id="page">
@yield('content')
</div><!– /end #page – >


</BODY>
</HTML>