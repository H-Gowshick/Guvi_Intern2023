<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

    // Get user input from the form
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Validation checks
    if ($password !== $confirmPassword) {
        echo "Password and Confirm Password do not match.";
    } else {
        // Check if the username or email is already taken
        $query = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Username or email already exists. Please choose different ones.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert user data into the database
            $insertQuery = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("sss", $username, $email, $hashedPassword);

            if ($insertStmt->execute()) {
                // Registration successful
                echo "Registration successful!";
              
                // JSON file handling
                $userData = [
                    "username" => $username,
                    "email" => $email,
                    "password" => $hashedPassword
                ];
                $jsonFile = __DIR__ . "/register_data.json";

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
                echo "Error: " . $insertStmt->error;
            }
        }

        $stmt->close();
    }

    // Close the database connection
    $conn->close();
}
?>
