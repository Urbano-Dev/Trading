<?php
/*session_start();
require_once 'db_conn.php';

$errorMsg = ''; // Initialize error message variable

if (isset($_POST['register'])) {
    // Sanitize inputs
    $name = htmlspecialchars(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
    $username = htmlspecialchars(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
    $password = $_POST['password'];
    $retype = $_POST['retype'];

    if (!empty($name) && !empty($username) && !empty($password) && !empty($retype)) {
        // Check password complexity
        if (strlen($password) < 8 || !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W)/", $password)) {
            $errorMsg = "Password does not meet complexity requirements.";
        } elseif ($password !== $retype) {
            $errorMsg = "Passwords do not match.";
        } else {
            try {
                // Check if username is already taken
                $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch();

                if ($user) {
                    $errorMsg = "Username already exists.";
                } else {
                    // Hash the password
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

                    // Insert user into database
                    $stmt = $conn->prepare("INSERT INTO `users` (`username`, `password`, `name`) VALUES (?, ?, ?)");
                    $stmt->execute([$username, $hashed_password, $name]);

                    $_SESSION['message'] = array("text" => "User successfully created.", "alert" => "info");
                    header('Location: login.php');
                    exit;
                }
            } catch (PDOException $e) {
                $errorMsg = "Error: " . $e->getMessage();
            }
        }
    } else {
        $errorMsg = "Fill in all the required fields.";
    }
}*/

session_start();
require_once 'db_conn.php';

$response = array(); // Initialize response array

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Sanitize inputs
    $name = htmlspecialchars(filter_var($data['name'], FILTER_SANITIZE_STRING));
    $username = htmlspecialchars(filter_var($data['username'], FILTER_SANITIZE_STRING));
    $password = $data['password'];

    if (!empty($name) && !empty($username) && !empty($password)) {
        // Check password complexity
        if (strlen($password) < 8 || !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W)/", $password)) {
            $response['success'] = false;
            $response['message'] = "Password does not meet complexity requirements.";
        } else {
            try {
                // Check if username is already taken
                $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch();

                if ($user) {
                    $response['success'] = false;
                    $response['message'] = "Username already exists.";
                } else {
                    // Hash the password
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

                    // Insert user into database
                    $stmt = $conn->prepare("INSERT INTO `users` (`username`, `password`, `name`) VALUES (?, ?, ?)");
                    $stmt->execute([$username, $hashed_password, $name]);

                    $response['success'] = true;
                    $response['message'] = "User successfully registered.";
                }
            } catch (PDOException $e) {
                $response['success'] = false;
                $response['message'] = "Error: " . $e->getMessage();
            }
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Fill in all the required fields.";
    }

    // Send JSON response back to client
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// For other HTTP methods or direct access to the PHP script
$response['success'] = false;
$response['message'] = "Invalid request.";
header('Content-Type: application/json');
echo json_encode($response);
