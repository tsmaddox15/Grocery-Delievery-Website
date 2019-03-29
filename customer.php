<?php
// Start the session
session_start();
require('includes/open_db.php');
include('my_functions.php');

if (!isset($_SESSION["current_user"])) {
    $_SESSION['message'] = 'You musted be logged in to access this page';
    header('Location: ./login_files/login_message.php');
}

if (isset($_POST['category'])) {
    $_SESSION['category'] = $_POST['category'];
} else {
    $_SESSION['category'] = 'all';
}

//determins category and returns the view the user wants.
$category = $_SESSION['category'];

//Gets the last order to get the recent orders.
$lastOrder = '';
$lastID = '';
if($category=='recent'){
$lastOrder = getOrder($db, $_SESSION['current_user']);
$lastID = $lastOrder['orderID'];

}

//Used to later display all the items
$items = getAllItems($db, $category,$lastID);


//What type of user is logged in
$type = getStatus($db, $_SESSION["current_user"]);

//Used to add items to cart.
if (isset($_POST['itemID'])) {
      $count = 0; 
    foreach ($_POST['itemID']as $item) {
       
       $enterQty = $_POST['qty'][$count];
       $count++; 
       $check = checkCart($db, $_SESSION['current_user'], $item);
         $id = $check['itemID'];
        $qty = $check['qty'];
      
       //Do nothing for items that don't have any qty to work with
       if($enterQty==''){

       }
       //Used if an item is already in cart and needs updated.
        else if (!empty($check)){ 
         updateQty($db, $_SESSION['current_user'], $id, $qty,$enterQty);
          checkQty($db, $item, $qty, $_SESSION['current_user']);
        }
        //Adds an item if its a new item
        else{
        addCart($db, $_SESSION['current_user'], $item,$enterQty);
        }
        //Checks for any items that need to be removed from the cart
        checkQty($db);
    }
        header( "Location:./redirect.php" );
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
  
            <?php
            $email = $_SESSION['current_user'];
            $name = getName($db, $email);
            echo ' <h1> Welcome ' . $name . ' !</h1>';
            ?>    
            <div class="custHeader">
            <button onclick="window.location.href = './login_files/logout.php'">Log Out</button> 
            <?php 
            if($type == 'a'){
                echo '<form action="admin.php" class="floatRight"> <input type="submit" value="Admin Page"> </form>';
                 }
             if($type == 'a' || $type =='s'){
                echo '<form action="shopper.php" class="floatRight"> <input type="submit" value="Shopper Page"> </form>';
                echo '<br/>';
                 }
             
            ?>   
            <br/>
            <br/>
            <button onclick="window.location.href = 'past_orders.php'">Past Orders</button>  
            <button onclick="window.location.href = 'track.php'">Track Order</button>  
            <button onclick="window.location.href = 'profile.php'">Profile</button>
            <button onclick="window.location.href = 'cart.php'">Review Order</button>
    
         </div>
            <div class="custHeader2">
               <?php
                $cost = cartValue($db, $_SESSION['current_user']);
                echo "<p class=''> " ."Total: ". $cost . "</p>";          
                ?>
                
            </div>
            
        </header>
        <main>    
            <aside>
            <button class="accordion">Categories</button>
            <div class="panel">
                <!--All-->
                <form action="" method="post">
                    <input type="hidden"  name='category'value ="<?php echo 'all' ?>">
                    <input type="submit" class="accordInput" value="All">
                </form>
                
                <!--Recent-->
                <form action="" method="post">
                    <input type="hidden"  name='category'value ="<?php echo 'recent' ?>">
                    <input type="submit" class="accordInput" value="Recent">
                </form>


                <!--Beverages-->
                <form action="" method="post">   
                    <input type="hidden" name='category'value ="<?php echo 'beverage' ?>">
                    <input type="submit" class="accordInput" value="Beverages">                 
                </form>

                <!--Snacks-->
                <form action="" method="post">   
                    <input type="hidden" name='category'value ="<?php echo 'snack' ?>">
                    <input type="submit" class="accordInput" value="Snack">  

                </form>

                <!--Deli-->
                <form action="" method="post">   
                    <input type="hidden" name='category'value ="<?php echo 'deli' ?>">
                    <input type="submit" class="accordInput" value="Deli">  

                </form>

                <!--Diary and egg-->
                <form action="" method="post">   
                    <input type="hidden" name='category'value ="<?php echo 'd&e' ?>">
                    <input type="submit" class="accordInput"  value="D&e">  
                </form>    
            </div>
            
            </aside>

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
            <form action="" method="post">       
                <input type="submit" class="floatRight" value="Add to cart">
                <section class="flex_content">    
            <?php
            //Displays the items
            foreach ($items as $item) {
                echo getItems($db, $item);
            }
            ?>
                </section>
            </form>     
        </main>   
    </body>
     <?php
    include ('inc/footer.php');
    ?>
</html>
