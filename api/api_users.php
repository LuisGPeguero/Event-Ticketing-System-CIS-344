<?php
include 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200); // 200 OK
    exit();
}
$method = $_SERVER['REQUEST_METHOD'];
$output = [];
if ($method == 'POST') {
    $action = $_GET['action'] ?? '';
    $data = json_decode(file_get_contents('php://input'), true);
    if ($action == 'register') {
        if (isset($data['username'], $data['email'], $data['password'])) {
            $username = $data['username'];
            $email = $data['email'];
            $password = $data['password'];
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password);
            if ($stmt->execute()) {
                $output = ["success" => true, "message" => "Registration successful."];
            } else {
                $output = ["success" => false, "error" => $stmt->error];
            }
            $stmt->close();
        } else {
            $output = ["success" => false, "error" => "Username, email, and password are required."];
        }
    } elseif ($action == 'login') {
        if (isset($data['username'], $data['password'])) {
            $username = $data['username'];
            $password = $data['password'];
            $stmt = $conn->prepare("SELECT id, username FROM users WHERE username = ? AND password = ?");
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                $output = [
                    "success" => true,
                    "message" => "Login successful.",
                    "user" => [
                        "id" => $user['id'],
                        "username" => $user['username']
                    ]
                ];
            } else {
                $output = ["success" => false, "error" => "Invalid username or password."];
            }
            $stmt->close();
        } else {
            $output = ["success" => false, "error" => "Username and password are required."];
        }

    } else {
        $output = ["error" => "Invalid action. Use 'login' or 'register'."];
    }
} else {
    $output = ["error" => "Invalid request method. Use POST."];
    http_response_code(405);
}
$conn->close();
echo json_encode($output);
?>

