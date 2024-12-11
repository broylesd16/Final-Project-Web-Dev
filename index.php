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
        
        <a href="profile.php" class="navbar-item">Profile</a>
        <a href="index.php" class="navbar-item">Main Page</a>
    </section>
    <section class = "header">
        
        <div class="left">
            <h1>GoatKeeper</h1>
            <hr>
            <p>Your ultimate solution for managing your herd with ease and efficiency. Track names, ages, breeds, and more all in one place. </p>
            <br>
            <br>
            <p>Ready to join the herd? Sign up now and get grazing!</p>
            <br>
            <a href="login.php" class = "button">Get Started</a>
        </div>
        
        <div class="right">
            <img src="Designer.jpeg">
        </div>
    </section>

    <section class="info-container">
        <div class="info info-1">
            <h5>Sign Up</h5>
            <img src="sign up.jpeg" alt="Sign Up" style= "height: 412px">
        </div>
        <div class="info info-2">
            <h5>Add Goats</h5>
            <img src="add goats.jpeg" alt="Add Goats" style= "height: 412px">
        </div>
        <div class="info info-3">
            <h5>Manage Your Heard</h5>
            <img src="manage.jpeg" alt="Manage Goats" style= "height: 412px">
        </div>
    </section>

    <section class="alt_main_page">
        <h1 style="text-align: center;">Features Overview</h1>
        <hr>
        <table>
            <tr><td><img src="goat.png" height="400"></td>
            <td style="padding: 20px;">
                <li><strong>Track Your Goat’s Information:</strong></li>
                <p style="padding-left: 22px">Easily manage and view detailed profiles for each goat, including name, age, breed, coat color, field, and more.</p>
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
                <li><strong>Organize Your Fields:</strong></li>
                <p style="padding-left: 22px">Assign goats to specific fields and monitor their movement and activities across different locations.</p>
                <br>
                <li><strong>User-Friendly Interface:</strong></li>
                <p style="padding-left: 22px">Navigate the website with ease thanks to a clean and simple design made for both beginners and experienced goat owners.</p>
                <br>
                <li><strong>Secure User Profiles:</strong></li>
                <p style="padding-left: 22px">Keep your information safe with secure login and personalized user accounts.</p>
            </td></tr>
        </table>
    </section>


    <section class="main_page">
        <h2 style="text-align: center;">Goat T-Shirt</h2>
        <hr>
        <table>
            <tr>
            <td style="padding: 20px;">Celebrate your love for goats with our comfy Goat T-Shirt! Made from 100% breathable cotton, this tee features a whimsical goat illustration that’s sure to turn heads. Available in a variety of sizes, the classic fit makes it perfect for everyday wear. Pair it with your favorite jeans or shorts for a laid-back look that’s perfect for any occasion. Wear it to the farm, the beach, or your next gathering with friends, and let the world know you’re a proud goat fan!</td>
            <td><img src="shirt.png" height="200"></td></tr>
        </table>
    </section>

    </main>
    <footer>
        <p>Contact me at: <a href="mailto:broylesd16@mycu.concord.edu">broylesd16@mycu.concord.edu</a></p>
    </footer>
</body>
</html>
