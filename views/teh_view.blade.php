@extends('layout')


@section('css')
h2 {text-align:center}
@endsection



@section('script')

@endsection



@section('content')
		

		<h2>Заявка № {{ $ticket->id }} на технические работы</h2>
		<Form Action="{{ route('volok') }}" Method=post name=myform id=idmyform>
		<table border=0 align=center>
		<tr><TD>
<ul class="nav nav-tabs"  role="tablist">
<li class="nav-item"><a class="nav-link active" role="tab" aria-controls="home" aria-selected="true" data-toggle="tab" href="#teh_ticket" >Тех. заявка</a></li>
@if ($client)<li class="nav-item"><a class="nav-link" role="tab" aria-controls="home" aria-selected="true" data-toggle="tab" href="#panel1" >Общая инфо</a></li>
<li class="nav-item"><a class="nav-link"  data-toggle="tab" href="#persons" role="tab" aria-controls="home" aria-selected="true">Доверенные лица</a></li>@endif
<li class="nav-item"><a class="nav-link"  data-toggle="tab" href="#photo" role="tab" aria-controls="home" aria-selected="true" ></a></li>
</ul>
<div class="tab-content">
<div class="tab-pane fade show active" id="teh_ticket">
	<table border=1 width=800 align=center cellpadding=3 cellspacing=0>				
			<tr align=left>
			<td width=200>Дата создания заявки:</td><td>{{ $ticket->date }}</td></tr>
			<tr><td>Сотрудник создавший заявку:</td><TD>{{ $ticket->user_id }}</td></tr>
			<tr><td>Назначенный техник:</td><TD>{{ $ticket->tehnik_id }}</td></tr>
			<tr><td>Статус заявки:</td><TD><B>{{ $ticket_status[$ticket->status] }}</b></td></tr>			
@if ($client)
			<tr><td>Адрес объекта:</td><td>{{ $client->address }}</td></tr>		
			<tr><td>Договор охраны:</td><td>{{ $client->dogovor }}</td></tr>
			<TR><td>Наименование объекта:</td><td>{{ $client->name }}</td></tr>
			<td>Система охраны:</td><td>{{ $client->ohran_system }}</td></tr>
			<tr><td>Контакты:</td><td>{{ $client->tel }} {{ $client->email }}</td></tr>		
@endif		
			<tr><td colspan=2><b>Текст заявки:</b><BR>{!! nl2br(e($ticket->mes)) !!}</td></tr>		
			<tr><td colspan=2>
			<b>Информация технического отдела:</b> 
@IF ($ticket->teh_comment )
<br>
			<table border='1' bgcolor='#FFFFCC' width='100%' style='border-collapse: collapse' bordercolor='#000000' cellpadding='5'>
			<tr><td>{!! nl2br($ticket->teh_comment) !!}</td></tr>			
			</table>
@endif
			</td></tr>
	</table>
	<BR>
	<div align=center ><br>
	@IF ($ticket->status==0) <!-- заявка только создано, требуется принять !-->
	<INPUT TYPE="button" VALUE="Принять заявку" onclick="javascript:window.location.href='{{ route('accept_teh_ticket') }}?ticket_id={{ $ticket->id }}'">
	@else	
	<INPUT TYPE="button" VALUE="Изменить" onclick="javascript:window.location.href='{{ route('edit_teh_ticket') }}?id={{ $ticket->id }}'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<INPUT TYPE="button" VALUE="Печать заказ-наряда" onclick="javascript:window.location.href='{{ route('print_zakaz_narjad') }}?id={{ $ticket->id }}'" style="width:200">
	@endif	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="button" VALUE="Закрыть" onclick='javascript: window.open("", "_self");window.close();'">

	@IF (($ticket->status!=0)&&($ticket->client_id))
	<br><br><INPUT TYPE="button" VALUE="Отправить СМС на прибор" onclick="javascript:window.location.href='{{ route('send_sms_for_pribor_form') }}?client_id={{ $ticket->client_id }}'" style="width:220">
	@endif
	
	</div>
</div>


@if ($client)
<div id="panel1"  class="tab-pane fade" >
@include('/client_card/common_info')			 	
<div align=center><br><INPUT TYPE="button" VALUE="Закрыть" onclick='javascript: window.open("", "_self");window.close();'"></div>
</div>			

<div id="persons" class="tab-pane fade">			
@include('/client_card/persons')			 	
<div align=center ><br><INPUT TYPE="button" VALUE="Закрыть" onclick='javascript: window.open("", "_self");window.close();'"></div>
@endif
</div>
</div>			
			</td></tr>
			</table>
			@csrf
</FORM>			
@endsection