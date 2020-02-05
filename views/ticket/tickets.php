<?php session_start();

include("config.php");
$opid=$_SESSION['opid'];

if ($_SESSION['loginEmail']=="" OR $_SESSION['loginPass']==""){
unset($_SESSION['loginEmail']); 
unset($_SESSION['loginPass']); 
	echo "<table border='0' width='100%' height='100%'><tr><td>
<p align='center'><br><br><img src='http://192.168.2.12/assets/img/exit_here.jpg'><br><br><br>Осуществляется выход из системы...<br><br>Войдите в систему заново со своим логином и паролем!</p>
</td></tr></table>
<head><meta http-equiv=\"Refresh\" content=\"3; url='index.php'\"></head>";
	
}else{

$baselog = "select * from `operators` where login='".$_SESSION['loginEmail']."' and password="."'".$_SESSION['loginPass']."'";
$login = mysqli_query($db,$baselog);

	if ((!$login) || (mysqli_num_rows($login)<=0)){
	unset($_SESSION['loginEmail']); 
	unset($_SESSION['loginPass']); 
echo "<table border='0' width='100%' height='100%'><tr><td>
<p align='center'>Неверная пара Логин-Пароль или пользователь заблокирован!</p>
</td></tr></table>
<head><meta http-equiv=\"Refresh\" content=\"3; url='index.php'\"></head>";
mysqli_close($db);

	}else{

$q1=null;
$q2=null;
$q3=null;
$q4=null;
$likesentence=null;
$org=null;
$ppn=null;
$spacer=null;
	
$newcount=0;
$sortdate=$_POST['sortdate'] ?? null;	
$my=mysqli_fetch_assoc($login);

$per1=$_POST['per1'] ?? null;	
$per2=$_POST['per2'] ?? null;	
$limit=$_GET['limit'] ?? null;
$sortstatus=$_GET['sortstatus'] ?? null;
$showalltck=$_GET['showalltck'] ?? null;

if ($my['opt1']=="ON"){
$q1="checked";
}
if ($my['opt2']=="ON"){
$q2="checked";
}
if ($my['opt3']=="ON"){
$q3="checked";
}
if ($my['opt4']=="ON"){
$q4="checked";
}

if ($per1!==null and $per2!==null){
$titl="Заявки за период с ".$per1." по ".$per2;
$dayperiod=floor((strtotime($per2)-strtotime($per1))/86400);
$curdp=0;
$stringnper=$per1;
while($curdp<$dayperiod){
$stringnper=date("d.m.Y",(strtotime($stringnper)+86400));
$curdp++;
$likesentence=$likesentence." OR date LIKE '".$stringnper."%'";
}
$getticketsql = "select * from `teh_tickets` WHERE (date LIKE '$per1%' ".$likesentence.") and (neopros IS NULL) ORDER BY date ASC";
$loadticket = mysqli_query($db,$getticketsql);	

$getticketsqlwidthneopros = "select id from `teh_tickets` WHERE (date LIKE '$per1%' ".$likesentence.") ORDER BY date ASC";
$loadticketwidthneopros = mysqli_query($db,$getticketsqlwidthneopros);	
$totalwidthneopros=mysqli_num_rows($loadticketwidthneopros);

$getticketsqlhneopros = "select * from `teh_tickets` WHERE (date LIKE '$per1%' ".$likesentence.") and (neopros IS NOT NULL) ORDER BY date ASC";
$loadticketneopros = mysqli_query($db,$getticketsqlhneopros);

}

if ($sortdate!==null){
$now=$sortdate;
$titl="Режим отображения сортированных заявок (".$now.")";
$getticketsql = "select * from `teh_tickets` where date LIKE '$sortdate%' and (neopros IS NULL) ORDER BY `id` DESC";
$loadticket = mysqli_query($db,$getticketsql);	

$getticketsqlwidthneopros = "select id from `teh_tickets` where date LIKE '$sortdate%' ORDER BY `id` DESC";
$loadticketwidthneopros = mysqli_query($db,$getticketsqlwidthneopros);	
$totalwidthneopros=mysqli_num_rows($loadticketwidthneopros);

$getticketsqlhneopros = "select * from `teh_tickets` where date LIKE '$sortdate%' and (neopros IS NOT NULL) ORDER BY `id` DESC";
$loadticketneopros = mysqli_query($db,$getticketsqlhneopros);

}else if ($per1==null and $per2==null){	
$now=date("d.m.Y");
$titl="Управление техническими заявками";
echo "<script>  
        function refreshcontent()  
        {  
		showContent('./modules/teh/tickets.php');		
        }  
      
        $(document).ready(function(){  
             
			setInterval('refreshcontent()',900000);  
        });  
    </script>";		

if ($limit=="all"){
$lim="";
}else{
if ($limit==null){
$lim=" LIMIT 350";
}else{
$lim=" LIMIT ".$limit;
}
}

if ($sortstatus=="С дополнениями от ДЧ"){
$orsort=" and isup>0 and status!='Заявка закрыта' and status!='Заявка закрыта (без выезда техника)'";		
}else{
if ($sortstatus==null or !$sortstatus){
$orsort="";	
}else{
$orsort=" and status='$sortstatus' ";	
}}
	
$thismounth=date("m.Y");
$getticketsql = "select * from `teh_tickets` where neopros IS NULL $orsort ORDER BY id DESC $lim";
$loadticket = mysqli_query($db,$getticketsql);

$getticketsqlwidthneopros = "select id from teh_tickets $orsort ORDER BY id DESC $lim";
$loadticketwidthneopros = mysqli_query($db,$getticketsqlwidthneopros);	
$totalwidthneopros=mysqli_num_rows($loadticketwidthneopros);

$getticketsqlhneopros = "select * from `teh_tickets` where (neopros IS NOT NULL) ORDER BY id DESC $lim";
$loadticketneopros = mysqli_query($db,$getticketsqlhneopros);
	
}

$now2=date("d.m.Y");
if ($sortdate==$now2){
$now=date("d.m.Y");
$titl="Управление техническими заявками";
echo "<script>  
        function refreshcontent()  
        {  
		showContent('./modules/teh/tickets.php');		
        }  
      
        $(document).ready(function(){  
             
			setInterval('refreshcontent()',900000);  
        });  
    </script>";	
$thismounth=date("m.Y");
$getticketsql = "select * from `teh_tickets` where (date LIKE '%$thismounth%' or (remind LIKE '$now%')) or (date < '$now' and status='Заявка создана') and (neopros IS NULL) ORDER BY `id` DESC";
$loadticket = mysqli_query($db,$getticketsql);	

$getticketsqlwidthneopros = "select id from `teh_tickets` where (date LIKE '%$thismounth%' or (remind LIKE '$now%')) or (date < '$now' and status='Заявка создана') ORDER BY `id` DESC";
$loadticketwidthneopros = mysqli_query($db,$getticketsqlwidthneopros);	
$totalwidthneopros=mysqli_num_rows($loadticketwidthneopros);

$getticketsqlhneopros = "select * from `teh_tickets` where (date LIKE '%$thismounth%' or (remind LIKE '$now%')) or (date < '$now' and status='Заявка создана') and (neopros IS NOT NULL) ORDER BY `id` DESC";
$loadticketneopros = mysqli_query($db,$getticketsqlhneopros);	

	
}


echo "<div style='position:fixed;top:40px;left:20px;background-color: #FFFFFF; width:100%; border-bottom-style: solid; border-bottom-color: #000000;'>&nbsp;&nbsp;<i><b><font size='5' color='#000080'>".$titl."</font></b></i> <br>";
echo "<a href='#' onclick=\"document.getElementById('filter').style.visibility='visible'\"><img title='Фильтры записей' src='../../assets/img/filter_ico.png'></a>
<a href='#' onclick=\"document.getElementById('seek').style.visibility='visible'\"><img title='Фильтры записей' src='../../assets/img/search_ticket1.png'></a>";
echo "</div><br><br><br><br><br><br><br><br>";

$loadstatusessql = "select distinct status FROM teh_tickets ORDER by status ASC";
$loadstatuses = mysqli_query($db,$loadstatusessql);
$statussortlist="<option value=''>Все заявки</option>";
while ($sts = mysqli_fetch_assoc($loadstatuses)){
if ($sts['status']==$sortstatus){$sel="selected";}else{$sel="";}
$statussortlist.="<option $sel>".$sts['status']."</option>";	
}
$statussortlist.="<option $sel>С дополнениями от ДЧ</option>";	

echo "<form method='GET' action='#'>Показывать: <select size='1' name='sortstatus' onChange=\"this.form.submit()\">$statussortlist</select></form><br>";


echo "<div style='position: absolute; visibility: hidden; width: 383px; height: 160px; z-index: 9000; left: 40%; top: 50%;padding-top:19px;padding-left:30px;' id='filter' class='seacrhfrm'>
<table border='0' width='90%' cellspacing='0' cellpadding='0'>
	<tr>
		<td class='operpanel'>Настройки фильтра записей</td>
		<td align='right' class='operpanel'> <a href='#' onclick=\"document.getElementById('filter').style.visibility='hidden'\"><img src='../../assets/img/close_modal_win.png'></a></td>
	</tr>
	<tr>
		<td colspan='2'><br>Найти записи за дату: <form method='POST' action='./system.php'>
		<input type='hidden' name='reload' id='reload' value='0'>
&nbsp; <input type='text' style='border: 1px dotted #000000' value='".$now."' onfocus='this.select();lcs(this)'
    onclick='event.cancelBubble=true;this.select();lcs(this)' name='sortdate' id='sortdate'><input type='submit' value='Ok' name='filt_ok'></form><br>
	&nbsp; или <a href='#' onclick=\"document.getElementById('filter').style.visibility='hidden';document.getElementById('period').style.visibility='visible'\">Сортировать за период...</a><br><br>
	</td>
	</tr>
</table>
</div>

<div style='position: absolute; visibility: hidden; width: 383px; height: 160px; z-index: 9000; left: 40%; top: 50%;padding-top:19px;padding-left:30px;' id='period' class='seacrhfrm'>
<table border='0' width='90%' cellspacing='0' cellpadding='0'>
	<tr>
		<td class='operpanel'>Настройки фильтра записей за период</td>
		<td align='right' class='operpanel'> <a href='#' onclick=\"document.getElementById('period').style.visibility='hidden'\"><img src='../../assets/img/close_modal_win.png'></a></td>
	</tr>
	<tr>
		<td colspan='2'><br>Найти записи:<br><form method='POST' action='./system.php'>
		с: <input type='hidden' name='reload' id='reload' value='0'>
&nbsp; <input type='text' style='border: 1px dotted #000000' value='".$now."' onfocus='this.select();lcs(this)'
    onclick='event.cancelBubble=true;this.select();lcs(this)' name='per1' id='per1' size='14'> по:  
	&nbsp; <input type='text' style='border: 1px dotted #000000' value='".$now."' onfocus='this.select();lcs(this)'
    onclick='event.cancelBubble=true;this.select();lcs(this)' name='per2' id='per2' size='14'><br><br>
	
	<center><input type='submit' value='Искать записи' name='filt_ok'></center></form>
	<br>
	</td>
	</tr>
</table>
</div>

<div style='position: absolute; visibility: hidden; width: 383px; height: 160px; z-index: 9000; left: 40%; top: 40%;padding-top:20px;padding-left:30px;' id='seek' class='seacrhfrm'>
<table border='0' width='90%' cellspacing='0' cellpadding='0' >
	<tr>
		<td  class='operpanel'>&nbsp;&nbsp;Поиск заявки в базе данных</td>
		<td  align='right' class='operpanel'> <a href='#' onclick=\"document.getElementById('seek').style.visibility='hidden'\"><img src='../../assets/img/close_modal_win.png'></a></td>
	</tr>
	<tr>
		<td colspan='2' ><br>Найти заявку в которой встречается: <br><br><form method='POST' action='./system.php?p=find'>
		<input type='hidden' name='reload' id='reload' value='0'>
<input type='text' name='seekstring' id='seekstring' size='40'><input type='submit' value='Ok' name='filt_ok'></form></td>
	</tr>
</table>
</div>


<div style='position: absolute; visibility: hidden; width: 383px; height: 260px; z-index: 9000; left: 40%; top: 45%;padding-top:20px;padding-left:30px;' id='settings' class='seacrhfrm2'>
<table border='0' width='90%' cellspacing='0' cellpadding='0'>
	<tr>
		<td class='operpanel'>Настройки отображения</td>
		<td align='right' class='operpanel'> <a href='#' onclick=\"document.getElementById('settings').style.visibility='hidden'\"><img src='../../assets/img/close_modal_win.png'></a></td>
	</tr>
	<tr>
		<td colspan='2'>&nbsp;<form method='POST' action='./save_config.php'>
		&nbsp;&nbsp; <input type='checkbox' name='opt1' value='ON' ".$q1."> Показывать закрытые заявки<br>
		&nbsp;&nbsp; <input type='checkbox' name='opt2' value='ON' ".$q2."> Показывать заявки с выездом техника<br>
		&nbsp;&nbsp; <input type='checkbox' name='opt3' value='ON' ".$q3."> Показывать заявки с созвоном клиенту<br>
		&nbsp;&nbsp; <input type='checkbox' name='opt4' value='ON' ".$q4."> Показывать созданные заявки<br>
		<br>
		<center><input type='submit' value='Сохранить' name='filt_ok'></center></form><br></td>
	</tr>
</table>
</div>


<div style='position: absolute; width: 200px; height: 100px; z-index: 1; right: 33px; top: 39px; visibility: hidden;' id='flowmenu'>
<a href=\"./system.php\" onMouseover=\"td1.bgColor='white'\" onMouseOut=\"td1.bgColor=''\">Технические заявки</a><br>";
if ($my['canseeclbase']=="yes"){
echo "<a href=\"./system.php?p=2\">Клиентская база</a><br>";
}
echo "<a href='./system.php?p=4'>Отчеты</a><br>
<a href='./system.php?p=info'>Инфо-портал</a><br>";
if ($my['canrukrole']=="yes"){
echo "<a href='./system.php?p=6'>Управление отделом</a><br>";
}
echo "</div>
";


//if ($my['cansmsnapribor']=="yes"){
//echo "<form method='GET' target='_blank' action='../../modules/teh/sms_na_pribor.php' id='masssend'><input type='hidden' name='act' value='multisend'>";	
//}

$newtcount=0;
echo "<table border='1' width='100%' style='border-collapse: collapse' bordercolor='#000000'>
	<tr>";

//if ($my['cansmsnapribor']=="yes"){
//echo "<td bgcolor='#000000' background='../../assets/img/table_header.jpg' align='center'><font color='#FFFFFF'>Выбор</font></td>";	
//}	
	
	echo "
		<td bgcolor='#000000' background='../../assets/img/table_header.jpg' width='100px' align='center'><font color='#FFFFFF'>Номер заявки</font></td>
		<td bgcolor='#000000' background='../../assets/img/table_header.jpg' width='100px' align='center'><font color='#FFFFFF'>Дата</font></td>
		<td bgcolor='#000000' background='../../assets/img/table_header.jpg' align='center'><font color='#FFFFFF'>Пультовый №</font></td>
		<td bgcolor='#000000' background='../../assets/img/table_header.jpg' align='center'><font color='#FFFFFF'>ФИО</font></td>
		<td bgcolor='#000000'  background='../../assets/img/table_header.jpg' align='center'><font color='#FFFFFF'>Адрес</font></td>
		<td bgcolor='#000000'  background='../../assets/img/table_header.jpg' align='center'><font color='#FFFFFF'>Телефон</font></td>
		<td bgcolor='#000000' background='../../assets/img/table_header.jpg'  align='center'><font color='#FFFFFF'>Система</font></td>
		<td bgcolor='#000000' background='../../assets/img/table_header.jpg'  align='center'><font color='#FFFFFF'>Тип объекта</font></td>
		<td bgcolor='#000000' background='../../assets/img/table_header.jpg'  align='center'><font color='#FFFFFF'>Cтатус</font></td>
		<td bgcolor='#000000' background='../../assets/img/table_header.jpg'  align='center'><font color='#FFFFFF'>Информация</font></td>
		<td bgcolor='#000000' background='../../assets/img/table_header.jpg'  align='center'><font color='#FFFFFF'>Действия</font></td>
	</tr>";

$totalonpage=0;	
$totalclose=0;
$totaltehgo=0;
$totalpause=0;
$totalnotdone=0;
$totalclosenotgo=0;



while ($tick = mysqli_fetch_assoc($loadticket)){	
$totalonpage++;
if ($tick['status']=="Заявка создана"){
$newtcount++;
}

$needid=$tick['clientid'];
$clll = "select id,firstname,secondname,surname,address,phone1,phone2,phone3,interes,object,pultnomer,createdate,tremind,todognum,vip from `clients` WHERE id=$needid";
$vip="";$vipplate="";
$cliload = mysqli_query($db,$clll);
$clie = mysqli_fetch_assoc($cliload);
$currentclientid=$clie['id'];

$bgcol="bgcolor='white'";
$bcol="white";
if ($tick['status']=="Заявка создана" or $tick['status']=="Заявка создана в ТО"){
$totalnotdone++;
$bgcol="bgcolor='#FF9999'";
$bcol="#FF9999";
}
if ($tick['status']=="Принято в ТО"){
$totalnotdone++;
$bgcol="bgcolor='#FFFFCC'";
$bcol="#FFFFCC";
}
if ($tick['status']=="Перенос даты запланированных работ" or $tick['status']=="В процессе работы" or $tick['status']=="Созвон с клиентом"){
$totalnotdone++;
}
if ($tick['status']=="Запланирован выезд техника"){
$totaltehgo++;
$bgcol="bgcolor='#cdffcc'";
$bcol="#cdffcc";
}
if ($tick['status']=="Заявка закрыта"){
$totalclose++;
$bgcol="bgcolor='#ffcccc'";
$bcol="#ffcccc";
}

if ($tick['status']=="Заявка закрыта (без выезда техника)"){
$totalclosenotgo++;
$bgcol="bgcolor='#ffcccc'";
$bcol="#ffcccc";
}

if ($tick['status']=="Приостановлено"){
$totalpause++;
$bgcol="bgcolor='#cecece'";
$bcol="#cecece";
}
if ($tick['status']=="Требуется выезд техника"){
$totalnotdone++;
$bgcol="bgcolor='#befbff'";
$bcol="#befbff";
}
if ($tick['status']=="Требуется отработка тех. поддержки"){
$totalnotdone++;
$bgcol="bgcolor='#6ba3c0'";
$bcol="#6ba3c0";
}
if ($tick['status']=="Созвон с клиентом"){
$totalnotdone++;	
$bgcol="bgcolor='#00ff06'";
$bcol="#00ff06";
}

$imd="";
if ($tick['imid']=="yes"){
asset('img/edit.png')
$bgcol="bgcolor='#ffab3d' background='../../assets/img/srochno_teh.gif'";
$bcol="#ffab3d";	
$imd="<b>СРОЧНО!</b><br>";
}

if ($clie['vip']=="yes"){
$linecolor="white";	
$bgcol="bgcolor='#ffe6b5' background='../../assets/img/vip_fon.gif'";
$vipplate="<br><img src='../../assets/img/vip_plate.png' title='VIP-клиент!'>";
}

if ($clie['org']!==""){
$orgprt="<br><font size='1'>".$clie['org']."</font>";
}else{
$orgprt="";
}

$troublesql = "select id from `teh_tickets` where clientid='$currentclientid' and tehvyezd IS NULL";
$troubleload = mysqli_query($db,$troublesql);
$troublecount=mysqli_num_rows($troubleload);

if ($troublecount<2){
$troublecountindicator="";
}else{
$troublewidth=(4*$troublecount)."px";
$troublecountindicator="<br><img src='../../assets/img/trouble_indicator.png' width='$troublewidth' height='5px' title='Проблемность клиента (заявок в базе: ".$troublecount.")'>";
}



$zndone="";
if ($tick['whentodo']==null or $tick['whentodo']==""){
$zndone1="";
}else{

if ($tick['tehnik']==null or $tick['tehnik']==""){
$whogo="";
$spacer="<br>";
}else{
$whogoes=$tick['tehnik'];
$tehniksql22 = "select fio from `operators` where id='$whogoes'";
$tehnikload22 = mysqli_query($db,$tehniksql22);
$tehnikinfo = mysqli_fetch_assoc($tehnikload22);
$whogo=$tehnikinfo['fio'];
$whogofi = "\nТехник: ".substr($whogo, 0, strpos($whogo, ' ' ))."";
}

//$zndone1="<br><b><font size='1'>(выезд ".$tick['whentodo'].")</font></b>".$whogofi;

$zndone1="<br><img src='../../../assets/img/tehnik_car.png' title='Дата: ".$tick['whentodo']."".$whogofi."'>";

}
if ($tick['whendone']!==null and $tick['whendone']!==""){
$zndone2=$spacer."&nbsp;&nbsp;<img src='../../../assets/img/zn_ico.png' title='Заказ-наряд сдан: ".$tick['whendone']."'>";

}else{
$zndone2="";
}


if ($tick['isup']>0){
$isup1="<img src='../../../assets/img/updated_teh_ticket.gif' title='По этой заявке есть дополнения (".$tick['isup'].")'>";
$isup2="<img src='../../../assets/img/create_ticket.png' title='По этой заявке есть дополнения (".$tick['isup'].")'> &nbsp;";
}else{
$isup1="";
$isup2="";
}

/// ДЛЯ ВСЕХ
if ($my['onlymoved']!=="yes" or $showalltck=="yes"){	
if ((($my['opt1']=="ON" and ($tick['status']=="Заявка закрыта" or $tick['status']=="Заявка закрыта (без выезда техника)")) or ($my['opt2']=="ON" and $tick['status']=="Запланирован выезд техника") or ($my['opt3']=="ON" and $tick['status']=="Созвон с клиентом") or ($my['opt4']=="ON" and $tick['status']=="Заявка создана в ТО") or $tick['status']=="Заявка создана" or $tick['status']=="Принято в ТО" or $tick['status']=="Приостановлено" or $tick['status']=="В процессе работы" or $tick['status']=="Перенос даты запланированных работ" or $tick['status']=="Требуется выезд техника" or $tick['status']=="Требуется отработка тех. поддержки") or $sortstatus!==""){

$rnow=date("d.m.Y");
$crd=substr($clie['createdate'], 0, strpos($clie['createdate'], ' ' ));
$dayperiod=floor((strtotime($rnow)-strtotime($crd))/86400);
$shownewsticker="";
if ($dayperiod<90){
$shownewsticker="<img src='../../assets/img/new_sticker.png' title='Этому договору нет 3-х месяцев'>";
}else{
$shownewsticker="";
}

$showtosticker="";
$loaddogssql = "select * FROM to_dogovors WHERE clientid='".$tick['clientid']."'  and archive IS NULL";
$loaddogs = mysqli_query($db,$loaddogssql);
if (mysqli_num_rows($loaddogs)>0){
$showtosticker="<img src='../../assets/img/to_sticker.png' title='Заключен договор на тех. обслуживание'>";
}

$ppn++;

echo "<tr id='".$tick['id']."' ".$bgcol."  onclick=\"this.style.backgroundColor='".$bcol."'\" ondblclick=\"document.getElementById('".$tick['id']."').style.backgroundColor='#951bf4';window.open( './modules/teh/info_ticket.php?id=".$tick['id']."&zid=".$clie['id']."','newWin".$tick['id']."', 'width=900,height=750,location=0,status=0,menubar=0,toolbar=0,directories=0,scrollbars=1'); return false;\">";
//if ($my['cansmsnapribor']=="yes" and $clie['id']>0){
//echo "<td align='center'><input type='checkbox' name='check$ppn' value='".$clie['id']."'></td>";	
//}
//if ($my['cansmsnapribor']=="yes" and $clie['id']<=0){
//echo "<td align='center'></td>";	
//}

echo "<td align='center'>".$isup2.$tick['id'].$isup1.$troublecountindicator."</td>
<td align='center'>".$tick['date']."</td>
<td align='center'>".$clie['pultnomer']."</td>
<td align='center'>".$clie['firstname']." ".$clie['secondname']." ".$clie['surname'].$orgprt.$shownewsticker.$showtosticker.$vipplate."</td>
<td align='center'>".$clie['address']."</td>
<td align='center' width='130px'>".$clie['phone1']."</td>
<td align='center'>".$clie['interes']."</td>
<td align='center'>".$clie['object']."</td>
<td align='center'>".$imd.$tick['status'].$zndone1.$zndone2."</td>
<td align='center'>".mb_substr($tick['info'],0,170,'UTF-8')."...</td>
<td align='center'><a href='#' onclick=\"window.open( './modules/teh/info_ticket.php?id=".$tick['id']."&zid=".$clie['id']."','newWin".$tick['id']."', 'width=900,height=750,location=0,status=0,menubar=0,toolbar=0,directories=0,scrollbars=1'); return false;\" border='0'><img src='./assets/img/ticket_teh_icon.png' border='0'></a>";


if ($tick['status']!=="Заявка создана"){
echo "&nbsp;<a href=\"#\" onclick=\"window.open( './modules/teh/universal_reminder.php?act=&zid=".$clie['id']."&id=".$tick['id']."','newWin".$tick['id']."', 'width=900,height=800,location=0,status=0,menubar=0,toolbar=0,directories=0'); return false;\"><img border='0' src='../assets/img/universal_reminder_icon.png' title='Установить универсальное напоминание'></a>";
}
$un="";
if ($clie['id']>1){
$loadremsql = "select * from `reminder_universe` where clientid='".$clie['id']."' and operatorid='$opid'";
$loadrem = mysqli_query($db,$loadremsql);
if (mysqli_num_rows($loadrem)>0){
echo "<br>";
}
while($rm = mysqli_fetch_assoc($loadrem)){
echo "<a href='#' onclick=\"window.open( './modules/teh/universal_reminder.php?act=show&rid=".$rm['rid']."&zid=".$clie['id']."&tid=".$tick['id']."','newWin288".$rm['rid']."', 'width=900,height=750,location=0,status=0,menubar=0,toolbar=0,directories=0,scrollbars=1'); return false;\"><img src='../../assets/img/reminder.png' title='Напоминание на: ".$rm['dt']."\n\n".$rm['text']."'></a>";
}
}else{
$loadremsql = "select * from `reminder_universe` where tehticket='".$tick['id']."' and operatorid='$opid'";
$loadrem = mysqli_query($db,$loadremsql);	
if (mysqli_num_rows($loadrem)>0){
echo "<br>";
}
while($rm = mysqli_fetch_assoc($loadrem)){
echo "<a href='#' onclick=\"window.open( './modules/teh/universal_reminder.php?act=show&rid=".$rm['rid']."&zid=none&tid=".$tick['id']."','newWin288".$rm['rid']."', 'width=900,height=750,location=0,status=0,menubar=0,toolbar=0,directories=0,scrollbars=1'); return false;\"><img src='../../assets/img/reminder.png' title='Напоминание на: ".$rm['dt']."\n\n".$rm['text']."'></a>";
}

}
echo "</td></tr>";
}
}else{
/// ДЛЯ ВСЕХ
/// ТОЛЬКО ТЕХ ПОДДЕРЖКА
if ($tick['status']=="Требуется отработка тех. поддержки"){

$rnow=date("d.m.Y");
$crd=substr($clie['createdate'], 0, strpos($clie['createdate'], ' ' ));
$dayperiod=floor((strtotime($rnow)-strtotime($crd))/86400);
$shownewsticker="";
if ($dayperiod<90){
$shownewsticker="<img src='../../assets/img/new_sticker.png' title='Этому договору нет 3-х месяцев'>";
}else{
$shownewsticker="";
}

$showtosticker="";
$loaddogssql = "select * FROM to_dogovors WHERE clientid='".$tick['clientid']."'";
$loaddogs = mysqli_query($db,$loaddogssql);
if (mysqli_num_rows($loaddogs)>0){
$showtosticker="<img src='../../assets/img/to_sticker.png' title='Заключен договор на тех. обслуживание'>";
}


echo "<tr id='".$tick['id']."' ".$bgcol."  onclick=\"this.style.backgroundColor='".$bcol."'\" ondblclick=\"document.getElementById('".$tick['id']."').style.backgroundColor='#951bf4';window.open( './modules/teh/info_ticket.php?id=".$tick['id']."&zid=".$clie['id']."','newWin".$tick['id']."', 'width=900,height=750,location=0,status=0,menubar=0,toolbar=0,directories=0,scrollbars=1'); return false;\">
<td align='center'>".$isup2.$tick['id'].$isup1."</td>
<td align='center'>".$tick['date']."</td>
<td align='center'>".$clie['pultnomer']."</td>
<td align='center'>".$clie['firstname']." ".$clie['secondname']." ".$clie['surname'].$orgprt.$shownewsticker.$showtosticker."</td>
<td align='center'>".$clie['address']."</td>
<td align='center' width='130px'>".$clie['phone1']."</td>
<td align='center'>".$clie['interes']."</td>
<td align='center'>".$clie['object']."</td>
<td align='center'>".$tick['status'].$zndone1.$zndone2."</td>
<td align='center'>".mb_substr($tick['info'],0,170,'UTF-8')."...</td>
<td align='center'><a href='#' onclick=\"window.open( './modules/teh/info_ticket.php?id=".$tick['id']."&zid=".$clie['id']."','newWin".$tick['id']."', 'width=900,height=750,location=0,status=0,menubar=0,toolbar=0,directories=0,scrollbars=1'); return false;\" border='0'><img src='./assets/img/ticket_teh_icon.png' border='0'></a>";

$rmd = $tick['remind'];
if (preg_match("/./",$rmd) and $rmd!=="call"){
echo "&nbsp;&nbsp;<img src='./assets/img/reminder.png' border='0' title='Установлено напоминание на ".$tick['remind']."'>";
}
if (ereg("call",$rmd)){
echo "&nbsp;&nbsp;<img src='./assets/img/calls_icon.png' border='0' title='Запланирован звонок на ".$clie['tremind']."'>";
}

echo "</td></tr>";
}
}
/// ТОЛЬКО ТЕХ ПОДДЕРЖКА

}
echo "</table>";


$neoprosnotdone=0;$neoprosdone=0;$neoprosclosenotgo=0;$neoprostehinplan=0;$neoprospause=0;
while ($tick2 = mysqli_fetch_assoc($loadticketneopros)){	
if ($tick2['status']=="Заявка создана"){
$neoprosnotdone++;
}
if ($tick2['status']=="Требуется отработка тех. поддержки"){
$neoprosnotdone++;
}
if ($tick2['status']=="Требуется выезд техника"){
$neoprosnotdone++;
}
if ($tick2['status']=="Запланирован выезд техника"){
$neoprostehinplan++;
}
if ($tick2['status']=="Заявка закрыта"){
$neoprosdone++;
}
if ($tick2['status']=="Заявка закрыта (без выезда техника)"){
$neoprosclosenotgo++;
}
if ($tick2['status']=="Приостановлено"){
$neoprospause++;
}
if ($tick2['status']=="Перенос даты запланированных работ" or $tick2['status']=="В процессе работы" or $tick2['status']=="Созвон с клиентом"){
$neoprosdone++;
}
if ($tick2['status']=="Принято в ТО" or $tick2['status']=="Заявка создана в ТО"){
$neoprosdone++;
}
}

if ($my['cansmsnapribor']=="yes"){
echo "</form>";
}

echo "<br>Показывать заявок на странице: <a href='./system.php?limit=500&sortstatus=$sortstatus'>500</a> - <a href='./system.php?limit=1000&sortstatus=$sortstatus'>1000</a> - <a href='./system.php?limit=1500&sortstatus=$sortstatus'>1500</a> - <a href='./system.php?limit=2000&sortstatus=$sortstatus'>2000</a> - <a href='./system.php?limit=all&sortstatus=$sortstatus'>Все (может долго прогружать список)</a><br>";





if ($my['onlymoved']!=="yes"){
$totalnop=$totalwidthneopros-$totalonpage;
echo "<br>-------<br><b>Статистика:</b><br><br><table border='1' width='50%' style='border-collapse: collapse' bordercolor='#000000'>
	<tr bgcolor='#000000'>
		<td align='center' ><font color='#FFFFFF' face='Trebuchet MS' size='2'>Тип заявок</font></td>
		<td align='center'><font color='#FFFFFF' face='Trebuchet MS' size='2'>
		Всего</font></td>
		<td align='center'><font color='#FFFFFF' face='Trebuchet MS' size='2'>
		Неотработанных</font></td>
		<td align='center'><font color='#FFFFFF' face='Trebuchet MS' size='2'>
		Закрытых с выездом</font></td>
		<td align='center'><font color='#FFFFFF' face='Trebuchet MS' size='2'>
		Закрытых без выезда</font></td>
		<td align='center'><font color='#FFFFFF' face='Trebuchet MS' size='2'>
		Запланирован выезд</font></td>
		<td align='center'><font color='#FFFFFF' face='Trebuchet MS' size='2'>
		Приостановленные</font></td>
	</tr>
	<tr>
		<td align='center'><font face='Trebuchet MS' size='2'>Технические заявки</font></td>
		<td align='center'><font size='2' face='Trebuchet MS'>$totalonpage</font></td>
		<td align='center'><font size='2' face='Trebuchet MS'>$totalnotdone</font></td>
		<td align='center'><font size='2' face='Trebuchet MS'>$totalclose</font></td>
		<td align='center'><font size='2' face='Trebuchet MS'>$totalclosenotgo</font></td>
		<td align='center'><font size='2' face='Trebuchet MS'>$totaltehgo</font></td>
		<td align='center'><font size='2' face='Trebuchet MS'>$totalpause</font></td>
	</tr>
	<tr>
		<td align='center'><font face='Trebuchet MS' size='2'>Неопросы</font></td>
		<td align='center'><font face='Trebuchet MS' size='2'>$totalnop</font></td>
		<td align='center'><font face='Trebuchet MS' size='2'>$neoprosnotdone</font></td>
		<td align='center'><font size='2' face='Trebuchet MS'>$neoprosdone</font></td>
		<td align='center'><font size='2' face='Trebuchet MS'>$neoprosclosenotgo</font></td>
		<td align='center'><font size='2' face='Trebuchet MS'>$neoprostehinplan</font></td>
		<td align='center'><font size='2' face='Trebuchet MS'>$neoprospause</font></td>
	</tr>
	<tr bgcolor='#000066'>
		<td align='center' ><font size='2' face='Trebuchet MS' color='#FFFFFF'>
		Итого</font></td>
		<td align='center'><font color='#FFFFFF' face='Trebuchet MS' size='2'>
		$totalwidthneopros</font></td>
		<td align='center'><font color='#FFFFFF' face='Trebuchet MS' size='2'>
		".($neoprosnotdone+$totalnotdone)."</font></td>
		<td align='center'><font color='#FFFFFF' face='Trebuchet MS' size='2'>
		".($totalclose+$neoprosdone)."</font></td>
		<td align='center'><font color='#FFFFFF' face='Trebuchet MS' size='2'>
		".($totalclosenotgo+$neoprosclosenotgo)."</font></td>
		<td align='center'><font color='#FFFFFF' face='Trebuchet MS' size='2'>
		".($totaltehgo+$neoprostehinplan)."</font></td>
		<td align='center'><font color='#FFFFFF' face='Trebuchet MS' size='2'>
		".($totalpause+$neoprospause)."</font></td>
	</tr>
</table><br><br><br><br>";

}


if($newtcount>0 and $my['onlymoved']!=="yes"){ 
echo "<script type=\"text/javascript\">
	
	$(document).ready(function(){
			$.gritter.add({
				title: 'Новые технические заявки:',
				text: '<br>Количество новых тех. заявок, которые необходимо отработать:  <b>$newtcount</b><Br><br><center><a href=\"./system.php?sortstatus=Заявка+создана\">Показать эти заявки</a></center><br><br>',
				sticky: false, 
				time: ''
			});
			return false;
	});
</script>";
}
}




mysqli_close($db); 
}
?>