<?php
// Database connection details
$db_host = 'localhost';
$db_name = 'socioris_idk1';
$db_user = 'socioris_idk1';
$db_pass = 'socioris_idk1';

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if Cryptomous already exists
    $check = $conn->prepare("SELECT * FROM paymentmethods WHERE methodId = 19 OR methodName = 'Cryptomous'");
    $check->execute();
    
    if ($check->rowCount() > 0) {
        echo "Cryptomous payment method already exists!";
    } else {
        // Insert Cryptomous payment method
        $insert = $conn->prepare("INSERT INTO `paymentmethods` 
          (`methodId`, `methodName`, `methodLogo`, `methodVisibleName`, `methodCallback`, `methodMin`, `methodMax`, `methodFee`, `methodBonusPercentage`, `methodBonusStartAmount`, `methodCurrency`, `methodStatus`, `methodExtras`, `methodPosition`, `methodInstructions`) 
          VALUES 
          (19, 'Cryptomous', 'https://i.postimg.cc/Kz1Bf0Hm/cryptomous-logo.png', 'Cryptomous', 'cryptomous', 1, 10000, 0, 0, 0, 'USD', '1', '{\"apiKey\":\"\",\"secretKey\":\"\"}', 19, '')");
        
        $result = $insert->execute();
        
        if ($result) {
            echo "Cryptomous payment method added successfully!";
        } else {
            echo "Failed to add Cryptomous payment method.";
        }
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?> 