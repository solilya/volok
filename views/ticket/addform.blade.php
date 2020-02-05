@extends('layout')


@section('css')
h2 {text-align:center}
@endsection



@section('script')
function check_form()
{
  var checkbox = document.querySelectorAll('input[type=checkbox]');
  var i = 0;
  var choosed=false;
  
  for (; i < checkbox.length; i++) 
  {
    var check = checkbox[i];
    if (check.checked) 
    {
        choosed = true;
    }
  }	
	if (!choosed)
    { 
    	alert('Выберите отдел для оправления заявки!');  
    	return false;  	
    }     
   
    var mes =document.myform.mes.value;
	if 	(mes=='')
	{
		alert('Напишите текст заявки!');
		return false;
	}    
}
@endsection



@section('content')
		

		<h2>Новая заявка</h2>
		<Form Action="add_ticket" Method=post name=myform id=idmyform onsubmit="return check_form()" >

		@IF (!Input::get('free_ticket')) 
			<input type=hidden name="client_id" value="{{ $client->id }}">
			<table border=0 width=700 align=center>		
			<tr align=left>
			<td width=200>Наименование объекта:</td><td >{{ $client->name }}</td></tr>
			<tr><td valign=top>ФИО Заказчика:</td><TD>{{ $client->person }}</td></tr>
			<tr><td valign=top>Адрес объекта:</td><TD>{{ $client->address }}</td></tr>
			<tr valign="top"><td>Телефоны:</td>
			<td>{{ $client->tel }}
					@IF ($client->tel2 !=''), {{ $client->tel2 }}@endif
					@IF ($client->tel3 !=''), {{ $client->tel3 }}@endif
			<BR><BR>		
					</td></tr>
		@else
			<input type=hidden	name='free_ticket' value=1>
			<table border=0 width=700 align=center>	
		@endif
			<tr valign=top><td>Направить в отдел:</td>
			<td>
			@foreach ($department as $dep_id=>$dep)	
				<input type="checkbox" value='{{ $dep_id }}' name="department_id[]">{{ $dep }}<BR>
			@endforeach
			</td></tr>

	
			<tr>
			<td valign=top>Текст заявки:</td><td><textarea NAME="mes" cols="72" rows="15"></textarea></td></tr>
			
			<tr><td align=center colspan=2><br><INPUT TYPE="submit" VALUE="Создать" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="button" VALUE="Закрыть" onclick='javascript: window.open("", "_self");window.close();'">
			@csrf
			</td></tr>
			</table>
</FORM>			
@endsection