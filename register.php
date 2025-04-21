<?php
$conn = new mysqli("localhost", "root", "", "user_auth");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$check = $conn->prepare("SELECT id FROM users WHERE username = ?");
$check->bind_param("s", $username);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
  echo "Username already taken.";
} else {
  $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
  $stmt->bind_param("ss", $username, $password);
  if ($stmt->execute()) {
    echo "success";
  } else {
    echo "Error: " . $stmt->error;
  }
  $stmt->close();
}

$check->close();
$conn->close();
?>
