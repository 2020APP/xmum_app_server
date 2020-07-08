<?php
$response = array();
$course = array();
$n = 0;
//Declare empty variable
$con='';
$CourseID='';
$CourseName='';
$Credit='';
$FullName='';
$StudentNo='';

include 'db_connect.php';
include 'functions.php';

$query = "SELECT courses.course_id, courses.course_name, courses.credit, member.full_name, courses.student_no FROM courses LEFT JOIN member ON courses.lecturer_id=member.id";
$stmt = $con->prepare($query);
$stmt->execute();
$stmt->bind_result($CourseID,$CourseName,$Credit,$FullName,$StudentNo);
while ($stmt->fetch()) {
    $course["course_id"] = $CourseID;
    $course["course_name"] = $CourseName;
    $course["credit"] = $Credit;
    $course["full_name"] = $FullName;
    $course["student_no"] = $StudentNo;
    $response[$n] = $course;
    ++$n;
}
$stmt->close();
echo json_encode($response);
