<?php
include 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200); // 200 OK
    exit();
}
$method = $_SERVER['REQUEST_METHOD'];
$output = [];
if ($method == 'GET') {
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
        $sql = "
            SELECT
                b.id AS booking_id,
                b.quantity,
                e.name AS event_name,
                e.event_date
            FROM
                bookings AS b
            JOIN
                events AS e ON b.event_id = e.id
            WHERE
                b.user_id = ?
            ORDER BY
                e.event_date ASC
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $bookings = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $bookings[] = $row;
            }
        }
        $output = $bookings;
        $stmt->close();
    } else {
        $output = ["error" => "user_id is required."];
        http_response_code(400); // 400 = Bad Request
    }

} elseif ($method == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['user_id'], $data['event_id'], $data['quantity'])) {
        $user_id = $data['user_id'];
        $event_id = $data['event_id'];
        $quantity = $data['quantity'];
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, event_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $event_id, $quantity);
        if ($stmt->execute()) {
            $output = ["success" => true, "message" => "Booking successful!"];
        } else {
            $output = ["success" => false, "error" => $stmt->error];
        }
        $stmt->close();

    } else {
        $output = ["success" => false, "error" => "Invalid data. 'user_id', 'event_id', and 'quantity' are required."];
        http_response_code(400);
    }
} else {
    $output = ["error" => "Invalid request method."];
    http_response_code(405);
}
$conn->close();
echo json_encode($output);
?>
