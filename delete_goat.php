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

// Check if goat_id is provided in the URL
if (isset($_GET['goat_id'])) {
    $goat_id = $_GET['goat_id'];

    // Ensure the goat belongs to the logged-in user
    $sql = 'DELETE FROM goats2 WHERE goat_id = :goat_id AND id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['goat_id' => $goat_id, 'user_id' => $user_id]);

    header('Location: profile.php');
    exit;
} else {
    die('Goat ID not specified.');
}
