<?php
$response = array();

//Declare empty variable
$con='';
$CourseID='';
$CourseName='';
$Credit='';
$FullName='';
$StudentNo='';
$CourseIDs=array();
$CourseNames=array();
$Credits=array();
$FullNames=array();
$StudentNos=array();

include 'db_connect.php';
include 'functions.php';

$query = "SELECT courses.course_id, courses.course_name, courses.credit, member.full_name, courses.student_no FROM courses, member WHERE courses.lecturer_id=member.id";
$stmt = $con->prepare($query);
$stmt->execute();
$stmt->bind_result($CourseID,$CourseName,$Credit,$FullName,$StudentNo);
while ($stmt->fetch()) {
    $CourseIDs[]=$CourseID;
    $CourseNames[]=$CourseName;
    $Credits[]=$Credit;
    $FullNames[]=$FullName;
    $StudentNos[]=$StudentNo;
}
$response["course_id"] = $CourseIDs[];
$response["course_name"] = $CourseNames[];
$response["credit"] = $Credits[];
$response["full_name"] = $FullNames[];
$response["student_no"] = $StudentNos[];
$stmt->close();
echo json_encode($response);
