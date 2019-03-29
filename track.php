<?php
session_start();
require('includes/open_db.php');
include('my_functions.php');
$track = trackOrder($db, $_SESSION['current_user']);
?>
<html lang="en"> 
     <?php
    include ('inc/header.php');
    ?>
<head>          
</head>   
<body> 
    <header>     
        <h1>Your Progress:</h1></header>       ;
    <main> 
        <?php
        //If order is open
        if($track=='o'){
            echo '<p id="no_item_msg">Your order is waiting for a shopper.</p>';
        }
        //else if order is being shopped for
        else if($track=='s'){
            echo '<p id="no_item_msg">Your order is being shopped for right now.</p>';
        }
        //Else if order is being delivered.
        else if($track=='d'){
            echo '<p id="no_item_msg">Your order is being deilvered now.</p>';
        }
        //else if order is closed
        else if($track=='c'){
            echo '<p id="no_item_msg">Your order has been completed.</p>';
        }
        else{
             echo '<p id="no_item_msg">No order to track</p>';
        }
        ?>
         <button onclick="window.location.href='customer.php'" class="profileSubmit">Return to Home Page</button>
    </main>
</body>

   <?php
    include ('inc/footer.php');
    ?>