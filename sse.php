<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('Access-Control-Allow-Origin: *');

// Include database connection
include 'db_connect.php';

$lastId = isset($_GET['lastId']) ? $_GET['lastId'] : 0;

while (true) {
    // Cek perubahan di database
    $result = $conn->query("SELECT MAX(id) as last_id FROM students WHERE last_scanned > DATE_SUB(NOW(), INTERVAL 5 SECOND)");
    $row = $result->fetch_assoc();
    
    if ($row['last_id'] != $lastId) {
        echo "data: update\n\n";
        ob_flush();
        flush();
        $lastId = $row['last_id'];
    }
    
    sleep(1);
}