<?php

require 'config/function.php';
session_start(); // Start the session

if (isset($_SESSION['loggedIn'])) {

    global $conn;

    $row = [
        'id' => $_SESSION['user_id'],
        'nama' => $_SESSION['nama'],
        'email' => $_SESSION['email'],
        'no_telp' => $_SESSION['no_telp'],
        'level' => $_SESSION['level']
    ];

    $_SESSION['loggedInUser'] = [
        'user_id' => $row['id'],
        'nama' => $row['nama'],
        'email' => $row['email'],
        'no_telp' => $row['no_telp'],
        'level' => $row['level']
    ];

    $userId = $_SESSION['loggedInUser']['user_id'];

    $query = "UPDATE login_history SET logout_time = NOW() WHERE logout_time IS NULL ORDER BY login_time DESC LIMIT 1";
    mysqli_query($conn, $query);

    logoutSession();
    redirect('login.php', 'Logout Berhasil!');
}

?>
