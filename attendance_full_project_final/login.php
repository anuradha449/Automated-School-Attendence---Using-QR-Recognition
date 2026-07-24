<?php
session_start();
include 'db.php';

if (isset($_SESSION['teacher'])) {
    header('Location: home.php'); exit;
}

$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $user = $conn->real_escape_string($_POST['username']);
    $pass = $conn->real_escape_string($_POST['password']);
    $res = $conn->query("SELECT * FROM teachers WHERE username='$user' AND password='$pass'") or die($conn->error);
    if($res && $res->num_rows>0){
        $_SESSION['teacher'] = $user;
        header('Location: home.php'); exit;
    } else $error='Invalid credentials';
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login - Sri Chaitanya</title>
<style>
html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}
body {
  background-image: url('https://img.freepik.com/free-vector/geometric-science-education-background-vector-gradient-blue-digital-remix_53876-125993.jpg?semt=ais_hybrid&w=740&q=80');
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  font-family: Arial, sans-serif;
  display: flex;
  justify-content: center;
  align-items: center;
}
.card {
  background: rgba(255, 255, 255, 0.9);
  padding: 35px 45px;
  border-radius: 12px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.3);
  text-align: center;
  width: 320px;
}
.card h2 {
  margin-bottom: 20px;
  color: #003366;
}
input {
  width: 100%;
  padding: 10px;
  margin: 8px 0;
  border: 1px solid #ccc;
  border-radius: 6px;
}
button {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 16px;
}
button:hover {
  background-color: #0056b3;
}
.error {
  color: red;
  font-size: 14px;
  margin-bottom: 10px;
}
</style>
</head>
<body>
<div class="card">
  <h2>Teacher Login</h2>
  <?php if($error) echo '<p class="error">'.htmlspecialchars($error).'</p>'; ?>
  <form method="post">
    <input name="username" placeholder="Username" required>
    <input name="password" type="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
  <p style="font-size:12px;margin-top:10px;color:#666">Default: admin / admin123</p>
</div>
</body>
</html>
