<?php
session_start();

if (isset($_SESSION["user_id"])) {
    // Database connection
    $host = "localhost";
    $username = "root";
    $password = ""; 
    $database = "user_details"; 

    // Create a connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION["user_id"];

    // Retrieve user data based on user ID
    $query = "SELECT age, dob, contact FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        echo json_encode($user_data);
    } else {
        echo "Error: User data not found.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Error: User not logged in.";
}
?>
