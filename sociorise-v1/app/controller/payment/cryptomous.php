<?php
if (!defined('PAYMENT')) {
    http_response_code(404);
    die();
}

$secretKey = $methodExtras["secretKey"];
$payload = file_get_contents("php://input");
$signature = $_SERVER["HTTP_X_SIGNATURE"] ?? '';

// Verify signature
$calculatedSignature = hash_hmac('sha256', $payload, $secretKey);
if (!hash_equals($calculatedSignature, $signature)) {
    errorExit("Invalid signature");
}

$data = json_decode($payload, true);
$orderId = $data['order_id'] ?? '';

if (empty($orderId)) {
    errorExit("Missing order ID");
}

$paymentDetails = $conn->prepare("SELECT * FROM payments WHERE payment_extra=:orderId");
$paymentDetails->execute([
    "orderId" => $orderId
]);

if ($paymentDetails->rowCount()) {
    $paymentDetails = $paymentDetails->fetch(PDO::FETCH_ASSOC);

    if (!countRow([
        'table' => 'payments',
        'where' => [
            'client_id' => $user['client_id'],
            'payment_method' => $methodId,
            'payment_status' => 3,
            'payment_delivery' => 2,
            'payment_extra' => $orderId
        ]
    ])) {
        // Verify payment status
        if ($data['status'] === 'completed') {
            $paidAmount = floatval($paymentDetails["payment_amount"]);

            if ($paymentFee > 0) {
                $fee = ($paidAmount * ($paymentFee / 100));
                $paidAmount -= $fee;
            }

            if ($paymentBonusStartAmount != 0 && $paidAmount > $paymentBonusStartAmount) {
                $bonus = $paidAmount * ($paymentBonus / 100);
                $paidAmount += $bonus;
            }

            $update = $conn->prepare('UPDATE payments SET 
                client_balance=:balance,
                payment_status=:status, 
                payment_delivery=:delivery 
                WHERE payment_id=:id');
            
            $update->execute([
                'balance' => $paidAmount,
                'status' => 3,
                'delivery' => 2,
                'id' => $paymentDetails['payment_id']
            ]);

            $balance = $conn->prepare('UPDATE clients SET balance=:balance WHERE client_id=:id');
            $balance->execute([
                'balance' => $user['balance'] + $paidAmount,
                'id' => $user['client_id']
            ]);

            header("Location: " . site_url('addfunds'));
            exit();
        }
    }
}

// Return 200 OK to acknowledge receipt
http_response_code(200);
echo "OK"; 