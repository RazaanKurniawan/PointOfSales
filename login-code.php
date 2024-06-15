<?php

require 'config/function.php';

if (isset($_POST['loginBtn'])) {

    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    if ($email != '' && $password != '') {
        $query = "SELECT * FROM admin WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if ($result) {

            if (mysqli_num_rows($result) == 1) {

                $row = mysqli_fetch_assoc($result);
                $hashedPassword = $row['password'];

                if (!password_verify($password, $hashedPassword)) {
                    redirect('login.php', 'Password tidak Valid!');
                }

                if ($row['is_ban'] == 1) {
                    redirect('login.php', 'Akun kamu telah diban!. Tolong hubungi Admin.');
                }

                $_SESSION['loggedIn'] = true;
                $_SESSION['loggedInUser'] = [
                    'user_id' => $row['id'],
                    'nama' => $row['nama'],
                    'email' => $row['email'],
                    'no_telp' => $row['no_telp'],
                    'level' => $row['level']

                ];
                
                global $conn;
                $query = "INSERT INTO login_history (admin_id, login_time) VALUES ('" . $row['id'] . "', NOW())";
                mysqli_query($conn, $query);

                redirect('admin/index.php', 'Login telah berhasil!');
            } else {
                redirect('login.php', 'Email tidak Valid!');
            }
        }
    } else {
        redirect('login.php', 'Semua kolom harus diisi!');
    }
}
