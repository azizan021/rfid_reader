<?php
// Tambahkan ini di awal file
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rfid_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

$uid = strtolower($_GET['uid']); // Konversi ke lowercase

$sql = "SELECT * FROM students WHERE uid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $uid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Update last_scanned
    $update_sql = "UPDATE students SET last_scanned = CURRENT_TIMESTAMP WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("i", $row['id']);
    $update_stmt->execute();
    
    $response = [
        'status' => 'success',
        'name' => $row['name'],
        'nim' => $row['nim'],
        'jurusan' => $row['jurusan'],
        'photo' => $row['photo']
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'Student not found'
    ];
}

$conn->close();
echo json_encode($response);
?>