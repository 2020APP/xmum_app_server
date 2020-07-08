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
if(isset($input['course_id']) && isset($input['student_id'])){
    $CourseID = $input['course_id'];
    $StudentID = $input['student_id'];
    
    //Check if course already exist
    if(!EnrollmentExists($CourseID,$StudentID)){
        
        //Query to register new course
        $insertQuery  = "INSERT INTO enrollment_history(course_id, student_id) VALUES (?,?)";
        if($stmt = $con->prepare($insertQuery)){
            $stmt->bind_param("ss", $CourseID, $StudentID);
            $stmt->execute();
            $response["message"] = "Successfully enrolled";
            $stmt->close();
        }
        $updateQuery = "UPDATE courses SET student_no = student_no + 1 WHERE course_id = ?";
        if($stmt = $con->prepare($updateQuery)){
            $stmt->bind_param("s", $CourseID);
            $stmt->execute();
            $stmt->close();
        }
    }
    else{
        $response["message"] = "Enrollment exists";
    }
}
else{
    $response["message"] = "Missing mandatory parameters";
}
echo json_encode($response);
?>