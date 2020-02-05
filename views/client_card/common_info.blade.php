	<table border=1 width=800 align=center cellpadding=3 cellspacing=0>				
			<tr align=left>
			<td width=200>Наименование объекта:</td><td>{{ $client->name }}</td></tr>
			<tr><td>ФИО Заказчика</td><TD>{{ $client->person }}</td></tr></td>
			<tr><td valign=top>Контактные телефоны</td>
			<TD>{{ $client->tel }}
					@IF ($client->tel2 !='') <BR>{{ $client->tel2 }}@endif
					@IF ($client->tel3 !='') <BR>{{ $client->tel3 }}@endif
			</td></tr>
			<tr><td>Email:</td><TD>{{ $client->email }}</td></tr></td>
			<tr><td>SMS информирование:</td><TD>{{ $sms_status[$client->sms] }}</td></tr></td>			
			<tr><td>ГБР:</td><td>{{ $client->gbr }}</td></tr>		
			<td>Тип охран. сигнализации:</td><td>{{ $client->type }}</td>			
			</tr>		
			<tr>
			<td>Пультовый объекта:</td><td>{{ $client->pult_number }}</td>
			</tr><TR>
			<td>Система охраны:</td><td>{{ $client->ohran_system }}</td>
			</tr>
			<td valign=top>Адрес объекта:</td><td>{{ $client->address }}</td></tr>		
			<tr><td>Статус клиента:</td><td>{{ $client->status_descr }}</td></tr>		
			<tr><td>№ и дата договора:</td><td>{{ $client->dogovor }}</td></tr>
			<tr><td>Наличие ключей:</td><td>{{ $client->ikeys }}</td></tr>
			<tr><td>Абонент. плата:</td><td>{{ $client->payment }}</td></tr>
			<tr><td>Расчетное время:</td><td>{{ $client->time }}</td></tr>
			<tr><td>SIM - карта:</td><td>{{ $client->simcard }}</td></tr>			 
			<tr><td>SIM - карта 2:</td><td>{{ $client->simcard2 }}</td></tr>	
			<tr><td>Кадастровый номер:</td><td>{{ $client->kadastr }}</td></tr>
	</table>