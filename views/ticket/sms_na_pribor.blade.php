<link href="{{ asset('css/main.css') }}" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link href="{{ asset('js/showcon2.js') }}" rel="stylesheet" type='text/javascript'>
 
 
 
@php 
$sim1=$client['simcard'];
$sim1=str_replace("(","",$sim1);
$sim1=str_replace(")","",$sim1);
$sim1=str_replace(" ","",$sim1);
$sim1=str_replace("+","",$sim1);
$sim1=str_replace("-","",$sim1);
$sim2=$client['simcard2'];
$sim2=str_replace("(","",$sim2);
$sim2=str_replace(")","",$sim2);
$sim2=str_replace(" ","",$sim2);
$sim2=str_replace("+","",$sim2);
$sim2=str_replace("-","",$sim2); 
@endphp 
 
   
<script>
function refreshsms()  
{  
	alert('{{ route('sms_history_for_pribor') }}?id={{ $client->id }}&sim1={{ $sim1 }}&sim2={{ $sim2 }}');
	showContent('{{ route('sms_history_for_pribor') }}?id=${{ $client->id }}&sim1={{ $sim1 }}&sim2={{ $sim2 }}');		
}  

function shablchange(){
document.getElementById("txt").value=document.getElementById("shabl").value;
}

      
$(document).ready(function(){        
setInterval('refreshsms()',6000);  
if ($('#shabl option[value!=""]').first().val()) 
	{ document.getElementById("txt").value= $('#shabl option[value!=""]').first().val(); }

        });  
</script>


<center><p><font color='#000080' face='Trebuchet MS'><i><b><font size='5'>SMS </font><span lang='ru'><font size='5'>на прибор:</font></span></b></i></font></p>

<form method='GET' action='sms_na_pribor.php'>
<input type='hidden' name=id value='{{ $client['client_id'] }}'>


Sim-карта в приборе: <select size='1' name='sim'>
@if (!empty($client['simcard']))
<option>{{ $client['simcard'] }}</option>	
@endif 
@if (!empty($client['simcard2']))
<option>{{ $client['simcard2'] }}</option>
@endif	
</select>
<Br><br>

Шаблон: <select size='1' name='shabl' id='shabl' onchange='shablchange();'>

@FOREACH ($sms_na_pribor as $shablon)	
<option value='{{ $shablon['sms'] }}'>{{ $shablon['name'] }}</option>
@endforeach

</select><br><br>


Текст сообщения:<br>
<textarea rows='5' id='txt' name='txt' cols='45'></textarea><Br><br>

<input type="image" src='{{ asset('img/button_na_pribor.png') }}' class='imgbtn' value="SMS на прибор" name="urem">

</form><br><hr><br>

<a href='#'><img src='{{ asset('img/sms_refresh.png') }}' alt='refresh' onClick="showContent('smshistory.php?zid=$zid&sim1={{ $client['simcard'] }}&sim2{={{ $client['simcard2'] }}')"></a>


</center>


<div id="contentBody">
<center><br><br>Идет загрузка истории SMS со служебной сим-карты. Это может занять некоторое время...</center>
</div>

<div id="loading" style="display: none">  
    <br><br><br><br><br><center>Идет загрузка информации...<br><br>
	<img src='{{ asset('img/preloader.gif') }}'></center>
</div> 


<!--

if ($act=="send"){
	
	
$phone=$sim;
$phone=str_replace("(","",$phone);
$phone=str_replace(")","",$phone);
$phone=str_replace(" ","",$phone);
$phone=str_replace("+","",$phone);
$phone=str_replace("-","",$phone);
$smsphone=$phone;	

$txt=

$togoip="http://192.168.2.13/goip/en/dosend.php?USERNAME=root&PASSWORD=root&smsprovider=1&smsnum=".$smsphone."&method=2&Memo=".urlencode($txt)."";

$ch = curl_init($togoip);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$body = curl_exec($ch);
curl_close($ch);

echo "<br><br><br><br><center>Сообщение передано оператору на отправку</center>";

echo "<head><meta http-equiv=\"Refresh\" content=\"1; url='sms_na_pribor.php?zid=$zid'\"></head>";
	
}

if ($act=="multisend"){
$shid=0;
while ($shid<=1000){
$checksave="";$idtosend="";
$shid++;	
$check="check".$shid;
$checksave=$_GET[$check] ?? null;

if($checksave!=="" and $checksave!==null){
$idtosend=$checksave;

$baselog9 = "select simcard from `clients` where id='$idtosend'";
$ciload9 = mysqli_query($db,$baselog9);
$ecl9 = mysqli_fetch_assoc($ciload9);
$sim=$ecl9['simcard'];
$phone=$sim;
$phone=str_replace("(","",$phone);
$phone=str_replace(")","",$phone);
$phone=str_replace(" ","",$phone);
$phone=str_replace("+","",$phone);
$phone=str_replace("-","",$phone);
$smsphone=$phone;

$sendtophone.=$smsphone.",";

}



}

$sendtophone = substr ( $sendtophone , 0, -1);

echo "<center><p><font color='#000080' face='Trebuchet MS'><i><b><font size='5'>SMS </font><span lang='ru'><font size='5'>на прибор:</font></span></b></i></font></p>";
echo "<form method='GET' action='sms_na_pribor.php'>
<input type='hidden' name='zid' value='".$zid."'>
<input type='hidden' name='act' value='send'>

Sim-карты: <input type='text' name='sim' value='$sendtophone'><Br><br>

Текст сообщения:<br>

<textarea rows='5' name='txt' cols='45'></textarea><Br><br>

<input type=\"image\" src='../../assets/img/button_na_pribor.png' class='imgbtn' value=\"SMS на прибор\" name=\"urem\">

</form><br></center>";
}



-->


