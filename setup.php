<?php
// Setup Script for Portfolio Database
// Run this file once to setup the database

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'rdf';

echo "<h1>Portfolio Database Setup</h1>\n";

// Create connection
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    die("<p style='color: red;'>Connection failed: " . $conn->connect_error . "</p>");
}

echo "<p style='color: green;'>✓ Connected to MySQL successfully</p>\n";

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color: green;'>✓ Database '$dbname' created successfully</p>\n";
} else {
    die("<p style='color: red;'>Error creating database: " . $conn->error . "</p>");
}

// Select database
$conn->select_db($dbname);

// Read SQL file
$sql = file_get_contents('database/portfolio_db.sql');

// Execute SQL
if ($conn->multi_query($sql)) {
    echo "<p style='color: green;'>✓ Database tables created successfully</p>\n";

    // Wait for all queries to complete
    while ($conn->more_results() && $conn->next_result()) {
        // Process results
    }
} else {
    echo "<p style='color: red;'>Error executing SQL: " . $conn->error . "</p>\n";
}

// Create uploads directory
if (!file_exists('uploads')) {
    mkdir('uploads', 0755, true);
    echo "<p style='color: green;'>✓ Uploads directory created</p>\n";
} else {
    echo "<p style='color: green;'>✓ Uploads directory already exists</p>\n";
}

// Check uploads directory permissions
if (is_writable('uploads')) {
    echo "<p style='color: green;'>✓ Uploads directory is writable</p>\n";
} else {
    echo "<p style='color: orange;'>⚠ Uploads directory is not writable. Please set permissions to 755 or 777</p>\n";
}

$conn->close();

echo "<h2 style='color: green;'>Setup Complete!</h2>\n";
echo "<p>You can now access:</p>\n";
echo "<ul>\n";
echo "<li><a href='index.php'>Portfolio Website</a></li>\n";
echo "<li><a href='admin/'>Admin Panel</a></li>\n";
echo "</ul>\n";
echo "<p><strong>Note:</strong> Delete this setup.php file after setup for security reasons.</p>\n";
