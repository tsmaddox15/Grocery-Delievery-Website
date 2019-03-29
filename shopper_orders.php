<?php
// Start the session
session_start();
require('includes/open_db.php');
include('my_functions.php');

$status = 's';
$status2 = 'd';

 if (!isset($_SESSION["current_user"])){
     $_SESSION['message'] = 'You musted be logged in to access the shopper page';
     header('Location: ./login_files/login_message.php');
 }

$type = getStatus($db, $_SESSION["current_user"]);
if($type == 'c'){
    $_SESSION['message'] = 'You must be logged as an shopper to access the shopper page';
    header('Location: ./login_files/login_message.php');
}

if (isset($_POST['shop'])){
    updateOrder($db, $_POST['shop'],$status);
}
if (isset($_POST['d'])){
    updateOrder($db, $_POST['d'],$status2);
}
//print_r($_POST);


$orderIDs = getShopperIDs($db, $_SESSION['current_user'],$status); 
$orderIDs2 = getShopperIDs($db, $_SESSION['current_user'],$status2);
 ?>

<html>
     <?php
    include ('inc/header.php');
    ?>
    <head>
    </head>
    <body>
        <header>
            <h1>Your Shopping Orders</h1>    
        </header>
        <main class="custMain">
            <?php
             if (empty($orderIDs)){
          echo "<h2 id='no_item_msg'>No orders left that need to be shopped for.</h2>";
        }
        else{
            echo '<h2> Shopping Orders: </h2>';
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
                 echo   '<input type="submit" class=""  value="Finished Shopping">';  
                 echo ' </form>';
                echo '</div>';
            }
        }
        if (empty($orderIDs2)){
          echo "<h2 id='no_item_msg'>No orders left that need to be delivered.</h2>";
        }
        else{
            echo '<h2> Delivery Orders: </h2>';
            foreach ($orderIDs2 as $anID) {
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
                 echo  "<input type='hidden' name='d'value ='$id'>";
                 echo   '<input type="submit" class=""  value="Finished Delivery">';  
                 echo ' </form>';
                echo '</div>';
            }
        }       
            ?>
                <button onclick="window.location.href='shopper.php'">Return to All orders</button> 
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