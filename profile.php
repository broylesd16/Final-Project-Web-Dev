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
    $search_sql = 'SELECT id, goat_name, age, breed, coat_color, field, image FROM goats WHERE goat_name LIKE :search';
    $search_stmt = $pdo->prepare($search_sql);
    $search_stmt->execute(['search' => $search_term]);
    $search_results = $search_stmt->fetchAll();
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['goat_name']) && isset($_POST['age']) && isset($_POST['breed']) && isset($_POST['coat_color'])) {
        // Insert new entry
        $goat_name = htmlspecialchars($_POST['goat_name']);
        $age = htmlspecialchars($_POST['age']);
        $breed = htmlspecialchars($_POST['breed']);
        $coat_color = htmlspecialchars($_POST['coat_color']);
        
        $insert_sql = 'INSERT INTO books (goat_name, age, breed, coat_color) VALUES (:goat_name, :age, :breed, :coat_color)';
        $stmt_insert = $pdo->prepare($insert_sql);
        $stmt_insert->execute(['goat_name' => $goat_name, 'age' => $age, 'breed' => $breed, 'coat_color' => $coat_color]);
    } elseif (isset($_POST['delete_id'])) {
        // Delete an entry
        $delete_id = (int) $_POST['delete_id'];
        
        $delete_sql = 'DELETE FROM books WHERE id = :id';
        $stmt_delete = $pdo->prepare($delete_sql);
        $stmt_delete->execute(['id' => $delete_id]);
    } elseif (isset($_POST['edit_id'])) {
        $edit_id = (int) $_POST['edit_id'];
        $edit_sql = "UPDATE `books` SET `coat_color` = 'yes' WHERE `books`.`id` = :id";
        $stmt_edit = $pdo->prepare($edit_sql);
        $stmt_edit->execute(['id' => $edit_id]);
    }
}

// Get all books for main table
$sql = 'SELECT id, goat_name, age, breed, coat_color FROM books';
$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Betty's Personal Book Manager</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <h1 class="hero-title">Betty's Personal Book Manager</h1>
        <p class="hero-subtitle">"Track your book collection"</p>
        
        <!-- Search moved to hero section -->
        <div class="hero-search">
            <h2>Search for a Book in Collection</h2>
            <form action="" method="GET" class="search-form">
                <label for="search">Search by age:</label>
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
                                <th>ID</th>
                                <th>goat_name</th>
                                <th>age</th>
                                <th>breed</th>
                                <th>Has Been Read?</th>
                                <th>Read Book</th>
                                <th>Remove Book From Collection</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($search_results as $row): ?>
                                <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['goat_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['age']); ?></td>
                                <td><?php echo htmlspecialchars($row['breed']); ?></td>
                                <td><?php echo htmlspecialchars($row['coat_color']); ?></td>
                                <td>
                                    <form action="index5.php" method="post" style="display:inline;">
                                        <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                                        <input type="submit" value="Read Book">
                                    </form>
                                </td>

                                <td>
                                    <form action="index5.php" method="post" style="display:inline;">
                                        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                        <input type="submit" value="Remove Book From Collection ">
                                    </form>
                                </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No books found matching your search.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Table section with container -->
    <div class="table-container">
        <h2>All Books in Collection</h2>
        <table class="half-width-left-align">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>goat_name</th>
                    <th>age</th>
                    <th>breed</th>
                    <th>Has Been Read?</th>
                    <th>Read Book</th>
                    <th>Remove Book From Collection</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['goat_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['age']); ?></td>
                    <td><?php echo htmlspecialchars($row['breed']); ?></td>
                    <td><?php echo htmlspecialchars($row['coat_color']); ?></td>
                    <td>
                        <form action="index5.php" method="post" style="display:inline;">
                            <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                            <input type="submit" value="Read Book">
                        </form>
                    </td>

                    <td>
                        <form action="index5.php" method="post" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                            <input type="submit" value="Remove Book From Collection ">
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Form section with container -->
    <div class="form-container">
        <h2>Add a Book to your Collection</h2>
        <form action="index5.php" method="post">
            <label for="goat_name">goat_name:</label>
            <input type="text" id="goat_name" name="goat_name" required>
            <br><br>
            <label for="age">age:</label>
            <input type="text" id="age" name="age" required>
            <br><br>
            <label for="breed">breed:</label>
            <input type="text" id="breed" name="breed" required>
            <br><br>
            <label for="coat_color">Read?:</label>
            <input type="radio" id="yes" name="coat_color" value="yes">
            <label for="yes">Yes</label>
            <input type="radio" id="no" name="coat_color" value="no">
            <label for="no">No</label>
            <br><br>
            <input type="submit" value="Add Book to Collection">
        </form>
    </div>
</body>
</html>