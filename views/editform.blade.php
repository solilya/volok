@extends('layout')


@section('css')
h2 {text-align:center}
@endsection



@section('script')

@endsection



@section('content')
		

		<h2>Редактирование информации об объекте охраны N {{ $client->id }}</h2>
			<Form Action="update" Method=post name=myform id=idmyform>
		
		<table border=0 align=center>
		<tr><TD>
		
@include('client_navbar', ['active' => 'main'])

<div class="tab-content">
<div id="photo" class="tab-pane fade">
<BR>
</div>

<div id="panel1"  class="tab-pane fade show active" >
		
			<table border=0 width=800 align=center>		
			<tr><td>
			<table border=0 width=600 align=left>		
			<tr align=left>
			<td width=200>Наименование объекта:</td><td >	<INPUT TYPE="text" NAME="name" SIZE="50" MAXLENGTH="255" value="{{ $client->name }}"></td></tr>
			<tr><td valign=top>ФИО Заказчика:</td><TD>
			<input type="text" NAME="person" size="50" maxlength="255" value="{{ $client->person }}"></td></tr>
			<tr valign="top"><td>Телефоны:</td>
			<td><input type="text" NAME="tel" size="50" maxlength="50" value="{{ $client->tel }}"><BR>
				<input type="text" NAME="tel2" size="50" maxlength="50" value="{{ $client->tel2 }}"><BR>
				<input type="text" NAME="tel3" size="50" maxlength="50" value="{{ $client->tel3 }}">
			</td></tr>
			<TR><TD>Email:</td>
<td><input type="text" NAME="email" size="50" maxlength="50" value="{{ $client->email }}"></td></tr>
			<tr><td>SMS информирование:</td>
			<td><select name="sms">
			@foreach ($sms_status as $sms_id=>$sms)	
				<option value='{{ $sms_id }}' @IF ($client->sms==$sms_id) selected 	@endif >{{ $sms }}</option>
			@endforeach
			</select>
			</td></tr>


			<tr><td>ГБР</td><td>
			<select name="gbr">
		  	@foreach ($allgbr as $gbr)				
			<option value='{{ $gbr->gbr }}' @IF ($gbr->gbr==$client->gbr) selected 	@endif >{{ $gbr->gbr }}</option>
			@endforeach
			</select>
			</td></tr>
		<TR>
			<td width=400>Тип охран. сигнализации:</td><td><INPUT TYPE="text" NAME="type" SIZE="20" MAXLENGTH="100" value="{{ $client->type }}"></td>			
			</tr>		
			<tr>
			<td>Пультовый объекта:</td><td><INPUT TYPE="text" NAME="pult_number" SIZE="20" MAXLENGTH="20" value="{{ $client->pult_number }}"></td>
			</tr><TR>
			<td>Система охраны:</td><td>
			<INPUT TYPE="text" NAME="ohran_system" SIZE="50" MAXLENGTH="90" value="{{ $client->ohran_system }}"></td>
			</tr>
			<td valign=top>Адрес объекта:</td><td><textarea NAME="address" cols="52" rows="7">{{ $client->address }}</textarea></td></tr>		
			<tr><td>Статус клиента:</td>
			<td><select name="status">
			@foreach ($status as $st=>$status_id)	
				<option value='{{ $st }}' @IF ($client->status==$st) selected 	@endif >{{ $status_id }}</option>
			@endforeach
			</select>
			</td></tr>
			<tr><td>№ и дата договора:</td><td><INPUT TYPE="text" NAME="dogovor" SIZE="50" MAXLENGTH="100" value="{{ $client->dogovor }}"></td></tr>
			<tr><td>Наличие ключей:</td>
				<td>
				<select name="ikeys">
					@IF (($client->ikeys!='есть')AND($client->ikeys!='нет'))
					<option value='{{ $client->ikeys }}' selected >{{ $client->ikeys }}</option>
					@endif
					<option value='есть' @IF ($client->ikeys=='есть') selected 	@endif >есть</option>
					<option value='нет' @IF ($client->ikeys=='нет') selected 	@endif >нет</option>
					</select></td></tr>
			<tr><td>Абонент. плата:</td><td><INPUT TYPE="text" NAME="payment" SIZE="50" MAXLENGTH="100" value="{{ $client->payment }}"></td></tr>
			<tr><td>Расчетное время:</td><td><INPUT TYPE="text" NAME="time" SIZE="50" MAXLENGTH="100" value="{{ $client->time }}"></td></tr>
			<tr><td>SIM - карта:</td><td><INPUT TYPE="text" NAME="simcard" SIZE="50" MAXLENGTH="100" value="{{ $client->simcard }}"></td></tr>			 
			<tr><td>Вторая SIM - карта:</td><td><INPUT TYPE="text" NAME="simcard2" SIZE="50" MAXLENGTH="100" value="{{ $client->simcard2 }}"></td></tr>			 
			<tr><td>Кадастровый номер:</td><td><INPUT TYPE="text" NAME="kadastr" SIZE="50" MAXLENGTH="100" value="{{ $client->kadastr }}"></td></tr>			 	
			<tr><td align=center colspan=2><br><INPUT TYPE="submit" VALUE="Изменить">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="reset" VALUE="Восстановить">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="button" VALUE="Закрыть" onclick='javascript: window.open("", "_self");window.close();'">
			@csrf
			</td></tr>
			</table>
	
				</td></tr>
			</table>

</div>




</div>
			
			<input type=hidden name=id value="{{ $client->id }}">
</FORM>		
</td></tr>
			</table>
	
	
@endsection