<?php
include 'db.php';
session_start();
if(!isset($_SESSION['teacher'])){ echo 'Not logged in'; exit; }
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['roll_no'])){
    $roll = $conn->real_escape_string($_POST['roll_no']);
    $s = $conn->query("SELECT * FROM students WHERE roll_no='$roll'") or die($conn->error);
    if($s->num_rows==0){ echo 'Invalid roll number: '.htmlspecialchars($roll); exit; }
    $stu = $s->fetch_assoc();
    $sid = $stu['id'];
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d');
    $time = date('H:i:s');
    // prevent duplicate for same day
    $c = $conn->query("SELECT * FROM attendance WHERE student_id=$sid AND date='$date'") or die($conn->error);
    if($c->num_rows>0){ 
        echo 'Already marked for '.htmlspecialchars($stu['name']).' today.'; exit; }
    $conn->query("INSERT INTO attendance (student_id, date, time, status) VALUES ($sid, '$date', '$time', 'Present')") or die($conn->error);
    echo 'Marked Present: '.htmlspecialchars($stu['name']).' ('.$roll.') at '.$time;
    exit;
}
echo 'No data'; ?>