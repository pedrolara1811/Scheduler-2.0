<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Verificar si el usuario es admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "papa";
$dbname = "scheduler";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $lada = $_POST['lada'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $street = $_POST['street'] ?? '';
    $house_number = $_POST['house_number'] ?? '';
    $suburb = $_POST['suburb'] ?? '';
    $city = $_POST['city'] ?? '';
    $state = $_POST['state'] ?? '';
    $country = $_POST['country'] ?? '';
    $postal_code = $_POST['postal_code'] ?? '';

    if (!empty($name) && !empty($last_name) && !empty($lada) && !empty($phone)) {
        $stmt = $conn->prepare("INSERT INTO contact (name, last_name, lada, phone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $name, $last_name, $lada, $phone);
        $stmt->execute();

        // Obtener el último ID insertado
        $contact_id = $conn->insert_id;

        // Insertar dirección asociada si se proporcionó
        if (!empty($street) || !empty($house_number) || !empty($suburb)) {
            $stmt = $conn->prepare(
                "INSERT INTO address (contact_id, street, house_number, suburb, city, state, country, postal_code) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param("isssssss", $contact_id, $street, $house_number, $suburb, $city, $state, $country, $postal_code);
            $stmt->execute();
        }

        header("Location: contacts.php");
        exit;
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Contact</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Add New Contact</h1>

    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>

    <form action="add_contact.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br>

        <label for="lada">LADA:</label>
        <input type="number" id="lada" name="lada" required><br>

        <label for="phone">Phone:</label>
        <input type="number" id="phone" name="phone" required><br>

        <h3>Address (optional):</h3>
        <label for="street">Street:</label>
        <input type="text" id="street" name="street"><br>

        <label for="house_number">House Number:</label>
        <input type="text" id="house_number" name="house_number"><br>

        <label for="suburb">Suburb:</label>
        <input type="text" id="suburb" name="suburb"><br>

        <label for="city">City:</label>
        <input type="text" id="city" name="city"><br>

        <label for="state">State:</label>
        <input type="text" id="state" name="state"><br>

        <label for="country">Country:</label>
        <input type="text" id="country" name="country"><br>

        <label for="postal_code">Postal Code:</label>
        <input type="text" id="postal_code" name="postal_code"><br>

        <button type="submit" style="background-color: green; color: white;">Add Contact</button>
    </form>

    <a href="contacts.php" style="display: inline-block; margin-top: 20px;">Back to Contact List</a>
</body>
</html>

<?php
$conn->close();
?>
