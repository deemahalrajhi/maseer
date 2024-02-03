<?php
session_start();
require('db.php');

if (isset($_POST['create_user'])) {
    $number_id = $_POST['number_id'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input 
    if ($password !== $confirm_password) {
        echo 'The two passwords are not the same!';
    }

    try {
        // Check if the number_id is already registered
        $query = "SELECT COUNT(*) FROM `users` WHERE number_id=:number_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':number_id', $number_id, PDO::PARAM_STR);
        $stmt->execute();
        $number_idExists = $stmt->fetchColumn();

        if ($number_idExists) {
            echo 'Number id already registered.';
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $query = "INSERT INTO `users` (number_id, password, phone) VALUES (:number_id, :password, :phone)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':number_id', $number_id, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->execute();

        // Check if the query was successful
        if ($stmt->rowCount() > 0) {
            //echo 'You are registered successfully.';
            header("Location: Hloginsignup.php"); exit();
        } else {
            echo 'Error registering the user.';
        }
    } catch (PDOException $e) {
        echo 'Database error: ' . $e->getMessage();
    }
}