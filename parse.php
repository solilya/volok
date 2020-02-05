<?PHP
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


require("../html//modules/config.php");
require("../html/arc/combat_config.php");

	$db->select_db('volokolamsk') or die("<p>Ошибка при выборе базы данных volkolamsk: " . mysqli_error() . "</p>");
/*
	$sth = $db->prepare("Select * from clients   ") or die ('Can not prepare sql query: "' .  mysqli_error($db).'"'); 	
	if (!$sth->execute()) { die("Error: mysqli_error($db)!");	}	
	$result=$sth->get_result();
	$sth2 = $db->prepare("Update clients SET simcard=? where id=?") or die ('Can not prepare sql query: "' .  mysqli_error($db).'"'); 
	$sth3 = $db->prepare("Update clients SET simcard2=? where id=?") or die ('Can not prepare sql query: "' .  mysqli_error($db).'"'); 
	while ($row=$result->fetch_assoc()) 
	{
		$string = $row['simcard_old'];   */
//		$pattern = '/(\d.\d\d\d.\d\d\d.\d\d.\d\d)\D*(\d.\d\d\d.\d\d\d.\d\d.\d\d)*/i';
/*		preg_match($pattern, $string,$matches);
		if (isset($matches[1]))
		{		
			$new_sim="$matches[1]";
			$sth2->bind_param('si',$new_sim,$row['id']);
			if (!$sth2->execute()) { die(mysqli_error($db)); }		
				
			if (isset($matches[2]))
			{
				$new_sim=$matches[2];
				$sth3->bind_param('si',$new_sim,$row['id']);
				if (!$sth3->execute()) { die(mysqli_error($db)); }	
			}
		}
	}
		
	print "поле simcard успешно обновлено\n";
*/

	$sth = $db->prepare("delete from client_helpers ") or die ('Can not prepare sql query: "' .  mysqli_error($db).'"'); 	
	if (!$sth->execute()) { die("Error: mysqli_error($db)!");	}	
	
	$sth = $db->prepare("Select * from clients ") or die ('Can not prepare sql query: "' .  mysqli_error($db).'"'); 	
	if (!$sth->execute()) { die("Error: mysqli_error($db)!");	}	
	$result=$sth->get_result();
	$sth2 = $db->prepare("Insert into client_helpers (name,tel,tel2,tel3,client_id) values(?,?,?,?,?)") or die ('Can not prepare sql query: "' .  mysqli_error($db).'"'); 
	$sth_upd = $db->prepare("update clients set person=?, tel=?,tel2=?,tel3=? where id=? ") or die ('Can not prepare sql query: "' .  mysqli_error($db).'"'); 

	while ($row=$result->fetch_assoc()) 
	{

		$id=$row['id'];
		$string = $row['person_old'];   
		$pattern = '/([\w«»"()@\.,\/ \n]+)\W?\W?(\d.\d\d\d.\d\d\d.\d\d.\d\d)(?:\D?\D?(\d?.?\d+.\d+.\d+.\d+))?(?:\D?\D?(\d?.?\d+.\d+.\d+.\d+))?/iu';
		preg_match_all($pattern, $string,$matches,PREG_SET_ORDER);					
		$len= count($matches);
		
		if ($len==0) #если не смогли разобрать регеспом добавим в БД в ручном режиме
		{
			$tel='';
			$tel2='';
			$tel3='';
			
			print "не был добавлен в БД client_id:$id, добавляем в ручном режиме\n";			
#			$sth2->bind_param('ssssi',$string,$tel,$tel2,$tel3,$id);
#			if (!$sth2->execute()) { die(mysqli_error($db)); }		

			$sth_upd->bind_param('ssssi',$string,$tel,$tel2,$tel3,$id);
			if (!$sth_upd->execute()) { die(mysqli_error($db)); }		
			
		}
		for ($i=0;$i<$len;$i++)
		{							
			for ($j=1;$j<count($matches[$i]);$j++)
			{			
				$matches[$i][$j]=preg_replace('/^[, \n]*/','',$matches[$i][$j]);
				$matches[$i][$j]=preg_replace('/[, \n]*$/','',$matches[$i][$j]);
			}
			
			$name=$matches[$i][1];
			$tel=$matches[$i][2];
			$tel2='';
			$tel3='';
			
			if (count($matches[$i])>3) $tel2=$matches[$i][3];
			if (count($matches[$i])>4) $tel3=$matches[$i][4];

			if ($i==0)								
			{
				$sth_upd->bind_param('ssssi',$name,$tel,$tel2,$tel3,$id);
				if (!$sth_upd->execute()) { die(mysqli_error($db)); }		
			}	
			else
			{
				$sth2->bind_param('ssssi',$name,$tel,$tel2,$tel3,$id);
				if (!$sth2->execute()) { die(mysqli_error($db)); }	
			}				
		}
	}


	mysqli_close($db);
?>