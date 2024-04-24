<?php

// Allow requests from all origins (not recommended for production)
header("Access-Control-Allow-Origin: *");
// Allow specific headers and methods
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: POST");
/*session_start();
require_once 'db_conn.php';

$errorMsg = ''; // Initialize error message variable

if (isset($_POST['login'])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = 'SELECT * FROM users WHERE username = ? LIMIT 1';
        $query = $conn->prepare($sql);
        $query->execute([$username]);
        $fetch = $query->fetch(PDO::FETCH_ASSOC);

        if ($fetch && password_verify($password, $fetch['password'])) {
            $_SESSION['user'] = htmlspecialchars($fetch['name']); // Sanitize output

            exit;
        } else {
            $errorMsg = "Invalid credentials.";
        }
    } else {
        $errorMsg = "Please input the required fields.";
    }
}*/

session_start();
require_once 'db_conn.php';

$response = array(); // Initialize response array

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming JSON data is sent from React
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['username'], $data['password'])) {
        $username = $data['username'];
        $password = $data['password'];

        // Perform database query and authentication logic here
        $sql = 'SELECT * FROM users WHERE username = ? LIMIT 1';
        $query = $conn->prepare($sql);
        $query->execute([$username]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables or additional user data as needed
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_rank'] = $user['rank'];

            // Prepare response data
            $response['success'] = true;
            $response['message'] = 'Login successful';
            $response['user'] = array(
                'name' => $user['name'],
                'rank' => $user['rank']
            );
        } else {
            $response['success'] = false;
            $response['message'] = 'Invalid credentials';
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Please provide username and password';
    }

    // Send JSON response back to React
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// For other HTTP methods or direct access to the PHP script
$response['success'] = false;
$response['message'] = 'Invalid request';
header('Content-Type: application/json');
echo json_encode($response);