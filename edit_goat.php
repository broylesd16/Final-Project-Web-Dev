<?php
require_once 'auth.php';

// Check if user is logged in
if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Connect to the database
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
// Get the goat ID from the URL
if (isset($_GET['goat_id'])) {
    $goat_id = $_GET['goat_id'];

    // Fetch goat data
    $sql = 'SELECT goat_id, goat_name, age, breed, coat_color, field, image, image_type 
            FROM goats2 
            WHERE goat_id = :goat_id AND id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['goat_id' => $goat_id, 'user_id' => $_SESSION['user_id']]);
    $goat = $stmt->fetch();

    if (!$goat) {
        echo "Goat not found.";
        exit;
    }

    // Handle form submission for editing
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $goat_name = htmlspecialchars($_POST['goat_name']);
        $age = htmlspecialchars($_POST['age']);
        $breed = htmlspecialchars($_POST['breed']);
        $coat_color = htmlspecialchars($_POST['coat_color']);
        $field = htmlspecialchars($_POST['field']);

        // Check if a new image is uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = file_get_contents($_FILES['image']['tmp_name']);
            $image_type = $_FILES['image']['type'];
            // Update image in the database
            $update_sql = 'UPDATE goats2 
                           SET goat_name = :goat_name, age = :age, breed = :breed, coat_color = :coat_color, 
                               field = :field, image = :image, image_type = :image_type 
                           WHERE goat_id = :goat_id AND id = :user_id';
            $stmt_update = $pdo->prepare($update_sql);
            $stmt_update->execute([
                'goat_name' => $goat_name,
                'age' => $age,
                'breed' => $breed,
                'coat_color' => $coat_color,
                'field' => $field,
                'image' => $image,
                'image_type' => $image_type,
                'goat_id' => $goat_id,
                'user_id' => $_SESSION['user_id']
            ]);
        } else {
            // If no new image, update other fields only
            $update_sql = 'UPDATE goats2 
                           SET goat_name = :goat_name, age = :age, breed = :breed, coat_color = :coat_color, 
                               field = :field 
                           WHERE goat_id = :goat_id AND id = :user_id';
            $stmt_update = $pdo->prepare($update_sql);
            $stmt_update->execute([
                'goat_name' => $goat_name,
                'age' => $age,
                'breed' => $breed,
                'coat_color' => $coat_color,
                'field' => $field,
                'goat_id' => $goat_id,
                'user_id' => $_SESSION['user_id']
            ]);
        }

        // Redirect after update
        header("Location: profile.php");
        exit;
    }
} else {
    echo "Goat ID not specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Goat</title>
    <link rel="stylesheet" href="styles2.css">
</head>
<body style="background-color: #333;">
    <h1 style="text-align: center; color: white;">Edit Goat</h1>
    <form action="edit_goat.php?goat_id=<?php echo $goat['goat_id']; ?>" method="post" enctype="multipart/form-data">
        <label for="goat_name">Goat Name:</label>
        <input type="text" id="goat_name" name="goat_name" value="<?php echo htmlspecialchars($goat['goat_name']); ?>" required>
        <br><br>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($goat['age']); ?>" required>
        <br><br>

        <label for="breed">Breed:</label>
        <input type="text" id="breed" name="breed" value="<?php echo htmlspecialchars($goat['breed']); ?>" required>
        <br><br>

        <label for="coat_color">Coat Color:</label>
        <input type="text" id="coat_color" name="coat_color" value="<?php echo htmlspecialchars($goat['coat_color']); ?>" required>
        <br><br>

        <label for="field">Field:</label>
        <input type="text" id="field" name="field" value="<?php echo htmlspecialchars($goat['field']); ?>" required>
        <br><br>

        <label for="image">New Image (Optional):</label>
        <input type="file" id="image" name="image" accept="image/*">
        <br><br>

        <!-- Display current image if exists -->
        <h3>Current Image:</h3>
        <?php if ($goat['image']): ?>
            <img src="data:<?php echo $goat['image_type']; ?>;base64,<?php echo base64_encode($goat['image']); ?>" alt="Goat Image" style="height: 100px;">
        <?php else: ?>
            No image available.
        <?php endif; ?>
        <br><br>

        <input type="submit" value="Update Goat">
    </form>
</body>
</html>
