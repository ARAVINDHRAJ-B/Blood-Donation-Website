<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if all required fields are set
    if (isset($_POST["name"]) && isset($_POST["phone"]) && isset($_POST["email"]) && isset($_POST["blood_type"]) && isset($_POST["city"]) && isset($_POST["state"])) {
        // Extract form data
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $blood_type = $_POST["blood_type"];
        $city = $_POST["city"];
        $state = $_POST["state"];

        // Database connection
        $servername = "localhost";
        $username = "root";
        $dbpassword = "";
        $dbname = "redstream_db";
        $conn = new mysqli($servername, $username, $dbpassword, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute SQL query to insert data into the database
        $stmt = $conn->prepare("INSERT INTO donors (name, phone, email, blood_type, city, state) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $phone, $email, $blood_type, $city, $state);
        if ($stmt->execute()) {
            // Data inserted successfully
            echo "<script>alert('New record created successfully.');</script>";
        } else {
            // Failed to insert data
            echo "<script>alert('Failed to create new record. Please try again later.');</script>";
        }

        // Close the statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        // Handle case where required fields are not set
        echo "<script>alert('Please fill in all required fields.');</script>";
    }
}
?>
