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
if(isset($input['student_id']) && isset($input['course_id']) && isset($input['gpa']) && isset($input['grade']) && isset($input['credit'])){
    $StudentID = $input['student_id'];
    $CourseID = $input['course_id'];
    $GPA = $input['gpa'];
    $Grade = $input['grade'];
    $Credit = $input['credit'];
    
    //Check if course already exist
    if(!StudentIDnCourseIDExists($StudentID, $CourseID)){
        
        //Query to register new course
        $insertQuery  = "INSERT INTO grades(student_id, course_id, gpa, grade, credit) VALUES (?,?,?,?,?)";
        if($stmt = $con->prepare($insertQuery)){
            $stmt->bind_param("sssss", $StudentID, $CourseID, $GPA, $Grade, $Credit);
            $stmt->execute();
            $response["message"] = "Grade created";
            $stmt->close();
        }
    }
    else{
        $response["message"] = "Grade exists";
    }
}
else{
    $response["message"] = "Missing mandatory parameters";
}
echo json_encode($response);
?>