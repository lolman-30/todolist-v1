<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_todo");

// cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// truncate table jika tidak ada data
$sql = "SELECT COUNT(*) AS count FROM todo_list";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$count = $row['count'];
if ($count == 0) {
    mysqli_query($conn, "TRUNCATE TABLE todo_list");
}

// ambil nilai task dan deadline dari form
$task = $_POST['task_name'];
$deadline = $_POST['deadline'];

// buat query untuk menambahkan task ke database
$sql = "INSERT INTO todo_list (task_name, deadline) VALUES ('$task', '$deadline')";

if (mysqli_query($conn, $sql)) {
    $response = array(
        "status" => "success",
        "message" => "Task added successfully."
    );
} else {
    $response = array(
        "status" => "error",
        "message" => "Error adding task: " . mysqli_error($conn)
    );
}

echo json_encode($response);

mysqli_close($conn);
?>
