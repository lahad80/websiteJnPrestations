 <?php
	
	/*--------------------------update json file------------------------*/
	class Contact {
				function Contact($date,$familyName,$firstName,$phoneNumber,$email,$status,$purpose,$message, $position){
					$this->date = $date;
					$this->familyName = $familyName;
					$this->firstName = $firstName;
					$this->phoneNumber = $phoneNumber;
					$this->email = $email;
					$this->status = $status;
					$this->purpose = $purpose;
					$this->message = $message;
					$this->position = $position;
				}
		}		
	
	$postedData = file_get_contents("php://input");
	$postedData = json_decode($postedData);

	$jsonData = file_get_contents("../json/usersFile.json");
	$phpData = json_decode($jsonData,true);
	

	$newContact = new Contact(date("d/m/Y"),$postedData->familyName, $postedData->firstName, $postedData->phoneNumber, $postedData->email, $postedData->status, $postedData->purpose, $postedData->message, $phpData["count"]++);
	//$phpData["contacts"][count($phpData["contacts"])] = $newContact;
	array_push($phpData["contacts"], $newContact);
	
	$fl = fopen("../json/usersFile.json", 'w');
	//define('JSON_UNESCAPED_UNICODE',      256);
	fwrite($fl, json_encode($phpData,JSON_UNESCAPED_UNICODE));

	fclose($fl);
	
	/*****************************send an email*****************************/
	$to = "***********@**********r";
	$subject = "Envoyé depuis le formulaire de contact";
	$body = "";
	foreach($newContact as $key=>$value){
		$body .= "$key:      $value\n";
	}
	mail($to, $subject, $body);
	
	echo json_encode($phpData);  // sent data back to client
		
 ?>
