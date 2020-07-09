<?php
$response = array();
$enrollment_history = array();
$n = 0;

//Declare empty variable
$con='';
$CourseID='';
$CourseName='';
$StudentID='';
$GPA='';

include 'db_connect.php';
include 'functions.php';

//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array

if(isset($input['student_id'])){
    $query1 = "SELECT enrollment_history.course_id, courses.course_name, enrollment_history.gpa FROM enrollment_history LEFT JOIN courses ON enrollment_history.course_id = courses.course_id WHERE student_id = ?";
    $StudentID = $input['student_id'];
    if($stmt = $con->prepare($query1)){
        $stmt->bind_param("s", $StudentID);
        $stmt->execute();
        $stmt->bind_result($CourseID, $CourseName, $GPA);
        while ($stmt->fetch()) {
            $enrollment_history["course_id"] = $CourseID;
            $enrollment_history["course_name"] = $CourseName;
            $enrollment_history["gpa"] = $GPA;
            $response[$n] = $enrollment_history;
            ++$n;
        }
        $stmt->close();
    }
}
else{
    $query2 = "SELECT course_id, student_id, gpa FROM enrollment_history";
    if($stmt = $con->prepare($query2)){
        $stmt->execute();
        $stmt->bind_result($CourseID, $StudentID, $GPA);
        while ($stmt->fetch()) {
            $enrollment_history["course_id"] = $CourseID;
            $enrollment_history["student_id"] = $StudentID;
            $enrollment_history["gpa"] = $GPA;
            $response[$n] = $enrollment_history;
            ++$n;
        }
        $stmt->close();
    }    
}
echo json_encode($response);
?>