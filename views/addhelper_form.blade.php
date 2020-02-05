<form action="add_helpers" method=post>
<table border=0 width=800 align=center>		
<tr><td>
<table border=0 width=680 align=center>
<tr><td colspan=3><BR><h2>Добавить доверенное лицо</h2></td></tr>
<tr align=left><td>
ФИО:</td><td>
<input type="text" NAME="name" size="50" maxlength="255" ></td>
<td><input type="radio" name='sms' value="1" checked>{{ $sms_status[1] }}  </td>
</tr>
<tr valign="top" align=left><td>Телефоны:</td>
<td><input type="text" NAME="tel" size="50" maxlength="50" > 
<BR><input type="text" NAME="tel2" size="50" maxlength="50">
<BR><input type="text" NAME="tel3" size="50" maxlength="50">
</td>
<td><input type="radio" name='sms' value="2" > {{ $sms_status[2] }} <BR>
<input type="radio" name='sms' value="3" >{{ $sms_status[3] }} </td>

</tr>
<TR align=left><TD>Email:</td>
<td><input type="text" NAME="email" size="50" maxlength="50" ></td></tr>
<tr valign="top"><td>Описание:</td>
<td><textarea NAME="descr" cols="52" rows="7"></textarea></td>
<td><input type="checkbox" name="operational" value=1>эксплуатация<BR>
<input type="checkbox" name="opening" value=1 >вскрытие
</td></tr>

<tr align=left><td align=center colspan=2><br><INPUT TYPE="submit" VALUE="Добавить">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="button" VALUE="Закрыть" onclick='javascript: window.open("", "_self");window.close();'><input type=hidden name="client_id" value="{{ $client->id }}">
			@csrf
</td><td>&nbsp;</td></tr>
</table>

</td></tr></table>

</form>