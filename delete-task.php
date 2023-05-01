<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_todo");

// cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ambil nilai task_name dari form
$task_name = $_POST['task_name'];

// buat query untuk menghapus task dari database
$sql = "DELETE FROM todo_list WHERE task_name='$task_name'";

if (mysqli_query($conn, $sql)) {
    $response = array(
        "status" => "success",
        "message" => "Task deleted successfully."
    );
} else {
    $response = array(
        "status" => "error",
        "message" => "Error deleting task: " . mysqli_error($conn)
    );
}

echo json_encode($response);

mysqli_close($conn);
?>
