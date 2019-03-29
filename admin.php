<?php
// Start the session
session_start();
require('includes/open_db.php');
include('my_functions.php');

 if (!isset($_SESSION["current_user"])){
     $_SESSION['message'] = 'You musted be logged in to access this page';
     header('Location: ./login_files/login_message.php');
 }

$type = getStatus($db, $_SESSION["current_user"]);
//echo $type;
if($type != 'a'){
    $_SESSION['message'] = 'You must be logged as an admin to access the admin page';
    header('Location: ./login_files/login_message.php');
}

if (isset($_POST['itemID'])) {
      $count = 0;
    foreach ($_POST['itemID']as $item) {
       $enterPrice = $_POST['qty'][$count];
       $count++;
       $check = checkCart($db, $_SESSION['current_user'], $item);
       if($enterPrice==''){

       }
        else{
           updatePrice($db, $item, $enterPrice);  
    }
}
}

if (isset($_POST['category'])) {
    $_SESSION['category'] = $_POST['category'];
} else {
    $_SESSION['category'] = 'all';
}

$category = $_SESSION['category'];
$lastOrder = '';
$lastID = '';

$items = getAllItems($db, $category,$lastID);
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
            echo ' <h1> Welcome to the admin page ' . $name . ' !</h1>';
            ?>    
            <?php
            $type = getStatus($db, $_SESSION["current_user"]);
            ?>
          
            <div class="custHeader">
            <button onclick="window.location.href = './login_files/logout.php'">Log Out</button>  
            <button onclick="window.location.href='customer.php'">Return to shopping</button>  
            <button onclick="window.location.href = 'profile.php'">Profile</button>
            <!--<button onclick="window.location.href = 'cart.php'">Review Order</button>-->
               <?php
//                $cost = cartValue($db, $_SESSION['current_user']);
//                echo "<p class=''> " ."Total: ". $cost . "</p>";          
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
                <input type="submit" class="floatRight" value="Update Price">
                <section class="flex_content">    
            <?php
            foreach ($items as $item) {
                echo getItemsAdmin($db, $item);
            }
            ?>
                </section>
            </form>  
        </main>   
        <?php
        // put your code here
        ?>
    </body>
      <?php
    include ('inc/footer.php');
    ?>
</html>
