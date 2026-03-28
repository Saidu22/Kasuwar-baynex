 <?php
session_start();

if(isset($_GET['action']) && isset($_GET['id'])){

    $id = $_GET['id'];

    if($_GET['action'] == "increase"){
        $_SESSION['cart'][$id]['quantity']++;
    }

    if($_GET['action'] == "decrease"){
        if($_SESSION['cart'][$id]['quantity'] > 1){
            $_SESSION['cart'][$id]['quantity']--;
        }
    }

    if($_GET['action'] == "remove"){
        unset($_SESSION['cart'][$id]);
    }
}

header("Location: cart.php");
exit();
?>