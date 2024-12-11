<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<header>
    <title>GoatKeeper</title>
    <link rel="stylesheet" href="styles.css?v=1.1">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</header>
<body>
    <main>
    <section class="navbar">
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Show Logout button if user is logged in -->
            <a href="logout.php" class="navbar-item">Logout</a>
        <?php else: ?>
            <!-- Show Login button if user is not logged in -->
            <a href="login.php" class="navbar-item">Login</a>
        <?php endif; ?>
        <a href="about.php" class="navbar-item">About</a>
        <a href="profile.php" class="navbar-item">Profile</a>
        <a href="index.php" class="navbar-item">Main Page</a>
    </section>  
    <section class = "about-header">
            <h1 style="text-align: center;">About Us</h1>
            <hr>
            <h2 style="text-align: center;">Our Mission</h2>
            <br>
            <p style="text-align: center; font-size: 22px;">To provide goat owners with an easy-to-use platform to manage their herd</p>
    </section>

    <section class="alt_main_page">
        <h1 style="text-align: center;">Features Overview</h1>
        <hr>
    
    </section>


    <section class="main_page">
        <h1 style="text-align: center;">Goat News</h1>
        <hr>
        <table>
            <tr>
            <td style="font-size: 22px;">Website Creation Completed on 12/11/2024</td>
            <td><img src="normalgoat.webp" height="100"></td></tr>
        </table>
    </section>
<p>e</p>
    </main>
    <footer>
        <p>Copyright: Goat Solutions LLC</p>
    </footer>
</body>
</html>
