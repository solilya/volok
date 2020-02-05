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
		<h2>Заявки в техническом отделе</h2>
		@endif
		<table border=0 width=900 align=center >		
		<tr><td>
		</tr></td>
		</table>
		<form actrion="" method=GET>
<table border=0 >
<tr valign=top ><td>
 <a href='{{ route('list_teh_ticket') }}?lim={{ Input::get('lim') }}'>Отобразить все заявки</a>
<BR>
Показывать на каждой странице: 
@FOREACH ([20,30,40,80,120] as $lim)
@if (Input::get('lim')!=$lim)<a href='{{ route('list_teh_ticket') }}?lim={{ $lim }}&beg_date={{ Input::get('beg_date') }}&end_date={{ Input::get('end_date') }}&search={{ Input::get('search') }}'>@endif<span style='border-radius:10px; padding: 5px; background-color:#a9affe; margin-left:2;'>@if (Input::get('lim')!=$lim){{ $lim }}<span></span>@else<b>{{ $lim }}</b>@endif</span>@if (Input::get('lim')!=$lim)</a>@endif | 
@endforeach 
сообщений 
</td>
<td width=80>&nbsp;</td>
<td>
Поиск по заявкам <input type=text name="search" value="{{ Input::get('search') }}"><BR>
Найти записи с &nbsp;&nbsp;&nbsp;&nbsp;<input type=text name="beg_date"  onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"  value="{{ Input::get('beg_date') }}"> по <input type=text name="end_date"  onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)" value="{{ Input::get('end_date') }}"></td>
<td width=20>&nbsp;</td>
<td ><input type=hidden name=lim value="{{ Input::get('lim') }}"><BR>
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
$names = ['Номер заявки', 'Дата создания','Пультовый','Клиент','Адрес','Телефон','Система','Тип объекта','Статус','Заявка'];
@endphp		
		@FOREACH($names as $name)
		<td bgcolor='#000000' background="{{ asset('img/table_header.jpg') }}" align='center' @if (($name=='Дата создания')||($name=='Номер заявки'))width='80px'@endif ><font color='#FFFFFF'>{{ $name }}</font></td>
		@endforeach 		
		<td bgcolor='#000000' background="{{ asset('img/table_header.jpg') }}" align='center' width='140px'><font color='#FFFFFF'>Действия</font></td></tr>		

@FOREACH($tickets as $ticket)

@php
$bgcol="bgcolor='white'";
$bcol="white";

#статус заявки
if (isset($ticket->status))
{
	$ts=$ticket_status[$ticket->status];
}
else 
{
	$ts='';
}
if ($ts=="Заявка создана" or $ts=="Заявка создана в ТО"){
$bgcol="bgcolor='#FF9999'";
$bcol="#FF9999";
}
if ($ts=="Принято в ТО"){
$bgcol="bgcolor='#FFFFCC'";
$bcol="#FFFFCC";
}

if ($ts=="Запланирован выезд техника"){
$bgcol="bgcolor='#cdffcc'";
$bcol="#cdffcc";
}
if ($ts=="Заявка закрыта"){
$bgcol="bgcolor='#ffcccc'";
$bcol="#ffcccc";
}

if ($ts=="Заявка закрыта (без выезда техника)"){
$bgcol="bgcolor='#ffcccc'";
$bcol="#ffcccc";
}

if ($ts=="Приостановлено"){
$bgcol="bgcolor='#cecece'";
$bcol="#cecece";
}
if ($ts=="Требуется выезд техника"){
$bgcol="bgcolor='#befbff'";
$bcol="#befbff";
}
if ($ts=="Требуется отработка тех. поддержки"){
$bgcol="bgcolor='#6ba3c0'";
$bcol="#6ba3c0";
}
if ($ts=="Созвон с клиентом"){
$bgcol="bgcolor='#00ff06'";
$bcol="#00ff06";
}


if ($ticket['quick']==1){
$srochno_gif=asset('img/srochno_teh.gif');
$bgcol="bgcolor='#ffab3d' background=$srochno_gif";
$bcol="#ffab3d";	
}
 /*
if ($clie['vip']=="yes"){
$linecolor="white";	
$bgcol="bgcolor='#ffe6b5' background='../../assets/img/vip_fon.gif'";
$vipplate="<br><img src='../../assets/img/vip_plate.png' title='VIP-клиент!'>";
}
*/
@endphp

<tr align='center' id='{{ $ticket->id }}' {!! $bgcol !!}  >	
<td>{{ $ticket->id }}</td>
<td>{{ $ticket->date }}</td>
<td>@if ($ticket->client){{ $ticket->client->pult_number }}@endif</td>
<td>@if ($ticket->client){{ $ticket->client->name }}@endif</td>
<td>@if ($ticket->client){{ $ticket->client->address }}@endif</td>
<td width='130px'>@if ($ticket->client){{ $ticket->client->tel }}@endif</td>
<td>@if ($ticket->client){{ $ticket->client->ohran_system }}@endif</td>
<td>@if ($ticket->client){{ $ticket->client->type }}@endif</td>
<td>
	@if ($ticket['quick']) <b>СРОЧНО!</b><br> @endif
	@if (isset($ticket->status)){{ $ticket_status[$ticket->status] }}@endif</td>
<td>{{ $ticket->mes }}</td>
<td valign="middle">
@IF ($ticket->client)
<a href="#" onclick="window.open( '{{ route('teh_view') }}?id={{ $ticket->client->id }}&ticket_id={{ $ticket->id }}',
@else
<a href="#" onclick="window.open( '{{ route('teh_view') }}?ticket_id={{ $ticket->id }}',
@endif
	'newWinv{{ $ticket->id }}', 'width=900,height=750,location=0,status=0,menubar=0,toolbar=0,directories=0,scrollbars=1'); return false;" ><img src="{{ asset('img/view.png') }}" alt="Просмотр объекта" title="Просмотр объекта" width="50"></a> 

@IF ($ticket->client)

<a href="#" onclick="window.open( '{{ route('send_sms_for_pribor_form') }}?client_id={{ $ticket->client_id }}', 'newWinv{{ $ticket->id }}', 'width=900,height=750,location=0,status=0,menubar=0,toolbar=0,directories=0,scrollbars=1'); return false;" ><img src="{{ asset('img/sms.png') }}" alt="Отправить sms на прибор" title="Отправить sms на прибор" width="35" align="middle"></a> 
@endif

</td></tr>

		@endforeach 	
		</table>
		{{ $tickets->appends(Input::get())->onEachSide(2)->links() }}
		


</td>
</tr>
			</table>
	</div><!– /end.main – >
	
@endsection