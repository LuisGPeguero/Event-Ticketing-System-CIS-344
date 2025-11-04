<?php
include 'db_connect.php';
$method = $_SERVER['REQUEST_METHOD'];
$output = [];
if ($method == 'GET') {
    $sql = "SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC";
    $result = $conn->query($sql);
    $events = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
    }
    $output = $events;
} else {
    $output = ["error" => "Invalid request method."];
    http_response_code(405);
}
$conn->close();
echo json_encode($output);
?>
