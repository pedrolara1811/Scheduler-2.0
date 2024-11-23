<?php
$servername = "localhost";
$username = "root";
$password = "papa";
$dbname = "scheduler";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT contact.id, name, last_name, lada, phone, 
               street, house_number, suburb, city, state, country, postal_code
        FROM contact
        JOIN address ON contact.id = address.contact_id
        WHERE contact.id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Contact</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Update Contact</h1>
    <form action="update_contact.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $row['name']; ?>" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" value="<?php echo $row['last_name']; ?>" required><br>

        <label for="lada">LADA:</label>
        <input type="text" name="lada" id="lada" value="<?php echo $row['lada']; ?>" required><br>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" value="<?php echo $row['phone']; ?>" required><br>

        <h3>Address</h3>

        <label for="street">Street:</label>
        <input type="text" name="street" id="street" value="<?php echo $row['street']; ?>" required><br>

        <label for="house_number">House Number:</label>
        <input type="number" name="house_number" id="house_number" value="<?php echo $row['house_number']; ?>" required><br>

        <label for="suburb">Suburb:</label>
        <input type="text" name="suburb" id="suburb" value="<?php echo $row['suburb']; ?>" required><br>

        <label for="city">City:</label>
        <input type="text" name="city" id="city" value="<?php echo $row['city']; ?>" required><br>

        <label for="state">State:</label>
        <input type="text" name="state" id="state" value="<?php echo $row['state']; ?>" required><br>

        <label for="country">Country:</label>
        <input type="text" name="country" id="country" value="<?php echo $row['country']; ?>" required><br>

        <label for="postal_code">Postal Code:</label>
        <input type="text" name="postal_code" id="postal_code" value="<?php echo $row['postal_code']; ?>" required><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
