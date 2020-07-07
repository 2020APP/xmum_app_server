<?php
$response = array();

//Declare empty variable
$con='';
$CourseID=array();
$CourseName=array();
$Credit=array();
$FullName=array();
$StudentNo=array();

include 'db_connect.php';
include 'functions.php';

$query = "SELECT courses.course_id, courses.course_name, courses.credit, member.full_name, courses.student_no FROM courses, member WHERE courses.lecturer_id=member.id";
$stmt = $con->prepare($query);
$stmt->execute();
$stmt->bind_result($CourseID,$CourseName,$Credit,$FullName,$StudentNo);
$stmt->fetch();
$response["course_id"] = $CourseID;
$response["course_name"] = $CourseName;
$response["credit"] = $Credit;
$response["full_name"] = $FullName;
$response["student_no"] = $StudentNo;
$stmt->close();
echo json_encode($response);

