<?php
session_start();
include '../login/config.php';

// Periksa apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Ambil data dari form
    $store_name = $_GET['store_name'] ?? '';
    $location = $_GET['location'] ?? '';
    $latitude = $_GET['latitude'] ?? '';
    $longitude = $_GET['longitude'] ?? '';

    // Validasi input
    if (empty($store_name) || empty($location) || empty($latitude) || empty($longitude)) {
        echo "All fields are required!";
        exit();
    }

    try {
        // Ambil ID terakhir dari tabel
        $sql = "SELECT MAX(id) AS last_id FROM location";
        $stmt = $pdo->query($sql);
        $last_id_row = $stmt->fetch(PDO::FETCH_ASSOC);
        $new_id = ($last_id_row['last_id'] ?? 0) + 1;

        // Status dan last_changed default
        $status = "New Location";
        $last_changed = date('Y-m-d H:i:s');

        // Insert data ke database
        $sql = "INSERT INTO location (id, store_name, location, latitude, longitude, status, last_changed) 
                VALUES (:id, :store_name, :location, :latitude, :longitude, :status, :last_changed)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id' => $new_id,
            ':store_name' => $store_name,
            ':location' => $location,
            ':latitude' => $latitude,
            ':longitude' => $longitude,
            ':status' => $status,
            ':last_changed' => $last_changed
        ]);

        // Redirect ke halaman sukses atau tampilan
        header("Location: all-data.php?message=Data successfully added!");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    echo "Invalid request method.";
    exit();
}
?>
