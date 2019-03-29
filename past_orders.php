<?php
// Start the session
session_start();
require('includes/open_db.php');
include('my_functions.php');

$status = 'o';
//Checks if user is logged in or not
 if (!isset($_SESSION["current_user"])){
     $_SESSION['message'] = 'You musted be logged in to access this page';
     header('Location: ./login_files/login_message.php');
 }

$type = getStatus($db, $_SESSION["current_user"]);

//If order is being added to a shopper to be shopped for.
if (isset($_POST['shop'])){
    updateOrder($db, $_POST['shop'],$status);
    updateShopper($db,$_SESSION['current_user'],$_POST['shop']);
}

$orderIDs = pastOrders($db, $_SESSION['current_user']); 
 ?>
<html>
    <head>
        <title> Grocery delivery </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="images/favicon.ico">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <!--<script src="scripts/main.js"></script>-->
    </head>
    <body>
        <header>
            <h1>Past Orders</h1>    
        </header>
        <main class="custMain">
            <?php
             if (empty($orderIDs)){
          echo "<p id='no_item_msg'>You have no past order.</p>";
        }
        else{
            foreach ($orderIDs as $anID) {
                $id = $anID['orderID'];     
                $name = $anID['firstName'] ." " . $anID['lastName'];
                $address = $anID['address'];
                $orderTotal = $anID['orderTotal'];
                echo "<button class='accordion'>Order ID: $id | Address:$address | Total:$orderTotal</button>";     
                echo '<div class="panel">';
                $details = getOrderDetails($db, $id);
                foreach ($details as $detail) {
//                    print_r($detail);
                    $itemName = $detail['itemName'];
                    $orderQty = $detail['qty'];
                    $itemPrice = $detail['price'];
                    echo "<p>Item Name: $itemName</p>";  
                    echo "<p>Price: $ $itemPrice</p>";
                    echo "<p>Qty: $orderQty</p>";  
                    echo "____________________________";
                  }          
                echo '</div>';
            }
        }
            ?>
                <button onclick="window.location.href='customer.php'">Return to Shopping</button>      
                   <script>
                var acc = document.getElementsByClassName("accordion");
                var i;
                for (i = 0; i < acc.length; i++) {
                    acc[i].addEventListener("click", function () {
                        this.classList.toggle("active");
                        var panel = this.nextElementSibling;
                        if (panel.style.display === "block") {
                            panel.style.display = "none";
                        } else {
                            panel.style.display = "block";
                        }
                    });
                }
            </script>
        </main>   
    </body>
     <?php
    include ('inc/footer.php');
    ?>
</html>