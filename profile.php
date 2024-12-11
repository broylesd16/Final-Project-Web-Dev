<?php

session_start();
require_once 'auth.php';

// Check if user is logged in
if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

$host = 'localhost'; 
$dbname = 'final'; 
$user = 'root'; 
$pass = 'mysql';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['goat_name']) && isset($_POST['age']) &&
        isset($_POST['breed']) && isset($_POST['coat_color']) &&
        isset($_POST['field']) && isset($_FILES['image'])
    ) {
        // Insert new entry
        $goat_name = htmlspecialchars($_POST['goat_name']);
        $age = htmlspecialchars($_POST['age']);
        $breed = htmlspecialchars($_POST['breed']);
        $coat_color = htmlspecialchars($_POST['coat_color']);
        $field = htmlspecialchars($_POST['field']);

        // Handle image upload
        $image = file_get_contents($_FILES['image']['tmp_name']); // Get binary data
        $image_type = $_FILES['image']['type']; // Get MIME type

        $insert_sql = 'INSERT INTO goats (goat_name, age, breed, coat_color, field, image, image_type)
                       VALUES (:goat_name, :age, :breed, :coat_color, :field, :image, :image_type)';
        $stmt_insert = $pdo->prepare($insert_sql);
        $stmt_insert->execute([
            'goat_name' => $goat_name,
            'age' => $age,
            'breed' => $breed,
            'coat_color' => $coat_color,
            'field' => $field,
            'image' => $image,
            'image_type' => $image_type
        ]);

        // Redirect to the same page to prevent form re-submission on page reload
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;  // Ensure the script stops executing after redirection
    }
}

// Get all goats for main table
$sql = 'SELECT goat_id, goat_name, age, breed, coat_color, field, image, image_type FROM goats';
$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Betty's Personal Goat Manager</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Your page content here -->
    <!-- (the rest of your HTML stays the same) -->

    <!-- Form section with container -->
    <div class="form-container">
        <h2>Add a Goat to Your Collection</h2>
        <form action="profile.php" method="post" enctype="multipart/form-data">
            <label for="goat_name">Goat Name:</label>
            <input type="text" id="goat_name" name="goat_name" required>
            <br><br>
            
            <label for="age">Age:</label>
            <input type="text" id="age" name="age" required>
            <br><br>
            
            <label for="breed">Breed:</label>
            <input type="text" id="breed" name="breed" required>
            <br><br>
            
            <label for="coat_color">Coat Color:</label>
            <input type="radio" id="yes" name="coat_color" value="yes">
            <label for="yes">Yes</label>
            <input type="radio" id="no" name="coat_color" value="no">
            <label for="no">No</label>
            <br><br>
            
            <label for="field">Field:</label>
            <input type="text" id="field" name="field" required>
            <br><br>
            
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            <br><br>
            
            <input type="submit" value="Add Goat to Collection">
        </form>
    </div>

</body>
</html>
