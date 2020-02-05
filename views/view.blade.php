@extends('layout')


@section('css')
h2 {text-align:center}
@endsection



@section('script')

@endsection



@section('content')
		

		<h2>Объект охраны N {{ $client->id }}</h2>
		<Form Action="{{ route('volok') }}" Method=post name=myform id=idmyform>
		<table border=0 align=center>
		<tr><TD>
<ul class="nav nav-tabs"  role="tablist">
<li class="nav-item"><a class="nav-link active" role="tab" aria-controls="home" aria-selected="true" data-toggle="tab" href="#panel1" >Общая инфо</a></li>
<li class="nav-item"><a class="nav-link"  data-toggle="tab" href="#persons" role="tab" aria-controls="home" aria-selected="true">Доверенные лица</a></li>
<li class="nav-item"><a class="nav-link"  data-toggle="tab" href="#photo" role="tab" aria-controls="home" aria-selected="true" ></a></li>
</ul>
<div class="tab-content">
<div id="photo" class="tab-pane fade">
<BR>
</div>

<div id="panel1"  class="tab-pane fade show active" >
		@include('/client_card/common_info')			 	
			<div align=center><br><INPUT TYPE="button" VALUE="Изменить" onclick="javascript:window.location.href='{{ route('edit') }}?id={{ $client->id }}'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="button" VALUE="Закрыть" onclick='javascript: window.open("", "_self");window.close();'"></div>
			
</div>			
<div id="persons" class="tab-pane fade">			
@include('/client_card/persons')		
<div align=center ><br><INPUT TYPE="button" VALUE="Изменить" onclick="javascript:window.location.href='{{ route('view_helpers') }}?id={{ $client->id }}'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="button" VALUE="Закрыть" onclick='javascript: window.open("", "_self");window.close();'"></div>
</div>

			
			</td></tr>
			</table>
			@csrf
</FORM>			
@endsection