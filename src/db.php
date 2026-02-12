<?php
$DB_HOST = getenv('DB_HOST') ?: 'db';
$DB_USER = getenv('DB_USER') ?: 'appuser';
$DB_PASS = getenv('DB_PASS') ?: 'apppass';
$DB_NAME = getenv('DB_NAME') ?: 'app_db';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

function esc($s) {
    global $conn;
    return htmlspecialchars($conn->real_escape_string(trim($s)));
}

?>
