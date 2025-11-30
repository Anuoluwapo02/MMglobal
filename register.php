<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);
    $referral = mysqli_real_escape_string($conn, $_POST['referral']);

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit();
    }

    // Check if phone number already exists
    $check = "SELECT * FROM users WHERE phone='$phone'";
    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        echo "<script>alert('Phone number already registered!'); window.history.back();</script>";
        exit();
    }

    // ✅ Generate a unique referral code
    $my_referral_code = substr(md5(uniqid($phone, true)), 0, 8);

    // ✅ Check if referral code entered exists
    $referred_by = NULL;
    if (!empty($referral)) {
        $check_ref = "SELECT referral_code FROM users WHERE referral_code='$referral'";
        $ref_result = $conn->query($check_ref);
        if ($ref_result->num_rows > 0) {
            $referred_by = $referral;
        }
    }

    // ✅ Insert new user with generated code
    $sql = "INSERT INTO users (phone, password, referral_code, referred_by)
            VALUES ('$phone', '$password', '$my_referral_code', '$referred_by')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration successful! Your referral code is: $my_referral_code'); window.location.href='login.html';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
