<?php

if (isset($_SESSION['loggedIn'])) {

    $email = validate($_SESSION['loggedInUser']['email']);

    $query = "SELECT * FROM admin WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {

        logoutSession();
        redirect('../login.php', 'Akses ditolak!');
    } else {

        $row = mysqli_fetch_assoc($result);
        if ($row['is_ban'] == 1) {
            logoutSession();
            redirect('../login.php', 'Akun kamu telah diban!. Tolong hubungi admin.');
        }
    }

} else {
    redirect('../login.php', 'Login untuk melanjutkan...');
}

?>