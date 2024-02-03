<?php
session_start();
require('db.php');

if (isset($_POST['login_user'])) {
    $number_id_login = $_POST['number_id_login'];
    $password = $_POST['password_login'];

    // Validate input (you should also validate number_id_login format)
    if (empty($number_id_login) || empty($password)) {
        $_SESSION['err'] = 'number_id_login and password are required.';
        echo $_SESSION['err'];
    }

    try {
        // Prepare and execute the SQL query
        $query = "SELECT * FROM `users` WHERE number_id=:number_id_login";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':number_id_login', $number_id_login, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a user with the given number_id exists
        if ($user) {
            // Verify the password
            if (password_verify($password, $user['password'])) {
                if ($user['type'] == "admin") {
                    echo "Done Login Admin!";
                    header('Location: ../Adminpage.php'); //احط الص�?حه الي ابي اروح لها
                    exit;  
                } else {
                    echo "Done Login User!";
                    header('Location: ../pilgrimpage.php'); //احط الص�?حه الي ابي اروح لها
                    exit; 
                }
            } else {
                $_SESSION['err'] = 'Incorrect password.';
                //echo $_SESSION['err'];
                header("Location: ".$_SERVER['HTTP_REFERER']); exit();
            }
        } else {
            $_SESSION['err'] = 'User not found.';
            //echo $_SESSION['err'];
            header("Location: ".$_SERVER['HTTP_REFERER']); exit();

        }
    } catch (PDOException $e) {
        $_SESSION['err'] = 'Database error: ' . $e->getMessage();
        echo $_SESSION['err'];

    }
}