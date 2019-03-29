<?php
// Start the session
session_start();
require('includes/open_db.php');
include('my_functions.php');

$status = 'o';

//Checks if user is logged in or not
 if (!isset($_SESSION["current_user"])){
     $_SESSION['message'] = 'You musted be logged in to access  the shopper page';
     header('Location: ./login_files/login_message.php');
 }

$type = getStatus($db, $_SESSION["current_user"]);

//Check if user is not an admin or shopper.
if($type == 'c'){
    $_SESSION['message'] = 'You must be logged as an shopper to access the shopper page';
    header('Location: ./login_files/login_message.php');
}

//If order is being added to a shopper to be shopped for.
if (isset($_POST['shop'])){
    updateOrder($db, $_POST['shop'],$status);
    updateShopper($db,$_SESSION['current_user'],$_POST['shop']);
}

$orderIDs = getOrderIDs($db, $_SESSION['current_user'],$status); 
 ?>

<html>
     <?php
    include ('inc/header.php');
    ?>
    <head>
    </head>
    <body>
        <header>
            <h1>Shopper Page</h1>    
        </header>
        <main class="custMain">
            <?php
             if (empty($orderIDs)){
          echo "<p id='no_item_msg'>No orders available for shopping.</p>";
        }
        else{
            foreach ($orderIDs as $anID) {
                $id = $anID['orderID'];
                $name = $anID['firstName'] ." " . $anID['lastName'];
                $address = $anID['address'];
                $orderTotal = $anID['orderTotal'];
                echo "<button class='accordion'>Order ID: $id | Name:$name | Address:$address | Total:$orderTotal</button>";     
                echo '<div class="panel">';
                $details = getOrderDetails($db, $id);
                foreach ($details as $detail) {
                    $itemName = $detail['itemName'];
                    $orderQty = $detail['qty'];
                    $itemPrice = $detail['price'];
                    echo "<p>Item Name: $itemName</p>";  
                     echo "<p>Price: $ $itemPrice</p>";
                    echo "<p>Qty: $orderQty</p>";  
                     echo "____________________________";
                  }          
                 echo  '<form action="" method="post">';
                 echo  "<input type='hidden' name='shop'value ='$id'>";
                 echo   '<input type="submit" class=""  value="Take Order">';  
                 echo ' </form>';
                echo '</div>';
            }
        }
            ?>
                <button onclick="window.location.href='customer.php'">Return to Shopping</button> 
                 <button onclick="window.location.href='shopper_orders.php'">Your Orders</button> 
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