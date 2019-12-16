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
			<table border=0 width=900 align=center>		
			<tr>
			<td width=200>id объекта :<br>
			<INPUT TYPE="text" NAME="id" SIZE="20" MAXLENGTH="20" value="{{ old('id') }}"></td>
			<td width=360>Клиент :<br>
			<INPUT TYPE="text" NAME="name" SIZE="45" MAXLENGTH="255" value="{{ old('name') }}"></td>
			<td>ГБР :<BR>
			<INPUT TYPE="text" NAME="gbr" SIZE="30" MAXLENGTH="30" value="{{ old('gbr') }}"></td>
						
			</tr>
			<tr>
			<td>Пультовый объекта:<br>
			<INPUT TYPE="text" NAME="pult_number" SIZE="20" MAXLENGTH="20" value="{{ old('pult_number') }}"></td>
			<td>Адрес:<br>
			<INPUT TYPE="text" NAME="address" SIZE="45" MAXLENGTH="255" value="{{ old('address') }}"></td>
			<td>Договор :<BR>
			<INPUT TYPE="text" NAME="dogovor" SIZE="30" MAXLENGTH="100" value="{{ old('dogovor') }}"></td>
			</tr>			

	<tr><td colspan=3 align=center><BR><INPUT TYPE="button" VALUE="Новый клиент" onclick="javascript:window.location.href='{{ route('addform') }}'"">
&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="button" VALUE="Очистить" onclick="resetForm()">
&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="submit" VALUE="Поиск">
@csrf
</td>
</tr>
			</table>
</FORM>		
		</div><!– /end. form_find – >
</td></tr>
<tr><TD>		
		<div class="result" id=find_res>	
		<table border='1' width='100%' style='border-collapse: collapse' bordercolor='#000000'>
		<tr>
@php
$names = ['id клиента', 'Наименование объекта','Пультовый номер','ГБР','Система охраны','Адрес обьекта', 'ФИО Заказчика и доверенных лиц','№ и дата договора',  'Абонент. плата',	'Расчетное время',	'Статус'];
@endphp		
		@FOREACH($names as $name)
		<td bgcolor='#000000' background="{{ asset('img/table_header.jpg') }}" width='70px' align='center'><font color='#FFFFFF'>{{ $name }}</font></td>
		@endforeach 		
		<td bgcolor='#000000' background="{{ asset('img/table_header.jpg') }}" align='center' width='140px'><font color='#FFFFFF'>Действия</font></td></tr>		
		
		
		@FOREACH($clients as $client)		
		<tr onMouseover="bgColor='#fff6cd'" onMouseOut="bgColor='#cfe9fe'" bgcolor='#cfe9fe' align='center'> 		
		<td align='center'>{{ $client->id }}</td>
		<td align='center'>{{ $client->name }}</td>
		<td align='center'>{{ $client->pult_number }}</td>
		<td align='center'>{{ $client->gbr }}</td>
		<td align='center'>{{ $client->ohran_system }}</td>
		<td align='center'>{{ $client->address }}</td>
		<td align='center'>{{ $client->person }}</td>
		<td align='center' width=100>{{ $client->dogovor }}</td>	
		<td align='center'>{{ $client->payment }}</td>
		<td align='center'>{{ $client->time }}</td>
		<td align='center'></td>
		<td align='center' width=180><a href="{{ route('edit') }}?id={{ $client->id }}"><img src="{{ asset('img/edit.png') }}" alt="Редактировать" width="50"></a> <a href="{{ route('view') }}?id={{ $client->id }}"><img src="{{ asset('img/view.png') }}" alt="Детальный просмотр" width="50"></a> <a href="#"><img src="{{ asset('img/delete.png') }}" alt="Удалить" width="46" onClick="javascript:del({{ $client->id }})"></a></td>
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