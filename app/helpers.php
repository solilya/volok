<?php

function Convert_timestamp_to_HTML($date)
{
	if(!$date) return '';
	preg_match('/(....).(..).(..).(..).(..).(..)/',"$date", $matches);
	list($all,$year,$mon,$day,$hour,$min,$sec)=$matches;	
	$date="$hour:$min:$sec $day.$mon.$year";
	return $date;
}

// Конвертировать дату в html так чтобы сначала первой шла дата, а потом время
function Convert_timestamp_to_HTML_date_first($date)
{
	if(!$date) return '';
	preg_match('/(....).(..).(..).(..).(..).(..)/',"$date", $matches);
	list($all,$year,$mon,$day,$hour,$min,$sec)=$matches;	
	$date="$day.$mon.$year $hour:$min:$sec";
	return $date;
}

function Convert_date_to_MySQL($date)
{
	if (!preg_match('/(\d\d)\W(\d\d)\W(\d\d\d\d)/',"$date",$matches))
	{ 
		print "Ошибка: неверно введена дата $date"; exit; 
	}
	
	list($all,$day,$mon,$year)=$matches;
	
	$date=$year.'-'.$mon.'-'.$day;
	return $date;
}	

function Convert_date_to_HTML($date)
{
	if (empty($date)) return NULL;
	if (!preg_match('/(\d\d\d\d)\W(\d\d)\W(\d\d)/',"$date",$matches))
	{ 
		print "Ошибка: неверно введена дата $date"; exit; 
	}
	
	list($all,$year,$mon,$day)=$matches;
	
	$date=$day.'.'.$mon.'.'.$year;
	return $date;
}	


?>