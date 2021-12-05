<?php
	$database = "if21_mukail_as";
	
	function register($firstname, $lastname, $sid){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id FROM vp_party WHERE sid = ? and cancelled is null");
		$stmt->bind_param("i", $sid);
		$stmt->bind_result($sid_from_db);
		echo $conn->error;
		$stmt->execute();		
		if($stmt->fetch()){
			$notice = "Te juba registeritud!";
		} else {
			$stmt->close();
			$stmt = $conn->prepare("INSERT INTO vp_party (firstname, lastname, sid) VALUES (?,?,?)");
			echo $conn->error;
			$stmt->bind_param("ssi", $firstname, $lastname, $sid);
			if($stmt->execute()){
				$notice = "Koik on korras";
			} else {
				$notice = "Tekkis viga: " .$stmt->error ;
			}			
		}	
		$stmt->close();
		$conn->close();
		return $notice;
	}		
		
	
	function read_registered(){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT firstname, lastname, sid, payment FROM vp_party where cancelled is null");
		echo $conn->error;
		$stmt->bind_result($firstname_from_db, $lastname_from_db, $sid_from_db, $payment_from_db);
		$stmt->execute();
		while ($stmt->fetch()){
			if (!empty ($payment_from_db)){$payment_from_db = "- makstud";}
			$notice .= "<p>" .$firstname_from_db ." " .$lastname_from_db ." (" .$sid_from_db .")" .$payment_from_db."</p>";
		}
		if(empty($notice)){
			$notice = "List on tuhi.";
		}
		$stmt->close();
		$conn->close();
		return $notice;	
	}
	
 	function read_unpaid($person){
        $notice = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("SELECT id, firstname, lastname FROM vp_party where cancelled is null and payment is null");
        $stmt->bind_result($id_from_db, $firstname_from_db, $lastname_from_db);
        $stmt->execute();
        while($stmt->fetch()){
           $notice .= '<option value="' .$id_from_db .'"'; 
           if($person == $id_from_db){
                $notice .= " selected";
            }
            $notice .= ">" .$firstname_from_db ." " .$lastname_from_db ."</option> \n";
        }
        $stmt->close();
        $conn->close();
        return $notice;
    } 
	
	function mark_as_paid($id){
        $notice = null;
		$payment = 1;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
		$stmt = $conn->prepare("UPDATE vp_party SET payment = ? WHERE id = ?");
		echo $conn->error;
		$stmt->bind_param("ii", $payment, $id); 
        if($stmt->execute()){
			$notice = "Onnestus";
		} else {
			$notice = "Tekkis viga: " .$stmt->error ;	
		}
        $stmt->close();
        $conn->close();
        return $notice;
    }
	
	function count_registred(){
		$notice = null;
		$count = 0;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id FROM vp_party where cancelled is null");
		echo $conn->error;
		$stmt->bind_result($id_from_db);
		$stmt->execute();
		while($stmt->fetch()){	
			$count = $count + 1;				
		}
		$notice = $count;
		$stmt->close();
		$conn->close();
		return $notice;			
	}
	
	function count_paid_people(){
		$notice = null;
		$count = 0;
		$payment = 1;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id FROM vp_party where cancelled is null and payment = ?");
		$stmt->bind_param("i", $payment); 		
		echo $conn->error;
		$stmt->bind_result($id_from_db);
		$stmt->execute();
		while($stmt->fetch()){	
			$count = $count + 1;				
		}
		$notice = $count;
		$stmt->close();
		$conn->close();
		return $notice;			
	}
	
	function cancel($sid){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id FROM vp_party WHERE sid = ?");
		$stmt->bind_param("i", $sid);
		$stmt->bind_result($sid_from_db);
		echo $conn->error;
		$stmt->execute();		
		if($stmt->fetch()){
			$stmt->close();
			$stmt = $conn->prepare("UPDATE vp_party SET cancelled = NOW() WHERE sid = ?");
			echo $conn->error;
			$stmt->bind_param("i", $sid);
			if($stmt->execute()){
				$notice = "Registreering on tühistatud";
			} else {
				$notice = "Registreeringu tühistamisel tekkis viga: " .$stmt->error ;
			}			
		} else {
			$notice = "Registreering puudub"; 
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}