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
if(isset($input['course_id']) && isset($input['course_name']) && isset($input['credit']) && isset($input['lecturer_id']) && isset($input['student_no'])){
    $CourseID = $input['course_id'];
    $CourseName = $input['course_name'];
    $Credit = $input['credit'];
    $LecturerID = $input['lecturer_id'];
    $StudentNo = $input['student_no'];
    
    //Check if course already exist
    if(!CourseIDExists($CourseID)){

        //Query to register new course
        $insertQuery  = "INSERT INTO courses(course_id, course_name, credit, lecturer_id, student_no) VALUES (?,?,?,?,?)";
        if($stmt = $con->prepare($insertQuery)){
            $stmt->bind_param("sssss", $CourseID, $CourseName, $Credit, $LecturerID, $StudentNo);
            $stmt->execute();
            $response["status"] = 0;
            $response["message"] = "Course created";
            $stmt->close();
        }
    }
    else{
        $response["status"] = 1;
        $response["message"] = "Course exists";
    }
}
else{
    $response["status"] = 2;
    $response["message"] = "Missing mandatory parameters";
}
echo json_encode($response);
?>