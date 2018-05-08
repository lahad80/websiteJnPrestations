  <?php
	
	$postedData = file_get_contents("php://input");
	
	$postedData = json_decode($postedData);

	$jsonData = file_get_contents('../json/usersFile.json');
	$phpData = json_decode($jsonData, true);
	
	$i = 0;
	$found = false;

	while ($i < count($phpData["contacts"]) && !$found  ){
		if($phpData["contacts"][$i]["position"]  == $postedData->id ){
			array_splice($phpData["contacts"], $i, 1);
			$found = true;
		}
		$i++;
	}
	
	
	$fl = fopen("../json/usersFile.json", 'w');
	//define('JSON_UNESCAPED_UNICODE',      256);
	fwrite($fl, json_encode($phpData,JSON_UNESCAPED_UNICODE));
	fclose($fl);

	 echo json_encode($phpData);  
	 

 ?>