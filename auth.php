<?php
// auth.php - Authentication functions
function register_user($pdo, $username, $password) {
    try {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            'username' => $username,
            'password' => $hashed_password
        ]);
    } catch (PDOException $e) {
        return false;
    }
}

function login_user($pdo, $username, $password) {
    // Prepare SQL query to fetch the user from the database based on username
    $sql = "SELECT id, username, password FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    // Check if the user exists and verify the password
    if ($user && password_verify($password, $user['password'])) {
        // Start session and store user info in session variables
        $_SESSION['user_id'] = $user['id'];         // Store user_id in session
        $_SESSION['username'] = $user['username'];  // Optionally store the username
        return true;  // Login successful
    }

    // Return false if login fails (invalid username or password)
    return false;
}
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function logout_user() {
    $_SESSION = array();
    session_destroy();
}
?>