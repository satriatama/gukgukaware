<?php
session_start();
require_once '../login/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    if (empty($id)) {
        $error = "Semua field harus diisi";
        $_SESSION['error'] = $error;
    } else {
        try {
        $sql = "SELECT * FROM location WHERE Id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        if ($result) {
            $sql = "DELETE FROM location WHERE Id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'id' => $_POST['id']
            ]);
            $_SESSION['success'] = "Data berhasil dihapus.";
        } else {
            $_SESSION['error'] = "Data tidak ditemukan.";
        }
        } catch(PDOException $e) {
            $error = "Error: " . $e->getMessage();
            $_SESSION['error'] = $error;
        }
    }
    header("Location: all-data.php");
    exit();
}
?>