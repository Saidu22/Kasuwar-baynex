<?php
session_start();
include "../config/database.php";

if(!isset($_SESSION['user_id'])){
header("Location: ../auth/login.php");
exit();
}

$user_id = $_SESSION['user_id'];

/* Calculate total */
$result = $conn->query("
SELECT cart.*, products.price
FROM cart
JOIN products ON cart.product_id = products.id
WHERE cart.user_id='$user_id'
");

$total = 0;

while($row = $result->fetch_assoc()){
$total += $row['price'] * $row['quantity'];
}

/* Convert to kobo */
$amount = $total * 100;
?>

<!DOCTYPE html>

<html>

<head>

<title>Checkout</title>

<script src="https://js.paystack.co/v1/inline.js"></script>

</head>

<body>

<h2>Checkout</h2>

<h3>Total: ₦<?php echo number_format($total); ?></h3>

<button onclick="payWithPaystack()">Pay Now</button>

<script>
function payWithPaystack(){
var handler = PaystackPop.setup({
key: "pk_test_afc44d2039fd36fe413aa0fd8ed91586021e183e",
email: "kasuwarbaynex@gmail.com",
amount: <?php echo $amount; ?>,
currency: "NGN",

callback: function(response){
window.location.href = "verify_payment.php?reference=" + response.reference;
},

onClose: function(){
alert("Payment cancelled");
}
});
handler.openIframe();
}
</script>

</body>

</html>
