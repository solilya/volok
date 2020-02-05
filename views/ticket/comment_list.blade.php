<?php session_start(); ?>
<link href="../../assets/css/main.css" rel="stylesheet" type="text/css" />
<style type="text/css" media="print">
  div.no_print {display: none; }
  @media print{@page {size:landscape}} 
</style> 
<?php
include("config.php");
$opid=$_SESSION['opid'];


	

<table border='0' width='100%'>
<tr><td><div class='msg_clientinfo'>
<table border='0' width='100%'><tr><td>
Клиент: <b>{{ $client->person }}</b><br>
Адрес: <b>{{ $client->address }}</b><br>
А/П: <b>{{ $client->payment }}</b>, Пультовый номер: <b>{{ $client->pult_number }}</b> 
Договор: <b>{{ $client->dogovor }}</b><br>
Телефоны в базе: <b>{{ $client->tel1 }} {{ $client->tel2 }} {{ $client->tel3 }}</b>
</td><td>


<!-- переход к карточке клиента -->
<a href='#' onclick=\"window.open('{{ route('view') }}?id={{ $client->id }}','newWin{{ $client->id }}', 'width=700,height=750,location=0,status=0,menubar=0,toolbar=0,directories=0,scrollbars=1'); return false;\"><img src='{{ asset('img/ocard.png') }}' title='Карточка клиента'></a>";}
<!-- переход к карточке клиента -->

</td></tr></table></div>



<tr><td><div width='100%'>



while ($txt=mysqli_fetch_assoc($loadtickettxt)){
$authorid=$txt['author'];
$authorsql = "select login,otdel,userpic from `operators` where id='$authorid'";
$authorload = mysqli_query($db,$authorsql);
$author=mysqli_fetch_assoc($authorload);

if ($author['otdel']==$myotdel){
$divclass="msg_outcome";
}else{
$divclass="msg_incom";
}

if ($author['userpic']=="" or !$author['userpic']){
$userpic="<img src='../../assets/img/no_avatar.jpg' title='Пользователь ".$author['login']." еще не установил персональный аватар :)' width='100px' height='100px'>";
}else{
$userpic="<img src='".$author['userpic']."' title='Аватар пользователя ".$author['login']."' width='100px'>";
}

echo "<div class='$divclass'><table border='0' width='100%'><tr><td valign='top' width='110px'>$userpic</td>
		<td>".$txt['txt']."<br><br>
<font size='1'>Написал: <b>".$author['login']."</b> // <b>".$txt['dt']."</b></font></td></tr></table>
</div>";




$loadoperssql = "select id from operators where (otdel='".$author['otdel']."' or currentotdel='".$author['otdel']."') and uvolen is null";
$loadopers = mysqli_query($db,$loadoperssql);

while ($answeroper=mysqli_fetch_assoc($loadopers)){
$checkid=$answeroper['id'];

//echo $checkid."-";

if ($opid!==$checkid and $opid!==$authorid){
$savesql = "update `ccenter_txt` set status='read', whoread='$opid' where id='".$txt['id']."'";
$result=mysqli_query($db,$savesql);
}

}


//if ($tootdel==$myotdel and $myotdel!==null and $myotdel!=="" and $authorid!==$opid){
//if ($authorid!==$opid){
//$savesql = "update `ccenter_txt` set status='read', whoread='$opid' where id='".$txt['id']."'";
//$result=mysqli_query($db,$savesql);

//}
}
echo "</div></td></tr>";
echo "<tr><td><div class='no_print'><div class='msg_send'><table border='0' width='100%'>
	<tr>
		<td><form method='GET' action='ccenter_showmsg.php'><textarea rows='3' name='sndtxt' cols='60' class='roundcorn2' placeholder='Введите текст для отправки здесь...'></textarea></td>
		<td><input type='hidden' value='$id' name='id'><input type='hidden' value='$clientid' name='clientid'><input type='hidden' value='savemsg' name='act'><input type='submit' value='Отправить сообщение' name='ok' class='roundcorn2'></form>
		</td>
	</tr>
</table></div></div></td></tr></table><br>
<center><form method='GET' action='ccenter_showmsg.php'><input type='hidden' value='$id' name='id'><input type='hidden' value='$clientid' name='clientid'><input type='hidden' value='renew' name='act'><input type='submit' value='Отметить как непрочитанное' name='ok' class='roundcorn2'></form></center>
";
}

if ($act=="savemsg"){
$dt=date("d.m.Y H:i:s");
$msgsavesql = "insert into `ccenter_txt` (ticketid,txt,status,author,dt) values ('$id','$sndtxt','new','".$my['id']."','$dt')";
$resultmsg=mysqli_query($db,$msgsavesql);

echo "<font face='Trebuchet MS'><center><b>Сообщение отправлено</b><br><br>
<head><meta http-equiv=\"Refresh\" content=\"0; url='ccenter_showmsg.php?id=".$id."&clientid=$clientid'\"></head>

</center></font>";

}

?>