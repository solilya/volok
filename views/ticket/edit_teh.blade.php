@extends('layout')


@section('css')
h2 {text-align:center}
.width {width:320;}
@endsection



@section('script')

@endsection



@section('content')
		<script src='/assets/js/calendar.js' type='text/javascript'></script>
		<table border=0 width=600>
		<tr><td>		
		<h2>Заявка № {{ $ticket->id }} на технические работы</h2>
		</td></tr></table>
		<Form Action="{{ route('update_teh_ticket') }}" Method=post name=myform id=idmyform>
		<table border=0 align=center>
		<tr><TD>
	<table border=0 width=800 align=center cellpadding=3 cellspacing=0>				
			<tr align=left>
			<td width=200>Статус заявки:</td><TD width=600><B>{{ $ticket_status[$ticket->status] }}</b></td></tr>	
			<tr><td >Установить статус:</td>
			<td><select name="status" class=width>
			@foreach ($ticket_status as $status_id=>$status)	
				@if (($status_id!=0)&&($status_id!=10))<option value='{{ $status_id }}' @IF ($ticket->status==$status_id) selected 	@endif >{{ $status }}</option>@endif
			@endforeach
			</select>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="quick" @if ($ticket->quick==1) checked @endif value=1> <b>Срочно!</b></td></tr>
			<tr><td>Техник:</td><TD>{{ $ticket->tehnik_id }}</td></tr>					
			<tr><td>Дата проводимых работ:</td><TD><input type=text name="work_date" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)" value="{{ $ticket->work_date }}" class=width></td></tr>		
			<tr valign=top><td>Особые отметки:</td>
				<TD><input type="checkbox" name="TO" @if ($ticket->TO) checked @endif value="1"> Выезд по тех. обслуживанию (не учитывать как неисправность)<BR>
					<input type="checkbox" name="neopros" @if ($ticket->neopros) checked @endif value="1"> Отмечен как неопрос</td></tr>
			<tr><td colspan=2>Текст заявки:<BR><B>{!! nl2br(e($ticket->mes)) !!}<b></td></tr>					
			
			@if ($ticket->teh_comment)
			<tr><td colspan=2>
			Предыдущие комментарии тех. отдела:<BR>			
				<table border='1' bgcolor='#FFFFCC' width='100%' style='border-collapse: collapse' bordercolor='#000000' cellpadding='5'>
				<tr><td>{!! nl2br($ticket->teh_comment) !!}</td></tr>			
				</table>						
			</td></tr>
			@endif
			
			<tr><td colspan=2>Добавить комментарий: <BR>
			<textarea NAME="add_teh_comment" cols="72" rows="7"></textarea></td></tr>
			
			<tr><td >Тип заявки:</td>
			<td>
			<select name="type" class="width">
			@foreach ($ticket_type as $type_id=>$type)	
				<option value='{{ $type_id }}' @IF ($ticket->type==$type_id) selected 	@endif >{{ $type }}</option>
			@endforeach
			</select>
			</td></tr>		
			
			<tr><td><BR>Установить напоминание:</td>
			<TD><BR><select name="remind_id" class=width>
				<option value='0' @IF ($ticket->remind_id!=1) selected 	@endif >не устанавливать</option>
				<option value='1' @IF ($ticket->remind_id==1) selected 	@endif >установить</option>
			</select></td></tr>
			<tr><td>Дата напоминания:<BR><BR></td><TD>			
			<input type=text name="remind_date" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)" value="{{ $ticket->remind_id }}" class="width"><BR><BR></td></tr>					
			
			<tr><td>Заказ-наряд сдан:</td>
			<TD><select name="zakaz_naryad_made" class=width>
				<option value='0' @IF ($ticket->zakaz_naryad_made!=1) selected 	@endif >не сдан</option>
				<option value='1' @IF ($ticket->zakaz_naryad_made==1) selected 	@endif >сдан</option>
			</select></td></tr>
			<tr><td>Дата сдачи заказ-наряда:</td><TD>			
			<input type=text name="zakaz_naryad_date" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)" value="{{ $ticket->zakaz_naryad_date }}" class="width"></td></tr>					
			
	</table>
	<BR>
	<table border=0 width=600>
	<tr><td>
	<input type=hidden name=id value="{{ $ticket->id }}">
	<div align=center ><br><INPUT TYPE="submit" VALUE="Изменить" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<INPUT TYPE="button" VALUE="Закрыть" onclick='javascript: window.open("", "_self");window.close();'></div>
	</td></tr></table>
	
		
			</td></tr>
			</table>
			@csrf
</FORM>			
@endsection