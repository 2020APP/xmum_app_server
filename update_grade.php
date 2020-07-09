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
if(isset($input['course_id']) && isset($input['student_id']) && isset($input['gpa'])){
    $CourseID = $input['course_id'];
    $StudentID = $input['student_id'];
    $GPA = $input['gpa'];
    
    //Check if course already exist
    if(EnrollmentExists($CourseID,$StudentID)){
        
        //Query to register new course
        $updateQuery  = "UPDATE enrollment_history SET gpa = ? WHERE course_id = ? AND student_id = ?";
        if($stmt = $con->prepare($updateQuery)){
            $stmt->bind_param("sss", $GPA, $CourseID, $StudentID);
            $stmt->execute();
            $response["message"] = "Successfully updated";
            $stmt->close();
        }
    }
    else{
        $response["message"] = "Enrollment does not exist";
    }
}
else{
    $response["message"] = "Missing mandatory parameters";
}
echo json_encode($response);
?>