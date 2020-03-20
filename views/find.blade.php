@extends('layout')


@section('css')

.form_find{
margin: 10px;
}
@endsection



@section('script')
function resetForm()
{
	document.forms["myform"]["id"].value='';
	document.forms["myform"]["name"].value='';
	document.forms["myform"]["dogovor"].value='';
	document.forms["myform"]["pult_number"].value='';
	document.forms["myform"]["address"].value='';
	document.forms["myform"]["gbr"].value='';		
	document.forms["myform"].status.selectedIndex = 0;
}

function del(del_id)
{
	if (!confirm("Удалить объект?")) { return false }
	var del_input = document.createElement("input");
	del_input.setAttribute("type", "hidden");
	del_input.setAttribute("name", "del_id");
	del_input.setAttribute("value", del_id);
	document.getElementById("idmyform").appendChild(del_input);
	document.forms["myform"].submit();
}
@endsection



@section('content')
	<div id="main"  >
		<table border=0 width=100%>
		<tr><td width=100%>	
		<div class="form_find" >
		<Form Action="" Method=post name=myform id=idmyform>
			<table border=0 width=900 align=center >		
			<tr>
			<td width=200>id объекта:<br>
			<INPUT TYPE="text" NAME="id" SIZE="20" MAXLENGTH="20" value="{{ old('id') }}"></td>
			<td width=360>Клиент:<br>
			<INPUT TYPE="text" NAME="name" SIZE="45" MAXLENGTH="255" value="{{ old('name') }}"></td>
			<td>ГБР :<BR>
			<INPUT TYPE="text" NAME="gbr" SIZE="30" MAXLENGTH="30" value="{{ old('gbr') }}"></td>
			<td>Статус клиента:<br>
		    <select name="status" >
		    <option value=''></option>
			@foreach ($status as $st=>$status_id)	
				<option value='{{ $st }}' @IF ($st==old('status')) selected 	@endif>{{ $status_id }}</option>
			@endforeach
			</select>
			</td></tr>						
			
			<tr>
			<td>Пультовый объекта:<br>
			<INPUT TYPE="text" NAME="pult_number" SIZE="20" MAXLENGTH="20" value="{{ old('pult_number') }}"></td>
			<td>Адрес:<br>
			<INPUT TYPE="text" NAME="address" SIZE="45" MAXLENGTH="255" value="{{ old('address') }}"></td>
			<td width=240>Договор :<BR>
			<INPUT TYPE="text" NAME="dogovor" SIZE="30" MAXLENGTH="100" value="{{ old('dogovor') }}"></td>
			<TD> &nbsp;</td>
			</tr>			

	<tr><td colspan=4 align=center><BR><INPUT TYPE="button" VALUE="Новый клиент" onclick="javascript:window.open('{{ route('addform') }}','addform', 'width=900,height=750,location=0,status=0,menubar=0,toolbar=0,directories=0,scrollbars=1'); return false;" >&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="button" VALUE="Очистить" onclick="resetForm()">
&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="submit" VALUE="Поиск">
&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="button" VALUE="Заявки" onclick="javascript:window.location.href = '{{ route('list_ticket') }}'; return false;";>
@csrf
</td>
</tr>
			</table>
</FORM>		
		</div><!– /end. form_find – >
</td></tr>
<tr><TD>		
		<div class="result" id=find_res>	
		<table border='1' width='100%' style='border-collapse: collapse' bordercolor='#000000' cellpadding=3>
		<tr>
@php
$names = ['id клиента', 'Наименование объекта','Пультовый номер','ГБР','Система охраны','Адрес обьекта', 'ФИО Заказчика','Телефон','№ и дата договора',  'Абонент. плата',	'Расчетное время',	'Статус'];
$todel=0;
@endphp		
		@FOREACH($names as $name)
		<td bgcolor='#000000' background="{{ asset('img/table_header.jpg') }}" align='center'><font color='#FFFFFF'>{{ $name }}</font></td>
		@endforeach 		
		<td bgcolor='#000000' background="{{ asset('img/table_header.jpg') }}" align='center' width='140px'><font color='#FFFFFF'>Действия</font></td></tr>		
		
@can('check_rights', 'del_clients')
	<?php $todel=1; ?>
@endcan
		
		@FOREACH($clients as $client)		
		<tr onMouseover="bgColor='#fff6cd'" onMouseOut="bgColor='#cfe9fe'" bgcolor='#cfe9fe' align='center'> 		
		<td>{{ $client->id }}</td>
		<td>{{ $client->name }}</td>
		<td>{{ $client->pult_number }}</td>
		<td width=50>{{ $client->gbr }}</td>
		<td>{{ $client->ohran_system }}</td>
		<td >{{ $client->address }}</td>
		<td>{{ $client->person }}</td>
		<td width=120>{{ $client->tel }}
		@IF ($client->tel2 !='')<br>{{ $client->tel2 }}@endif
		@IF ($client->tel3 !='')<br>{{ $client->tel3 }}@endif</td>
		<td width=130>{{ $client->dogovor }}</td>	
		<td>{{ $client->payment }}</td>
		<td>{{ $client->time }}</td>
		<td>@IF ($client->status !='') {{ $status[$client->status] }} @endif</td>
		<td width=240><a href="#" onclick="window.open( '{{ route('edit') }}?id={{ $client->id }}','newWine{{ $client->id }}', 'width=900,height=850,location=0,status=0,menubar=0,toolbar=0,directories=0,scrollbars=1'); return false;" ><img src="{{ asset('img/edit.png') }}" alt="Редактировать" title="Редактировать" width="50"></a> <a href="#" onclick="window.open( '{{ route('view') }}?id={{ $client->id }}','newWinv{{ $client->id }}', 'width=900,height=750,location=0,status=0,menubar=0,toolbar=0,directories=0,scrollbars=1'); return false;" ><img src="{{ asset('img/view.png') }}" alt="Детальный просмотр" title="Детальный просмотр" width="50"></a> 
		<a href="#" onclick="window.open( '{{ route('addform_ticket') }}?id={{ $client->id }}','addTicket{{ $client->id }}', 'width=900,height=850,location=0,status=0,menubar=0,toolbar=0,directories=0,scrollbars=1'); return false;" ><img src="{{ asset('img/arrow.png') }}" alt="Создать заявку в отделы" title="Создать заявку в отделы" width="50"></a> 
		

		@if ($todel==1)
		<a href="#"><img src="{{ asset('img/delete.png') }}" alt="Удалить" title="Удалить" width="46" onClick="javascript:del({{ $client->id }})"></a></td>
		@endif
	
		</tr>
		@endforeach 	
		</table>
		{{ $clients->appends(Input::get())->onEachSide(2)->links() }}
		
		
			
		
		</div><!– /end.result – >

</td>
</tr>
			</table>
	</div><!– /end.main – >
	
@endsection