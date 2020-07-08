<?php
$random_salt_length = 32;
/**
* Queries the database and checks whether the user already exists
* 
* @param $iD
* 
* @return
*/
function idExists($iD){
	$query = "SELECT id FROM member WHERE id = ?";
	global $con;
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("s",$iD);
		$stmt->execute();
		$stmt->store_result();
		$stmt->fetch();
		if($stmt->num_rows == 1){
			$stmt->close();
			return true;
		}
		$stmt->close();
	}

	return false;
}

function CourseIDExists($CourseID){
    $query = "SELECT course_id FROM courses WHERE course_id = ?";
    global $con;
    if($stmt = $con->prepare($query)){
        $stmt->bind_param("s",$CourseID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->fetch();
        if($stmt->num_rows == 1){
            $stmt->close();
            return true;
        }
        $stmt->close();
    }
    
    return false;
}

function EnrollmentExists($CourseID, $StudentID){
    $query = "SELECT course_id, student_id FROM enrollment_history WHERE course_id = ? AND student_id = ?";
    global $con;
    if($stmt = $con->prepare($query)){
        $stmt->bind_param("ss",$CourseID, $StudentID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->fetch();
        if($stmt->num_rows == 1){
            $stmt->close();
            return true;
        }
        $stmt->close();
    }
    
    return false;
}

function CheckTableExists($CourseID){
    
}

/**
* Creates a unique Salt for hashing the password
* 
* @return
*/
function getSalt(){
	global $random_salt_length;
	return bin2hex(openssl_random_pseudo_bytes($random_salt_length));
}

/**
* Creates password hash using the Salt and the password
* 
* @param $password
* @param $salt
* 
* @return
*/
function concatPasswordWithSalt($password,$salt){
	global $random_salt_length;
	if($random_salt_length % 2 == 0){
		$mid = $random_salt_length / 2;
	}
	else{
		$mid = ($random_salt_length - 1) / 2;
	}

	return
	substr($salt,0,$mid-1).$password.substr($salt,$mid,$random_salt_length-1);

}
?>