<?php
session_start();
include "../config/database.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Get total from cart */

$result = $conn->query("
SELECT SUM(products.price * cart.quantity) AS total
FROM cart
JOIN products ON cart.product_id = products.id
WHERE cart.user_id='$user_id'
");

$row = $result->fetch_assoc();
$total = $row['total'];

if(!$total){
    die("Cart is empty");
}

$email = "customer@test.com"; // You can replace later

$amount = $total * 100; // Paystack uses kobo

$callback_url = "http://localhost/projects/kasuwar-baynex/checkout/verify_payment.php";



/* Initialize payment */

$curl = curl_init();

curl_setopt_array($curl, array(
CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_POST => true,
CURLOPT_POSTFIELDS => json_encode([
    "email" => $email,
    "amount" => $amount,
    "callback_url" => $callback_url
]),
CURLOPT_HTTPHEADER => [
    "Authorization: Bearer $secret_key",
    "Content-Type: application/json"
],
));

$response = curl_exec($curl);

if(curl_errno($curl)){
echo "cURL Error: " . curl_error($curl);
exit();
}

curl_close($curl);

$result = json_decode($response, true);

/* DEBUG OUTPUT */

if(!$result){
echo "Invalid response from Paystack";
echo "<pre>";
print_r($response);
echo "</pre>";
exit();
}

if($result['status']){

header("Location: ".$result['data']['authorization_url']);
exit();

} else {

echo "<h3>Payment initialization failed</h3>";

echo "<pre>";
print_r($result);
echo "</pre>";

}

?>
