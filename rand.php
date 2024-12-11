<?php
// about.php - About page of the website
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Betty's Personal Goat Manager</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Header Section -->
    <header class="header">
        <div class="left">
            <h1>Betty's Personal Goat Manager</h1>
            <p>Your ultimate goat management tool for keeping track of your beloved herd!</p>
        </div>
        <div class="right">
            <img src="normalgoat.webp" alt="Goat Image">
        </div>
    </header>

    <!-- About Section -->
    <section class="main_page">
        <h1 style="text-align: center;">About Us</h1>
        <hr>
        <div class="info-container">
            <div class="info info-1">
                <h3>Our Mission</h3>
                <p>To provide goat owners with an easy-to-use platform to manage their herd, track health, and share goat news!</p>
            </div>
            <div class="info info-2">
                <h3>Our Features</h3>
                <ul>
                    <li>Manage your goat herd efficiently</li>
                    <li>Track health stats and breeding history</li>
                    <li>Upload goat images</li>
                    <li>View and add new goats easily</li>
                    <li>And much more!</li>
                </ul>
            </div>
            <div class="info info-3">
                <h3>Our History</h3>
                <p>Founded in 2024 by Betty, the website was born out of the desire to make goat management easy and fun. With over a decade of goat farming experience, Betty combined her knowledge with the power of technology to build this platform.</p>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="alt_main_page">
        <h1 style="text-align: center;">Meet the Team</h1>
        <hr>
        <div class="info-container">
            <div class="info info-1">
                <img src="betty.jpg" alt="Betty's Photo" style="max-width: 150px; border-radius: 50%;">
                <h3>Betty</h3>
                <p>Founder & Goat Enthusiast</p>
            </div>
            <div class="info info-2">
                <img src="developer.jpg" alt="Developer's Photo" style="max-width: 150px; border-radius: 50%;">
                <h3>John</h3>
                <p>Lead Developer & Technical Genius</p>
            </div>
            <div class="info info-3">
                <img src="designer.jpg" alt="Designer's Photo" style="max-width: 150px; border-radius: 50%;">
                <h3>Sarah</h3>
                <p>UI/UX Designer & Goat Lover</p>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Betty's Personal Goat Manager. All rights reserved.</p>
    </footer>

</body>
</html>
