<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "papa";
$dbname = "scheduler";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch contacts and their corresponding address
$sql = "SELECT contact.name, contact.last_name, contact.lada, contact.phone, 
        CONCAT(address.street, ', ', address.house_number, ', ', address.suburb, ', ', address.city, ', ', address.state, ', ', address.country, ', ', address.postal_code) AS full_address
        FROM contact 
        JOIN address ON contact.id = address.contact_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['lada']) . "</td>";
        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
        echo "<td>" . htmlspecialchars($row['full_address']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No contacts found.</td></tr>";
}

$conn->close();
?>
