<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $error = "Semua field harus diisi";
        $_SESSION['error'] = $error;
    } else {
        try {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = md5($password);
        echo $password;

        $sql = "SELECT * FROM users WHERE email='$email' and password='$password'";
        $result = $pdo->query($sql);
        if ($result->rowCount() == 1) {
            // Login berhasil
            $result = $result->fetch();
            // Simpan user_id dan email ke session
            $_SESSION['user_id'] = $result['id'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['firstname'] = $result['firstName'];
            // Redirect ke dashboard
            var_dump($_SESSION);
            header("Location: ../home/dashboard.php");
            exit();
        } else {
            // return $error; to index.php
            $_SESSION['error'] = "Email atau password salah.";
        }
        } catch(PDOException $e) {
            $error = "Error: " . $e->getMessage();
            $_SESSION['error'] = "Terjadi kesalahan. Silahkan coba lagi.";
        }
    }
    header("Location: index.php");
    exit();
}
?>