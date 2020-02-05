<link href="{{ asset('css/fortis.css') }}" rel="stylesheet">
<link href="{{ asset('css/main.css') }}" rel="stylesheet">
<script>
function mark_unread()
{
    document.myform.action='{{ route('mark_unread_ticket') }}';
	document.myform.submit();
}
</script>



<table border='0' width='100%'>
@if ($ticket->client)
<tr><td><div class='msg_clientinfo'>
<table border='0' width='100%'><tr><td>
Клиент: <b>{{ $ticket->client->person }}</b><br>
Адрес: <b>{{ $ticket->client->address }}</b><br>
А/П: <b>{{ $ticket->client->payment }}</b>, Пультовый номер: <b>{{ $ticket->client->pult_number }}</b> 
Договор: <b>{{ $ticket->client->dogovor }}</b><br>
Телефон: <b>{{ $ticket->client->tel }} {{ $ticket->client->tel2 }} {{ $ticket->client->tel3 }}</b>
</td><td>


<!-- переход к карточке клиента -->
<a href='#' onclick="window.open('{{ route('view') }}?id={{ $ticket->client->id }}','newWin{{ $ticket->client->id }}', 'width=900,height=750,location=0,status=0,menubar=0,toolbar=0,directories=0,scrollbars=1'); return false;"><img src='{{ asset('img/ocard.png') }}' title='Карточка клиента'></a>
<!-- переход к карточке клиента -->
</td></tr></table></div>
</td></tr>
@endif


<tr><td><div width='100%'>

<div class='msg_incom'><table border='0' width='100%'><tr><td valign='top' width='110px'><img src='{{ asset('img/no_avatar.jpg') }}'  width='100px' height='100px'></td>
<td>{!! nl2br(e($ticket->mes)) !!}<br><br>
<font size='1'>Написал: <b>{{ $ticket->user_id }}</b> // <b>{{ $ticket->date }}</b></font></td></tr></table>
</div>

@FOREACH ($ticket->comments as $comment) 
<div class='msg_outcome'><table border='0' width='100%'><tr><td valign='top' width='110px'><img src='{{ asset('img/no_avatar.jpg') }}'  width='100px' height='100px'></td>
<td>{!! nl2br(e($comment->mes)) !!}<br><br>
<font size='1'>Написал: <b>{{ $comment->user_id }}</b> // <b>{{ $comment->created_at }}</b></font></td></tr></table>
</div>
@endforeach

</td></tr>

<tr><td>
<Form Action="{{ route('add_ticket_comment') }}" Method=post name=myform id=idmyform>
@if ($oper!='add')
<div class='no_print'><div class='msg_send'>	
<table border='0' width='100%'>
	<tr>
		<td><textarea rows='5' name='mes' cols='60' class='roundcorn2' placeholder='Введите текст для отправки...'></textarea></td>
		<td><input type='submit' value='Отправить сообщение' class='roundcorn2' style="width:200"><input type=hidden name=id value="{{ $ticket->id }}">		
		</td>
	</tr>
</table></div>
</div>
@endif

@IF ($oper=='add')		
	<table><tr valign=top><td>Отправлено в отдел:</td><td>
	@php
		$department_id = [$ticket->department_id];
	@endphp
			
	@FOREACH(Input::get('department_id')  as $dep_id)
	<b>{{ $department[$dep_id] }}</b><BR>		
	@endforeach 
	</td></tr></table>
@endif
<BR>

<div align=center>@if ($oper!='add')<input type='button' value='Отметить как непрочитанное' style="width:220" class='roundcorn2' onclick="mark_unread()"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;@endif<INPUT TYPE="button" VALUE="Закрыть" class='roundcorn2' onclick='javascript:window.opener.location.reload();window.open("", "_self");window.close();'"></div>
@csrf
</form>
</td></tr></table>
			
