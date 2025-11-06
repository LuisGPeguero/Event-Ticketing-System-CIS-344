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
        $user_id = (int)$data['user_id'];
        $event_id = (int)$data['event_id'];
        $quantity = (int)$data['quantity'];
        if ($quantity <= 0) {
            $output = ["success" => false, "error" => "Invalid quantity. Must be a positive number (1 or more)."];
            http_response_code(400);
        } else {
            // Use a transaction to check availability and update atomically
            $conn->begin_transaction();

            // Lock the event row for update
            $stmt = $conn->prepare("SELECT tickets_available FROM events WHERE id = ? FOR UPDATE");
            $stmt->bind_param("i", $event_id);
            $stmt->execute();
            $stmt->bind_result($tickets_available);
            $found = $stmt->fetch();
            $stmt->close();

            if (!$found) {
                $conn->rollback();
                $output = ["success" => false, "error" => "Event not found."];
                http_response_code(404);
            } elseif ($quantity > (int)$tickets_available) {
                $conn->rollback();
                $output = ["success" => false, "error" => "Not enough tickets available."];
                http_response_code(409);
            } else {
                // Insert booking
                $stmt = $conn->prepare("INSERT INTO bookings (user_id, event_id, quantity) VALUES (?, ?, ?)");
                $stmt->bind_param("iii", $user_id, $event_id, $quantity);
                if (!$stmt->execute()) {
                    $err = $stmt->error;
                    $stmt->close();
                    $conn->rollback();
                    $output = ["success" => false, "error" => $err ?: "Failed to create booking."];
                    http_response_code(500);
                } else {
                    $stmt->close();
                    // Decrement tickets
                    $stmt = $conn->prepare("UPDATE events SET tickets_available = tickets_available - ? WHERE id = ?");
                    $stmt->bind_param("ii", $quantity, $event_id);
                    $ok = $stmt->execute();
                    $affected = $stmt->affected_rows;
                    $stmt->close();
                    if (!$ok || $affected !== 1) {
                        $conn->rollback();
                        $output = ["success" => false, "error" => "Failed to update ticket availability."];
                        http_response_code(500);
                    } else {
                        $conn->commit();
                        $output = ["success" => true, "message" => "Booking successful!"];
                    }
                }
            }
        }
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
