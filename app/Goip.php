<?php

namespace App;

class Goip
{
	private $dbuser="fortis";    
	private $dbpwd="fortis";
	private $dbname="goip";  
	private $hostname="192.168.2.13";
	private $db;
	
	public $client_id;
	public $sim;
	public $smsphone;
	public $phone;
	public $phone2;
	public $sendid;
	public $rcv;

	public function __construct()
  	{
		$this->db = mysqli_connect($this->hostname, $this->dbuser, $this->dbpwd, $this->dbname) or die('Ошибка подключения к базе данных. Проверьте интернет-соединение или обратитесь к администратору');
		mysqli_set_charset($this->db,'utf8');
		$this->client_id=$_GET['id'] ?? null;

		$this->sim1=$_GET['sim1'] ?? null;
		$this->sim2=$_GET['sim2'] ?? null;
		$this->sim=$_GET['sim'] ?? null;

		$this->phone=$this->sim1;
		$this->smsphone=$this->phone;	

		if ($this->sim1=="" or !$this->sim1){
		$this->smsphone="none";		
		}

		if ($this->sim2!=="" and $this->sim2!==null){
		$this->phone2=$this->sim2;
		$this->smsphone2=$this->phone2;
		}else{
		$this->smsphone2="none";	
		}
  	}

	function sms_history()	
	{

$loadsenders = "select * FROM `message` where tel LIKE '%$this->smsphone%' or tel LIKE '%$this->smsphone2%' order by time desc";
$senders = mysqli_query($this->db,$loadsenders);
if (mysqli_num_rows($senders)<=0){
$this->sendid="Сообщений нет";	
}else{
while ($oursms = mysqli_fetch_assoc($senders)){
$this->sendid.="<table border='1' width='65%' bgcolor='#d7ddfa' style='border-collapse: collapse' bordercolor='#d7ddfa'><tr><td><font size='2' face='Trebuchet MS'>".$oursms['time']."</font><font face='Trebuchet MS'><br><b>".$oursms['msg']."</b></font></td></td></table><br>";	
}	
}

$loadrecevs = "select * FROM `receive` where srcnum LIKE '%$this->smsphone%' or srcnum LIKE '%$this->smsphone2%' order by time desc";
$recevs = mysqli_query($this->db,$loadrecevs);
if (mysqli_num_rows($recevs)<=0){
$this->rcv="Сообщений нет";	
}else{
while ($rcvsms = mysqli_fetch_assoc($recevs)){
$msg=$rcvsms['msg'];
$this->rcv.="<table border='1' width='65%' bgcolor='#f9eeaf' style='border-collapse: collapse' bordercolor='#f9eeaf'><tr><td><font size='2' face='Trebuchet MS'>".$rcvsms['time']."</font><br><font face='Trebuchet MS'><b>".$msg."</b></font></td></tr></table><br>";	
}	
}

/// ПЕРЕОТПРАВКА НЕОТПРАВЛЕННЫХ
$loadundone = "select * FROM `sends` where over=0 and (telnum LIKE '%$this->smsphone%' or telnum LIKE '%$this->smsphone2%') LIMIT 1";
$undone = mysqli_query($this->db,$loadundone);
if (mysqli_num_rows($undone)<=0){
}else{
while ($und = mysqli_fetch_assoc($undone)){
$rid=$und['id'];
$undonelink="http://192.168.2.13/goip/en/resend.php?USERNAME=root&PASSWORD=root&id=".urlencode($rid)."";	

$ch = curl_init($undonelink);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
$body = curl_exec($ch);
curl_close($ch);
}	
}
/// ПЕРЕОТПРАВКА НЕОТПРАВЛЕННЫХ

	}


function send_sms()
{

$txt=$_GET['txt'] ?? null;
$phone=$this->sim;
$phone=str_replace("(","",$phone);
$phone=str_replace(")","",$phone);
$phone=str_replace(" ","",$phone);
$phone=str_replace("+","",$phone);
$phone=str_replace("-","",$phone);
$smsphone=$phone;	

$togoip="http://192.168.2.13/goip/en/dosend.php?USERNAME=root&PASSWORD=root&smsprovider=1&smsnum=".$smsphone."&method=2&Memo=".urlencode($txt)."";



$ch = curl_init($togoip);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$body = curl_exec($ch);
curl_close($ch);

}


   function __destruct() 
   {
       mysqli_close($this->db);
   }	
	
}	
	
