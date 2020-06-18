<?php
$response = array();

//Declare empty variable
$con='';

include 'db_connect.php';
include 'functions.php';

//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array


//Check for Mandatory parameters
if(isset($input['full_name']) && isset($input['role']) && isset($input['id']) && isset($input['phone_num']) && isset($input['e_mail_addr']) && isset($input['password'])){
    $fullName = $input['full_name'];
    $role = $input['role'];
    $iD = $input['id'];
    $phoneNum = $input['phone_num'];
    $eMailAddr = $input['e_mail_addr'];
	$password = $input['password'];
	
	//Check if user already exist
	if(!idExists($iD)){

		//Get a unique Salt
		$salt         = getSalt();
		
		//Generate a unique password Hash
		$passwordHash = password_hash(concatPasswordWithSalt($password,$salt),PASSWORD_DEFAULT);
		
		//Query to register new user
		$insertQuery  = "INSERT INTO member(full_name, role, id, phone_num, e_mail_addr, password_hash, salt) VALUES (?,?,?,?,?,?,?)";
		if($stmt = $con->prepare($insertQuery)){
			$stmt->bind_param("sssssss", $fullName, $role, $iD, $phoneNum, $eMailAddr, $passwordHash, $salt);
			$stmt->execute();
			$response["status"] = 0;
			$response["message"] = "User created";
			$stmt->close();
		}
	}
	else{
		$response["status"] = 1;
		$response["message"] = "User exists";
	}
}
else{
	$response["status"] = 2;
	$response["message"] = "Missing mandatory parameters";
}
echo json_encode($response);
?>