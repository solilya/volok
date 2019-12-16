@extends('layout')


@section('css')
h2 {text-align:center}
@endsection



@section('script')

@endsection



@section('content')
		

		<h2>Создание нового объекта охраны</h2>
		<Form Action="add" Method=post name=myform id=idmyform>
			<table border=0 width=600 align=center>		
			<tr align=left>
			<td width=200>Наименование объекта:</td><td ><INPUT TYPE="text" NAME="name" SIZE="50" MAXLENGTH="255" ></td></tr>
			<tr><td>ГБР</td><td>
			<select name="gbr">
		  	@foreach ($allgbr as $gbr)				
			<option value='{{ $gbr->gbr }}' >{{ $gbr->gbr }}</option>
			@endforeach
			</select>
			</td></tr>
		
			<td width=400>Тип охран. сигнализации:</td><td><INPUT TYPE="text" NAME="type" SIZE="20" MAXLENGTH="100" ></td>			
			</tr>		
			<tr>
			<td>Пультовый объекта:</td><td><INPUT TYPE="text" NAME="pult_number" SIZE="20" MAXLENGTH="20" ></td>
			</tr><TR>
			<td>Система охраны:</td><td>
			<INPUT TYPE="text" NAME="ohran_system" SIZE="50" MAXLENGTH="90" ></td>
			</tr>
			<td valign=top>Адрес объекта:</td><td><textarea NAME="address" cols="52" rows="7"></textarea></td></tr>
			<tr><td valign=top>ФИО Заказчика и доверенных лиц, контактные телефоны:</td><TD><textarea NAME="person" cols="52" rows="7"></textarea></td></tr></td>
			<tr><td>№ и дата договора:</td><td><INPUT TYPE="text" NAME="dogovor" SIZE="50" MAXLENGTH="100" ></td></tr>
			<tr><td>Наличие ключей:</td>
			<td><select name="ikeys">
					<option value='есть' >есть</option>
					<option value='нет'  >нет</option>
					</select>
			</td></tr>
			<tr><td>Абонент. плата:</td><td><INPUT TYPE="text" NAME="payment" SIZE="50" MAXLENGTH="100"></td></tr>
			<tr><td>Расчетное время:</td><td><INPUT TYPE="text" NAME="time" SIZE="50" MAXLENGTH="100" ></td></tr>
			<tr><td>SIM - карта:</td><td><INPUT TYPE="text" NAME="simcard" SIZE="50" MAXLENGTH="100" ></td></tr>			 
			<tr><td>Вторая SIM - карта:</td><td><INPUT TYPE="text" NAME="simcard2" SIZE="50" MAXLENGTH="100" ></td></tr>	
			<tr><td>Кадастровый номер:</td><td><INPUT TYPE="text" NAME="kadastr" SIZE="50" MAXLENGTH="100" ></td></tr>			 	
			<tr><td align=center colspan=2><br><INPUT TYPE="submit" VALUE="Создать">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="button" VALUE="К списку объектов" onclick="javascript:window.location.href='{{ route('volok') }}'">
			@csrf
			</td></tr>
			</table>
</FORM>			
@endsection