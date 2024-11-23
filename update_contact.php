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
    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $lada = $_POST['lada'];
    $phone = $_POST['phone'];
    $street = $_POST['street'];
    $house_number = $_POST['house_number'];
    $suburb = $_POST['suburb'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $postal_code = $_POST['postal_code'];

    $sql_contact = "UPDATE contact SET name='$name', last_name='$last_name', lada='$lada', phone='$phone' WHERE id=$id";
    $sql_address = "UPDATE address SET street='$street', house_number='$house_number', suburb='$suburb', city='$city', 
                    state='$state', country='$country', postal_code='$postal_code' WHERE contact_id=$id";

    if ($conn->query($sql_contact) === TRUE && $conn->query($sql_address) === TRUE) {
        echo "Contact updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
header("Location: contacts.php");
exit();
?>
