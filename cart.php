<?php
session_start();
require('includes/open_db.php');
include('my_functions.php');
//print_r($_POST);

if (isset($_POST['itemID'])) {
    //Remoevs one qty or item if qty is one when removed
    $getQty = getQty($db, $_POST['itemID'],$_SESSION['current_user']);
    removeQty($db, $_POST['itemID'], $getQty, $_SESSION['current_user']);
} 
?>

<html>
     <?php
    include ('inc/header.php');
    ?>
    <head>
    </head>
    <body>
        <header>
            <h1>Your Cart:</h1>
        </header>
        <main>
        <?php
         $cart = getCart($db, $_SESSION['current_user']);
         if (empty($cart)){
          echo "<p id='no_item_msg'>No items in cart.</p>";
        }
        else{
      echo "<table id='customers'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Item</th><th>Qty</th><th>Price</th><th>Remove 1</th>";
            echo "</tr>"; 
            echo "</thead>";
            echo "<tbody>";
         
      foreach ($cart as $cartItem) { 
            
          //Cart Table
              $itemName = $cartItem['itemName'];
              $qty = $cartItem['qty'];
              $id = $cartItem['itemID'];
              $price = $cartItem['price'];
              echo "<tr>";
              echo "<td>$itemName</td><td>$qty</td><td>$price</td>";
              echo '';
              echo ' <form action="" method="post">';
              echo  "<input type='hidden' id={$cartItem['itemID']} name='itemID' value={$id}>";
              echo  "<td><input type='submit' id={$cartItem['itemID']} class='accordInput'value='-1'></td>  ";
              echo '  </form>';
              ?>
              </tr>
            <?php
            }   
               $cost = cartValue($db, $_SESSION['current_user']);
            echo  "<td> Total Cost: $cost</td>";
            echo "</tbody>";     
            echo "</table>";

            }
        ?>
        <button onclick="window.location.href='customer.php'">Return to Shopping</button> 
        <?php
        if(!empty($cart)){
               echo '<form action="checkout.php" class="floatRight"> <input type="submit" value="Proceed to Checkout"> </form>';
        }
        ?>
        <!--<button onclick="window.location.href='checkout.php'">Proceed to Checkout</button>--> 
        </main>   
    </body>
       <?php
    include ('inc/footer.php');
    ?>
</html>
