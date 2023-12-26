<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = 'db';  // Docker Compose service name
    $db = 'mydatabase';
    $user = 'db_user';
    $pass = 'db_password';
    $charset = 'utf8mb4';

    $mysqli = new mysqli($host, $user, $pass, $db);

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Handle form data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';

    // Validate and insert data into the 'users' table
    if (!empty($name) && !empty($email)) {
        $insertUser = $mysqli->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $insertUser->bind_param("ss", $name, $email);
        $insertUser->execute();
        $insertUser->close();

        echo "User data inserted successfully!";
    } else {
        echo "Name and email fields are required!";
    }

    $mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insert Data</title>
</head>
<body>
    <h1>Insert User Data</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
