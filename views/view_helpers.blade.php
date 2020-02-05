@extends('layout')


@section('css')
h2 {text-align:center}
@endsection



@section('script')

@endsection



@section('content')
		

		<h2>Редактирование информации об объекте охраны N {{ $client->id }}</h2>
		
		<table border=0 align=center>
		<tr><TD>
		
@include('client_navbar', ['active' => 'helpers'])


<div id="persons" class="tab-pane fade show active" >			
<table border=1 width=800 align=center cellpadding=3 cellspacing=0>				
<tr align=left>
<td>ФИО</td><td width=120>Телефон</td><td>E-mail</td><td>Описание</td><TD width=120>&nbsp;</TD></tr>
<!-- собственник -->
<tr><td><b>{{ $client->person }}</td>
<td><b>{{ $client->tel }} 
	@IF ($client->tel2 !='') <BR>{{ $client->tel2 }}@endif
	@IF ($client->tel3 !='') <BR>{{ $client->tel3 }}@endif
</b>
	@IF (($client->sms==2)or($client->sms==3))
	<font style='font-size: 8pt;font-weight:700' color='#666666'>	
	<br>{{ $sms_status[$client->sms] }}</font>
	@endif
</td>
<td><b>{{ $client->email }}</b></td>
<td><b>cобственник объекта</b></td>
<td>&nbsp;</td>
</tr>

	@foreach ($client->client_helpers as $person)
<tr>
<td>{{ $person->name }}
@IF (($person->operational==1)or($person->opening==1))

<font style='font-size: 8pt;font-weight:700' color='#666666'>
@IF ($person->operational==1)
<BR>Ответственный за эксплуатацию
@endif
@IF ($person->opening==1)
<br>Ответственный за вскрытие
@endif
</font>

@endif
</td>
<td>{{ $person->tel }} 
	@IF ($person->tel2 !='') <BR>{{ $person->tel2 }}@endif
	@IF ($person->tel3 !='') <BR>{{ $person->tel3 }}@endif
	
	@IF (($person->sms==2)or($person->sms==3))
	<font style='font-size: 8pt;font-weight:700' color='#666666'>	
	<br>{{ $sms_status[$person->sms] }}</font>
	@endif
</td>
<td>{{ $person->email }}  </td>
<td>{{ $person->descr }} &nbsp;</td>
<td><a href="{{ route('edit_helpers') }}?id={{ $person->id }}" ><img src="{{ asset('img/edit.png') }}" alt="Редактировать" width="50" ></a> <a href="{{ route('del_helpers') }}?id={{ $client->id }}&del_helper_id={{ $person->id }}"><img src="{{ asset('img/delete.png') }}" alt="Удалить" width="46" ></a></td>
			</tr>
@endforeach

</td></tr>
			</table>
			
			
@include('addhelper_form')						
			
			
</div>


</td></tr>

</table>


@endsection