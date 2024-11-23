<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root";
$password = "papa";
$dbname = "scheduler";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Step 1: Insert Contact data
    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $lada = $_POST['lada'];
    $phone = $_POST['phone'];

    $sql_contact = "INSERT INTO contact (name, last_name, lada, phone) 
                    VALUES ('$name', '$last_name', '$lada', '$phone')";

    if ($conn->query($sql_contact) === TRUE) {
        // Get the ID of the last inserted contact
        $contact_id = $conn->insert_id;

        // Step 2: Insert Address data with the foreign key to Contact
        $street = $_POST['street'];
        $house_number = $_POST['house_number'];
        $suburb = $_POST['suburb'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $country = $_POST['country'];
        $postal_code = $_POST['postal_code'];

        $sql_address = "INSERT INTO address (contact_id, street, house_number, suburb, city, state, country, postal_code) 
                        VALUES ('$contact_id', '$street', '$house_number', '$suburb', '$city', '$state', '$country', '$postal_code')";

        if ($conn->query($sql_address) === TRUE) {
            echo "New contact and address registered successfully!";
        } else {
            echo "Error: " . $sql_address . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql_contact . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
