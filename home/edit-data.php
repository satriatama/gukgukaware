<?php
session_start();
require_once '../login/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $StoreName = trim($_POST['store_name']);
    $StoreAddress = $_POST['location'];
    $Status = $_POST['status'];
    $Latitude = $_POST['latitude'];
    $Longitude = $_POST['longitude'];
    $lastChanged = date('Y-m-d H:i:s');
    
    if (empty($StoreName) || empty($StoreAddress) || empty($Status) || empty($Latitude) || empty($Longitude)) {
        $error = "Semua field harus diisi";
        $_SESSION['error'] = $error;
    } else {
        try {
        $sql = "SELECT * FROM users WHERE Id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $_POST['id']]);
        $result = $stmt->fetch();
        if ($result) {
            $sql = "UPDATE location SET store_name = :store_name, location = :store_address, status = :status, latitude = :latitude, longitude = :longitude, last_changed = :last_changed WHERE Id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'store_name' => $StoreName,
                'store_address' => $StoreAddress,
                'status' => $Status,
                'latitude' => $Latitude,
                'longitude' => $Longitude,
                'last_changed' => $lastChanged,
                'id' => $_POST['id']
            ]);
            $_SESSION['success'] = "Data berhasil diubah.";
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