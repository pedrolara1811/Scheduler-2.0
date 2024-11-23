<?php
$servername = "localhost";
$username = "root";
$password = "papa";
$dbname = "scheduler";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Delete address first (to avoid foreign key constraint issues)
    $sql_address = "DELETE FROM address WHERE contact_id = $id";
    $conn->query($sql_address);

    // Then delete contact
    $sql_contact = "DELETE FROM contact WHERE id = $id";
    if ($conn->query($sql_contact) === TRUE) {
        echo "Contact deleted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
header("Location: contacts.php");
exit();

?>
