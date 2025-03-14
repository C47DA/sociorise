<?php
if (!defined('ADDFUNDS')) {
    http_response_code(404);
    die();
}

$apiKey = $methodExtras["apiKey"];
$secretKey = $methodExtras["secretKey"];
$orderId = md5(RAND_STRING(5) . time());
$callbackURL = site_url("payment/" . $methodCallback);

$insert = $conn->prepare(
    "INSERT INTO payments SET
client_id=:client_id,
payment_amount=:amount,
payment_method=:method,
payment_mode=:mode,
payment_create_date=:date,
payment_ip=:ip,
payment_extra=:extra"
);

$insert->execute([
    "client_id" => $user["client_id"],
    "amount" => $paymentAmount,
    "method" => $methodId,
    "mode" => "Automatic",
    "date" => date("Y.m.d H:i:s"),
    "ip" => GetIP(),
    "extra" => $orderId
]);

// Prepare data for Cryptomous API
$postData = [
    'order_id' => $orderId,
    'amount' => $paymentAmount,
    'currency' => 'USD', // or your preferred currency
    'callback_url' => $callbackURL,
    'cancel_url' => site_url(""),
    'success_url' => $callbackURL,
    'customer_email' => $user["email"],
    'customer_name' => $user["name"] ?: "User",
    'description' => "Balance Recharge (" . $user["username"] . ")"
];

// Generate signature
$signature = hash_hmac('sha256', json_encode($postData), $secretKey);

// API Headers
$headers = [
    'Content-Type: application/json',
    'X-Api-Key: ' . $apiKey,
    'X-Signature: ' . $signature
];

// Make API request to Cryptomous
$ch = curl_init('https://api.cryptomous.com/v1/checkout/create'); // Replace with actual Cryptomous API endpoint
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$gatewayResponse = curl_exec($ch);
curl_close($ch);

$responseData = json_decode($gatewayResponse, true);

if (isset($responseData['checkout_url'])) {
    $redirectForm .= '<script type="text/javascript">
        window.location.href = "' . $responseData['checkout_url'] . '";
    </script>';

    $response["success"] = true;
    $response["message"] = "Your payment has been initiated and you will now be redirected to the payment gateway.";
    $response["content"] = $redirectForm;
} else {
    $response["success"] = false;
    $response["message"] = "Payment initialization failed. Please try again.";
} 