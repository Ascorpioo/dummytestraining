<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once('vendor/autoload.php');

    $phone = $_POST['phone'];
    $amount = $_POST['amount'];
    $country = $_POST['country'];
    $currency = $_POST['currency'];
    $transactionRef = $_POST['transactionRef'];

    $client = new \GuzzleHttp\Client();

    try {
        // Get token (assuming you need a token first, if not, you can skip this part)
        $tokenResponse = $client->request('GET', 'https://api.eversend.co/v1/auth/token', [
            'headers' => [
                'clientId' => 'jc5xiu_3nmx8Wh4QoNVH9WZ8Lw-xs5Cq',  // Replace with your actual clientId
                'clientSecret' => 'HwWm8eCj30vENmeJXOxtLehfvR9R3x5qk0NV7lsjEqCfHueU3CdJ_zBBd8skXYGe'  // Replace with your actual clientSecret
            ],
        ]);
        
        $tokenData = json_decode($tokenResponse->getBody(), true);
        $token = $tokenData['token']; // Adjust this line based on the actual token structure

        // Make the payment request
        $response = $client->request('POST', 'https://api.eversend.co/v1/collections/momo', [
            'body' => json_encode([
                'phone' => $phone,
                'amount' => $amount,
                'country' => $country,
                'currency' => $currency,
                'transactionRef' => $transactionRef,
                'redirectUrl' => 'https://eversend.co'
            ]),
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'Authorization' => "Bearer $token" // Assuming the token needs to be passed this way
            ],
        ]);

        echo $response->getBody();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Invalid request method.';
}
?>
