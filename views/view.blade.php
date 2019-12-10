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
			<table border=1 width=600 align=center cellpadding=3 cellspacing=0>		
			<tr align=left>
			<td width=200>Наименование объекта:</td><td>{{ $client->name }}</td></tr>
			<tr><td>ГБР</td><td>{{ $client->gbr }}</td></tr>		
			<td>Тип охран. сигнализации:</td><td>{{ $client->type }}</td>			
			</tr>		
			<tr>
			<td>Пультовый объекта:</td><td>{{ $client->pult_number }}</td>
			</tr><TR>
			<td>Система охраны:</td><td>{{ $client->ohran_system }}</td>
			</tr>
			<td valign=top>Адрес объекта:</td><td>{{ $client->address }}</td></tr>
			<tr><td valign=top>ФИО Заказчика и доверенных лиц, контактные телефоны:</td><TD>{{ $client->person }}</td></tr></td>
			<tr><td>№ и дата договора:</td><td>{{ $client->dogovor }}</td></tr>
			<tr><td>Наличие ключей:</td><td>{{ $client->ikeys }}</td></tr>
			<tr><td>Абонент. плата:</td><td>{{ $client->payment }}</td></tr>
			<tr><td>Расчетное время:</td><td>{{ $client->time }}</td></tr>
			<tr><td>SIM - карта:</td><td>{{ $client->simcard }}</td></tr>			 
			<tr><td>Кадастровый номер:</td><td>{{ $client->kadastr }}</td></tr>
			</table>			 	
			<tr ><td align=center colspan=2><br><INPUT TYPE="button" VALUE="Изменить" onclick="javascript:window.location.href='edit?id={{ $client->id }}'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="button" VALUE="К списку объектов" onclick="javascript:window.location.href='{{ route('volok') }}'">
			@csrf
			</td></tr>
			</table>

</FORM>			
@endsection