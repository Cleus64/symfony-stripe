<?php
require_once '../vendor/autoload.php';
require_once '../secrets.php';


session_start();

\Stripe\Stripe::setApiKey($stripeSecretKey);

function calculateOrderAmount(array $items): int {
    
    if (isset($_SESSION['total'])){
        $total= intval($_SESSION['total']);
            
    }
return $total * 100;
}

header('Content-Type: application/json');

try {
    // retrieve JSON from POST body
    $jsonStr = file_get_contents('php://input');
    $jsonObj = json_decode($jsonStr);
    // Create a PaymentIntent with amount and currency
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => calculateOrderAmount($jsonObj->items),
        'currency' => 'eur',
        'payment_method_types' => ['card', 'sepa_debit'],
    ]);

    $output = [
        'clientSecret' => $paymentIntent->client_secret,
    ];

    echo json_encode($output);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}