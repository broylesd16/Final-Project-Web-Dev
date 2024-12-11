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

// Handle book search
$search_results = null;
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = '%' . $_GET['search'] . '%';
    $search_sql = 'SELECT goat_id, goat_name, age, breed, coat_color, field, image, image_type FROM goats WHERE age LIKE :search';
    $search_stmt = $pdo->prepare($search_sql);
    $search_stmt->execute(['search' => $search_term]);
    $search_results = $search_stmt->fetchAll();
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
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Get all goats for main table
$sql = 'SELECT goat_id, goat_name, age, breed, coat_color, field, image, image_type FROM goats';
$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <section class="flex-container">
        <a href="login.php" class="box box-1">Login</a>
        <a href="profile.php" class="box box-2">Profile</a>
        <a href="index.php" class="box box-3">Main Page</a>
    </section>
    <meta charset="UTF-8">
    <title>Betty's Personal Goat Manager</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <h1 class="hero-title">Betty's Personal Goat Manager</h1>
        <p class="hero-subtitle">"Track your goat collection"</p>
        
        <!-- Search moved to hero section -->
        <div class="hero-search">
            <h2>Search for a Goat by Age</h2>
            <form action="" method="GET" class="search-form">
                <label for="search">Search by Age:</label>
                <input type="text" id="search" name="search" required>
                <input type="submit" value="Search">
            </form>
            
            <?php if (isset($_GET['search'])): ?>
                <div class="search-results">
                    <h3>Search Results</h3>
                    <?php if ($search_results && count($search_results) > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Goat ID</th>
                                    <th>Goat Name</th>
                                    <th>Age</th>
                                    <th>Breed</th>
                                    <th>Coat Color</th>
                                    <th>Field</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($search_results as $row): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['goat_id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['goat_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                                        <td><?php echo htmlspecialchars($row['breed']); ?></td>
                                        <td><?php echo htmlspecialchars($row['coat_color']); ?></td>
                                        <td><?php echo htmlspecialchars($row['field']); ?></td>
                                        <td>
                                            <?php if ($row['image_type']): ?>
                                                <img src="data:<?php echo $row['image_type']; ?>;base64,<?php echo base64_encode($row['image']); ?>" alt="Goat Image" style="width: 1000px; height: 1000px;">
                                            <?php else: ?>
                                                No Image
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <!-- Add actions like edit/delete -->
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No goats found matching your search.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Table section with container -->
    <div class="table-container">
        <h2>All Goats in Collection</h2>
        <table class="half-width-left-align">
            <thead>
                <tr>
                    <th>Goat ID</th>
                    <th>Goat Name</th>
                    <th>Age</th>
                    <th>Breed</th>
                    <th>Coat Color</th>
                    <th>Field</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['goat_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['goat_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                        <td><?php echo htmlspecialchars($row['breed']); ?></td>
                        <td><?php echo htmlspecialchars($row['coat_color']); ?></td>
                        <td><?php echo htmlspecialchars($row['field']); ?></td>
                        <td>
                            <?php if ($row['image']): ?>
                                <img src="data:<?php echo $row['image_type']; ?>;base64,<?php echo base64_encode($row['image']); ?>" alt="Goat Image" style="width: 50px; height: 50px;">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td>
                            <!-- Add actions like edit/delete -->
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Form section with container -->
    <div class="form-container">
        <h2>Add a Goat to Your Collection</h2>
        <form action="profile.php" method="post" enctype="multipart/form-data">
            <label for="goat_name">Goat Name:</label>
            <input type="text" id="goat_name" name="goat_name" required>
            <br><br>
            
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>
            <br><br>
            
            <label for="breed">Breed:</label>
            <input type="text" id="breed" name="breed" required>
            <br><br>
            
            <label for="coat_color">Coat Color:</label>
            <input type="text" id="yes" name="coat_color" required>
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
