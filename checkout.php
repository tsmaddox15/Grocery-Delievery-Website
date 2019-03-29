<?php
session_start();
require('includes/open_db.php');
include('my_functions.php');

 if (!isset($_SESSION["current_user"])){
     $_SESSION['message'] = 'You musted be logged in to access this page';
     header('Location: ./login_files/login_message.php');
 }

//If order is placed
if (isset($_POST['order'])) {
    //Create a new order
    $total = cartValue($db, $_SESSION['current_user']);
    addOrder($db, $_SESSION['current_user'],$total);
    //Details of order
    $details = getDtails($db, $_SESSION['current_user']);
    //Get the newly made order
    $order = getOrder($db, $_SESSION['current_user']);
    //OrderID of the order
    $orderID= $order['orderID'];
    //Insert details for the order
    foreach ($details as $detail) {
        $itemID = $detail['itemID'];
        $qty= $detail['qty'];
        addDetails($db, $orderID,$itemID,$qty);    
}
//Clear the cart and go to the tracking page
clearCart($db, $_SESSION['current_user']);
 header( "Location:./track.php" );
}

$creditCard = getCard($db, $_SESSION['current_user']);
$address = getAddress($db, $_SESSION['current_user']);
?>

<!DOCTYPE html>
<html lang="en"> 
     <?php
    include ('inc/header.php');
    ?>
<head>         
</head>     
<body> 
    <header>       <h1>Placeholder</h1>    </header>       
    <main> 
        <form action="" method="post">
           <label for="password" class="profile">Credit Card</label>        
           <input type="text" pattern=".{16}" required="required" required title="16 digit credit card" name="cc"value ="<?php echo $creditCard ?>"<br /><br />
          <label for="password" class="profile">Address</label>       
          <input type="text" name="address"value ="<?php echo $address ?>"<br /> 
            
        </form>
      <form action="" method="post">   
       <input type="hidden" name='order'value ="<?php echo 'order' ?>">
       <input type="submit" class="profileSubmit" value="Place Order">    
      </form>
      <button onclick="window.location.href='cart.php'" class="profileSubmit">Return to Review</button>
    </main>        
       <?php
    include ('inc/footer.php');
    ?>  
</body> 
</html> 