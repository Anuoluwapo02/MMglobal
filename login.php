<?php
session_start();
include 'config.php'; // <-- Your DB connection (mysqli)

// Only process POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $phone    = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT id, phone, password, referral_code FROM users WHERE phone = '$phone'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Plain text password (as in your system)
        if ($user['password'] === $password) {

            // === SUCCESS: Save to Session ===
            $_SESSION['user_id']        = $user['id'];
            $_SESSION['phone']          = $user['phone'];
            $_SESSION['referral_code']  = $user['referral_code'];

            // === Pass user_id to JavaScript (localStorage) ===
            $user_id = $user['id'];

            // === Redirect to share.html with JS (auto-loads referral) ===
            echo "<!DOCTYPE html>
            <html><head><title>Logging in...</title></head><body>
            <script>
                localStorage.setItem('user_id', '$user_id');
                window.location.href = 'dashboard.html';  // Opens share page
            </script>
            </body></html>";
            exit();

        } else {
            echo "<script>alert('Incorrect password.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('No account found.'); window.history.back();</script>";
    }

    $conn->close();
} else {
    // Not POST → go to login form
    header("Location: login.html");
    exit();
}
?>