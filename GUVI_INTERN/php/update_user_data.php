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
    $age = $_POST["age"];
    $dob = $_POST["dob"];
    $contact = $_POST["contact"];

    // Update user-specific data in the database
    $query = "UPDATE users SET age = ?, dob = ?, contact = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $age, $dob, $contact, $user_id);

    if ($stmt->execute()) {
        echo "success";
        // Update user data in the JSON file
        $userData = [
            "age" => $age,
            "dob" => $dob,
            "contact" => $contact
        ];
        $jsonFile = __DIR__ . "/user_data.json";
        $currentData = json_decode(file_get_contents($jsonFile), true) ?? [];

        if ($currentData === null) {
            echo "Error decoding JSON file.";
        } else {
            $currentData[] = $userData;
            if (file_put_contents($jsonFile, json_encode($currentData)) !== false) {
                echo "";
            } else {
                echo "Error writing to JSON file.";
            }
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Error: User not logged in.";
}
?>
