@extends('layout')


@section('css')
h2 {text-align:center}
@endsection



@section('script')

@endsection



@section('content')
		

		<h2>Редактирование информации об объекте охраны N {{ $person->client_id }}</h2>
			<Form Action="update_helpers" Method=post name=myform id=idmyform>
		
		<table border=0 align=center>
		<tr><TD>
		
@include('client_navbar', ['active' => 'helpers'])

<input type=hidden name="id" value="{{ $person->id }}">
<div id="persons" class="tab-pane fade show active" >			
<table border=0 width=800 align=center>		
<tr><td>
<table border=0 width=680>
<tr><td>
ФИО:</td><td>
<input type="text" NAME="name" size="50" maxlength="255" value="{{ $person->name }}"></td>
<td><input type="radio" name='sms' value="1"  @IF ($person->sms=="1") checked 	@endif>{{ $sms_status[1] }} </td>
</tr>
<tr valign="top"><td>Телефоны:</td>
<td><input type="text" NAME="tel" size="50" maxlength="50" value="{{ $person->tel }}"> 
<BR><input type="text" NAME="tel2" size="50" maxlength="50" value="{{ $person->tel2 }}">
<BR><input type="text" NAME="tel3" size="50" maxlength="50" value="{{ $person->tel3 }}">
</td>
<td><input type="radio" name='sms' value="2" @IF ($person->sms=="2") checked 	@endif>{{ $sms_status[2] }} <BR>
<input type="radio" name='sms' value="3" @IF ($person->sms=="3") checked 	@endif>{{ $sms_status[3] }} </td>

</tr>
<TR><TD>Email:</td>
<td><input type="text" NAME="email" size="50" maxlength="50" value="{{ $person->email }}"></td></tr>
<tr valign="top"><td>Описание:</td>
<td><textarea NAME="descr" cols="52" rows="7">{{ $person->descr }}</textarea></td>
<td><input type="checkbox" name="operational" value=1 @IF ($person->operational=="1") checked 	@endif>эксплуатация<BR>
<input type="checkbox" name="opening" value=1 @IF ($person->opening=="1") checked 	@endif>вскрытие
</td></tr>

<tr><td align=center colspan=2><br><INPUT TYPE="submit" VALUE="Изменить">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="reset" VALUE="Восстановить">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="button" VALUE="Закрыть" onclick='javascript: window.open("", "_self");window.close();'">
			@csrf
</td><td>&nbsp;</td></tr>
</table>
</td></tr>
</table>
</div>

</td>	

</tr>
</table>
</form>