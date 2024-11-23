<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
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

// Obtener el rol del usuario
$role = $_SESSION['role'];
$isAdmin = ($role === 'admin');

// Consultar contactos y direcciones
$sql = "SELECT c.id, c.name, c.last_name, c.lada, c.phone, 
               CONCAT(a.street, ', ', a.house_number, ', ', a.suburb, ', ', a.city, ', ', a.state, ', ', a.country, ', ', a.postal_code) AS full_address
        FROM contact c
        LEFT JOIN address a ON c.id = a.contact_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Contact List</h1>

    <!-- Logout -->
    <div style="margin-bottom: 20px;">
        <a href="logout.php" style="background-color: gray; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;">Logout</a>
    </div>

    <!-- Contact Table -->
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Last Name</th>
                <th>LADA</th>
                <th>Phone</th>
                <th>Address</th>
                <?php if ($isAdmin) echo "<th>Actions</th>"; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['lada']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['full_address']) . "</td>";
                    if ($isAdmin) {
                        echo "<td>
                                <div style='display: flex; gap: 10px;'>
                                    <form action='update_contact_form.php' method='get'>
                                        <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>
                                        <button type='submit' style='background-color: blue; color: white;'>Update</button>
                                    </form>
                                    <form action='delete_contact.php' method='post'>
                                        <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>
                                        <button type='submit' style='background-color: red; color: white;'>Delete</button>
                                    </form>
                                </div>
                              </td>";
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='" . ($isAdmin ? "6" : "5") . "'>No contacts found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
