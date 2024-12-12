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

    <section class="our-story">
        <h1 style="text-align: center;">Our Story</h1>
        <hr>
        <p style="font-size: 22px;">Welcome to GoatKeeper, where passion meets precision in the world of goat management. Our journey began with a simple idea: to revolutionize the way goat farming is approached, ensuring that every goat receives the care and attention it deserves.</p>
        <br>
        <p style="font-size: 22px;">At GoatKeeper, we believe that successful goat farming starts with understanding the unique needs of each goat. Our vision is to provide farmers with the tools, knowledge, and support they need to manage their herds effectively and humanely. We are committed to promoting sustainable farming practices that benefit both the goats and the environment.</p>
    </section>


    <section class="alt_main_page">
        <h1 style="text-align: center;">Our Approach</h1>
        <hr>
        <table>
            <td style="padding: 20px;">
                <h2 style="padding-left: 22px">We combine traditional farming wisdom with modern technology to offer comprehensive goat management solutions. Our services include:</h2>
                <br>
                <li><strong>Add and Update Goat Records:</strong></li>
                <p style="padding-left: 22px">Quickly add new goats to your collection or update existing entries with new details or images.</p>
                <br>
                <li><strong>Upload Goat Photos:</strong></li>
                <p style="padding-left: 22px">Keep track of your goats visually by uploading and storing photos for each goat.</p>
                <br>
                <li><strong>Search and Filter Goats:</strong></li>
                <p style="padding-left: 22px">Search for goats by name to find exactly what you're looking for with ease.</p>
                <br>
                <li><strong>Training and Education:</strong></li>
                <p style="padding-left: 22px">Workshops and resources to help farmers stay informed about the latest in goat care and management.</p>
                <br>
            </td></tr>
        </table>
    </section>
<p>e</p>
    </main>
    <footer>
        <p>Copyright: Goat Solutions LLC</p>
    </footer>
</body>
</html>
