<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rfid_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the last scanned student
$sql = "SELECT * FROM students ORDER BY last_scanned DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Student found
    $row = $result->fetch_assoc();
    $response = array(
        'status' => 'success',
        'name' => $row['name'],
        'nim' => $row['nim'],
        'jurusan' => $row['jurusan'],
        'photo' => $row['photo']
    );
} else {
    // No student scanned yet
    $response = array(
        'status' => 'error',
        'message' => 'No student scanned yet'
    );
}

// Close connection
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>