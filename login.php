<?php
$conn = new mysqli("localhost", "root", "", "user_auth");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();
  if (password_verify($password, $user['password'])) {
    $_SESSION['username'] = $user['username'];
    echo "success";
  } else {
    echo "Incorrect password.";
  }
} else {
  echo "User not found.";
}

$stmt->close();
$conn->close();
?>
