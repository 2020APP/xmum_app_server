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
        $QueryAddCourse = "INSERT INTO courses(course_id, course_name, credit, lecturer_id, student_no) VALUES (?,?,?,?,?)";
        if($stmt = $con->prepare($QueryAddCourse)){
            $stmt->bind_param("sssss", $CourseID, $CourseName, $Credit, $LecturerID, $StudentNo);
            $stmt->execute();
            $response["message"] = "Course created";
            $stmt->close();
        }
    }
    else{
        $response["message"] = "Course exists";
    }
}
else{
    $response["message"] = "Missing mandatory parameters";
}
echo json_encode($response);
?>