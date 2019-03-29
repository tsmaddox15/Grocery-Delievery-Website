<?php
session_start();
require('includes/open_db.php');
include('my_functions.php');
 if (!isset($_SESSION["current_user"])){
     $_SESSION['message'] = 'You musted be logged in to access this page';
     header('Location: ./login_files/login_message.php');
 }


//Used to update 
if (isset($_POST['firstName'])){
    updateFirst($db, $_SESSION['current_user'], $_POST['firstName']);
      
      }
if (isset($_POST['lastName'])){
    updateLast($db, $_SESSION['current_user'], $_POST['lastName']);
      
      }
if (isset($_POST['cc'])){
    updateCard($db, $_SESSION['current_user'], $_POST['cc']);
      
      }
if (isset($_POST['address'])){
    updateAddress($db, $_SESSION['current_user'], $_POST['address']);
      
      }
$firstName = getFirst($db, $_SESSION['current_user']);
$lastName = getLast($db, $_SESSION['current_user']);
$creditCard = getCard($db, $_SESSION['current_user']);
$address = getAddress($db, $_SESSION['current_user']);
 
?>

<html>
     <?php
    include ('inc/header.php');
    ?>
    <head>
    </head>
    <body>
        <header>
         
        </header>
        <main>
           <form action="" method="post">
           <label for="firstName" class="profile">First Name</label>
           <input type="text" name="firstName" required="required" value ="<?php echo $firstName ?>"<br />
           <br>
           <label for="lastName" class="profile">Last Name</label>
           <input type="text" name="lastName" required="required" value ="<?php echo $lastName ?>"<br />
           <br/>      
           <label for="password"  class="profile">Credit Card</label>        
          <input type="text"  name="cc"value ="<?php echo $creditCard ?>"<br /><br />
          <label for="password" class="profile">Address</label>       
          <input type="text"  pattern="^\d+\s[A-z]+\s[A-z]+"  required title="Please enter a vaild address"  name="address"value ="<?php echo $address ?>"<br />
          <br/>
          <br/>
          <br/>
          <br/>
          <br/>
          <input type="submit" class="profileSubmit"  value="Update">
           </form>
            <button onclick="window.location.href='customer.php'" class="profileSubmit">Return to Shopping</button> 
        </main>   
    </body>
    <?php
    include ('inc/footer.php');
    ?>
</html>
