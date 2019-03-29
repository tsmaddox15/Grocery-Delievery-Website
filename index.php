<?php
session_start();

$_SESSION['category'] = 'all';

?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php
    include ('inc/header.php');
    ?>
    <head>
   
    </head>
    <body>
        <header>
            <h1>Taylor's Grocery Delivery</h1>
            <button value="Continue Shopping" onclick="window.location.href='./login_files/login_start.php'"> Log in/Sign up</a> </button>
        </header>
        <main class="indexMain">
            <img src="img/cover.png">
        </main>   
        <?php
        // put your code here
        ?>
    </body>
       <?php
    include ('inc/footer.php');
    ?>
</html>
