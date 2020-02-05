@extends('layout')


@section('css')
h2 {text-align:center}
.msg_counter{
background:url('{{ asset('img/msg_counter_icon.png') }}') no-repeat;
width:43px;
height:23px;
float: right;
text-align:center;
padding-top:3px;
}

input[type=button] {
    width: 10em;  height: 2em;

input[type=submit] {
    width: 10em;  height: 2em;
}
@endsection



@section('script')
@endsection



@section('content')
<script src='/assets/js/calendar.js' type='text/javascript'></script>
	<div id="main"  >
		<table border=0 width=100%>
		<tr><TD>
		@if (Input::get('search')!='')		
		<h2>Заявки, в которых встречается сочетание "{{ Input::get('search') }}"</h2>
		@else
		<h2>Заявки в отделы</h2>
		@endif
		<table border=0 width=900 align=center >		
		<tr><td>
		</tr></td>
		</table>
		<form actrion="" method=GET>
<table border=0 >
<tr valign=top ><td>
	<span style='border-radius:10px; padding: 5px; background-color:#CCFFCC; margin-left:2;'>
	@if (Input::get('all')!=0)<a href='{{ route('list_ticket') }}?all=0&lim={{ Input::get('lim') }}'>Только непрочитанные</a>
	@else
		<b>Только непрочитанные</b>
	@endif
	</span>
    <span style='border-radius:10px; padding: 5px; background-color:#fd9fac; margin-left:2;'>
    @if ((Input::get('all')!=1)||(Input::get('search'))||(Input::get('beg_date'))||(Input::get('end_date')))
    <a href='{{ route('list_ticket') }}?all=1&lim={{ Input::get('lim') }}'>Все</a>
   	@else
   	<b>Все</b>
   	@endif
    </span><BR><BR>


Показывать на каждой странице: 
@FOREACH ([20,30,40,80,120] as $lim)
@if (Input::get('lim')!=$lim)<a href='{{ route('list_ticket') }}?all={{ Input::get('all') }}&lim={{ $lim }}&beg_date={{ Input::get('beg_date') }}&end_date={{ Input::get('end_date') }}&search={{ Input::get('search') }}'>@endif<span style='border-radius:10px; padding: 5px; background-color:#a9affe; margin-left:2;'>@if (Input::get('lim')!=$lim){{ $lim }}<span></span>@else<b>{{ $lim }}</b>@endif</span>@if (Input::get('lim')!=$lim)</a>@endif | 
@endforeach 
сообщений 
</td>
<td width=80>&nbsp;</td>
<td>
Поиск по заявкам <input type=text name="search" value="{{ Input::get('search') }}"><BR>
Найти записи с &nbsp;&nbsp;&nbsp;&nbsp;<input type=text name="beg_date"  onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"  value="{{ Input::get('beg_date') }}"> по <input type=text name="end_date"  onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)" value="{{ Input::get('end_date') }}"></td>
<td width=20>&nbsp;</td>
<td ><input type=hidden name=lim value="{{ Input::get('lim') }}"><input type=hidden name=all value="1" ><BR>
<input type=submit value="Поиск">
</td>
<td width=20>&nbsp;</td>
<TD>
<a href="{{ route('volok') }}">Клиентская БД</a><BR>
<a href="{{ route('volok') }}" onclick="alert('Найдите нужного клиента в БД и нажмите на иконку стрелки для создания заявки');return true;">Создать заявку с привязкой к клиенту</a><BR>
<a href="#" onclick="window.open('{{ route('addform_ticket') }}?free_ticket=1','addfreeTicket', 'width=900,height=850,location=0,status=0,menubar=0,toolbar=0,directories=0,scrollbars=1'); return false;" >Создать заявку в свободной форме</a><BR>
</td>
</tr></table>

</form><br>

		<table border='1' width='100%' style='border-collapse: collapse' bordercolor='#000000' cellpadding=3>
		<tr>
@php
$names = ['Номер заявки', 'Дата создания','Создал','Кому','Клиент','Статус'];
@endphp		
		@FOREACH($names as $name)
		<td bgcolor='#000000' background="{{ asset('img/table_header.jpg') }}" align='center' @if (($name=='Дата создания')||($name=='Номер заявки'))width='80px'@endif ><font color='#FFFFFF'>{{ $name }}</font></td>
		@endforeach 		
		<td bgcolor='#000000' background="{{ asset('img/table_header.jpg') }}" align='center' width='140px'><font color='#FFFFFF'>Действия</font></td></tr>		
		
		
		@FOREACH($tickets as $ticket)		
		<tr @if ($ticket->read == 0)bgcolor="#FFFFCC"@else bgcolor='#cfe9fe'@endif align='center'> 		
		<td>{{ $ticket->id }}</td>
		<td  width='80px' >{{ $ticket->date }}</td>
		<td>{{ $ticket->user_id }}</td>
		<td>{{ $department[$ticket->department_id] }}</td>
		<td>@if ($ticket->client) {{ $ticket->client->person }}@endif</td>
		<td width=200>@IF ($ticket->read == 0) <B>Новое сообщение</b> @else Нет новых сообщений @endif<div class='msg_counter'>{{ $ticket->num_mes }}</div></td>
		<td><a href="#" onclick="window.open( '{{ route('view_ticket') }}?id={{ $ticket->id }}','newWinv{{ $ticket->id }}', 'width=900,height=750,location=0,status=0,menubar=0,toolbar=0,directories=0,scrollbars=1'); return false;" ><img src="{{ asset('img/view.png') }}" alt="Детальный просмотр" title="Детальный просмотр" width="50"></a> 
</td>	
		</tr>
		@endforeach 	
		</table>
		{{ $tickets->appends(Input::get())->onEachSide(2)->links() }}
		


</td>
</tr>
			</table>
	</div><!– /end.main – >
	
@endsection