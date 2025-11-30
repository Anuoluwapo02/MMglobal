<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$host = 'localhost';
$dbname = 'mm_global';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user_id = $_GET['user_id'] ?? null;
    if (!$user_id || !is_numeric($user_id)) {
        echo json_encode(['success' => false, 'error' => 'Add ?user_id=1']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT referral_code FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $row = $stmt->fetch();

    if ($row) {
        echo json_encode(['success' => true, 'referral_code' => $row['referral_code']]);
    } else {
        echo json_encode(['success' => false, 'error' => 'User not in DB']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>