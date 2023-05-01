<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_todo");

// cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// buat query untuk mengambil data dari tabel todo_list
$sql = "SELECT * FROM todo_list";

$result = mysqli_query($conn, $sql);

// simpan hasil query ke dalam sebuah array
$tasks = array();
while ($row = mysqli_fetch_assoc($result)) {
    $tasks[] = $row;
}

// tutup koneksi
mysqli_close($conn);

// kirim data sebagai respon JSON
header('Content-Type: application/json');
echo json_encode($tasks);
?>
