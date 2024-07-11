<?php
session_start();
include('koneksi.php');

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $query = "SELECT * FROM siswa WHERE username='$username' AND password='$password'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['siswa_id'] = $row['id'];
        header("Location: index.php?page=kehadiran&act=presensi");
        exit();
    } else {
        echo "Username atau password salah.";
    }
}
?>

<form method="post" action="">
    <label>Username:</label>
    <input type="text" name="username" required>
    <label>Password:</label>
    <input type="password" name="password" required>
    <button type="submit" name="login">Login</button>
</form>
