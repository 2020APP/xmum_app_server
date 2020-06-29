<?php
$response = array();

//Declare empty variables
$con='';
$fullName='';
$role='';
$passwordHashDB='';
$salt='';

include 'db_connect.php';
include 'functions.php';

//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array

//Check for Mandatory parameters
if(isset($input['id']) && isset($input['password'])){
	$iD = $input['id'];
	$password = $input['password'];
	$query    = "SELECT full_name, password_hash, salt FROM member WHERE id = ?";

	if($stmt = $con->prepare($query)){
		$stmt->bind_param("s",$iD);
		$stmt->execute();
		$stmt->bind_result($fullName,$passwordHashDB,$salt);
		if($stmt->fetch()){
			//Validate the password
			if(password_verify(concatPasswordWithSalt($password,$salt),$passwordHashDB)){
				$response["status"] = 0;
				$response["message"] = "Login successful";
				$response["full_name"] = $fullName;
				$response["role"] = $role;
			}
			else{
				$response["status"] = 1;
				$response["message"] = "Invalid id and password combination";
			}
		}
		else{
			$response["status"] = 1;
			$response["message"] = "Invalid id and password combination";
		}
		
		$stmt->close();
	}
}
else{
	$response["status"] = 2;
	$response["message"] = "Missing mandatory parameters";
}
//Display the JSON response
echo json_encode($response);
?>