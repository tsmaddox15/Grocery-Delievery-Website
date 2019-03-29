<?php

//Returns first and last from customer table based on username.
function getName($db, $user){
      $query = "SELECT firstName, lastName FROM `customer` WHERE email = '$user'";
      $statement = $db->prepare($query);
      $statement->execute();
      $name = $statement->fetch();
      $statement->closeCursor();
      $stringName = $name[0] . "  ".$name[1];
      return $stringName;
    }
 
//Returns items based on what category the user wants.
function getAllItems($db, $category,$order) { 
  if($category=='all'){   
  
  $query = 'SELECT * FROM items';
  }
  else if($category=='recent'){
       $query = "Select * FROM items INNER JOIN orderdetails ON items.itemID = orderdetails.itemID INNER JOIN orders on orderdetails.orderID = orders.orderID WHERE orders.orderID ='$order'";
  }
  else {
       $query = "SELECT * FROM items WHERE category='$category' "; 
  }
  $statement = $db->prepare($query);
  $statement->execute();
  $itmes = $statement->fetchAll(PDO::FETCH_ASSOC);
  $statement->closeCursor();
  return $itmes;
}


 
//Displays images and prices for items.
function getItems($db, $item) {
    $moneysign = '$';
  $image_file = "img/items/".$item['itemID'].".png";
  $html_out = <<<EOD
    <figure>
      <img src="{$image_file}" style="width:260px;height:180px;"">
      <figcaption><span class='item_name'>{$item['itemName']}</span><br />
       Price: $moneysign{$item['price']}<br/> 
       <input type="number" id={$item['price']} name="qty[]" value=''}>
      <input type="hidden" id={$item['itemID']} name="itemID[]" value={$item['itemID']}>
      
      </figcaption>  
    </figure>
EOD;
            
    return $html_out;
 
 }
 function getItemsAdmin($db, $item) {
   $moneysign = '$';
  $image_file = "img/items/".$item['itemID'].".png";
  $html_out = <<<EOD
    <figure>
      <img src="{$image_file}" style="width:260px;height:180px;"">
      <figcaption><span class='item_name'>{$item['itemName']}</span><br />
      Price:  $moneysign{$item['price']}<br/> 
       <input type="number" id={$item['price']} step="0.01" name="qty[]" value=''}>
      <input type="hidden" id={$item['itemID']} name="itemID[]" value={$item['itemID']}>
      
      </figcaption>  
    </figure>
EOD;
            
    return $html_out;
 
 }
 
//function getItems($db, $item) {
//  $image_file = "img/items/".$item['itemID'].".png";
//  $html_out = <<<EOD
//    <figure>
//      <img src="{$image_file}" style="width:260px;height:180px;"">
//      <figcaption><span class='item_name'>{$item['itemName']}</span><br />
//      price {$item['price']}<br/> 
//      <input type="checkbox" id={$item['itemID']} name="itemID[]" value={$item['itemID']}>
//      <label for={$item['itemID']}>Add to cart</label>
//      </figcaption>  
//    </figure>
//EOD;
//            
//    return $html_out;
// 
// }
// 


 
function checkCart($db, $currentUser, $item) {
    $query = "SELECT itemID,qty from shoppinglist where itemID='$item' AND email='$currentUser'";
    $statement = $db->prepare($query);
    $statement->execute();
    $item = $statement->fetch();
    $statement->closeCursor();
    return $item;
} 

function checkQty($db){
//     echo "qty is: ".$qty; 
//      if($qty <= 0 ){
//          echo 'in if';
//      $query = "DELETE FROM shoppinglist WHERE itemID ='$itemID' AND email='$user'";
      $query = "DELETE FROM `shoppinglist` WHERE qty<=0";
      $statement = $db->prepare($query);
      $statement->execute();
      $statement->closeCursor(); 
//      }
       
    }

 
//Adds an item to the cart.
function addCart($db, $currentUser, $item, $qty) {
    if($qty <= 0){
        
    }
    else{
    $query = "INSERT INTO shoppinglist(email, itemID, qty) VALUES('$currentUser', '$item', '$qty')";
    $statement = $db->prepare($query);
    $statement->execute();
    $statement->closeCursor();
    }
}

//Returns the value that is in the cart.
function cartValue($db, $user){
      $query = "SELECT price, shoppinglist.qty FROM items INNER JOIN shoppinglist ON items.itemID = shoppinglist.itemID WHERE shoppinglist.email = '$user'";
      $statement = $db->prepare($query);
      $statement->execute();
      $costs= $statement->fetchAll(PDO::FETCH_ASSOC);;
      $statement->closeCursor();
      $total = 0.00;
      if(!empty($costs )){
      foreach ($costs as $cost){
//          echo $cost['price'];
          $total += $cost['price'] *$cost['qty'];
      }
      }
      return number_format((float)$total, 2, '.', '');;
    }

//Returns only first name
function getFirst($db, $user){
      $query = "SELECT firstName FROM customer WHERE email='$user'";
      $statement = $db->prepare($query);
      $statement->execute();
      $firstName= $statement->fetch();
      $statement->closeCursor();
      $stringName = $firstName[0];
      
      return $stringName;
    }
//Returns only the last name
function getLast($db, $user){
      $query = "SELECT lastName FROM customer WHERE email='$user'";
      $statement = $db->prepare($query); 
      $statement->execute();
      $lastName= $statement->fetch();
      $statement->closeCursor();
      $stringName = $lastName[0];
      
      return $stringName;
    }
    
//Returns users credit card.
function getCard($db, $user){
      $query = "SELECT creditCard FROM customer WHERE email='$user'";
      $statement = $db->prepare($query);
      $statement->execute();
      $firstName= $statement->fetch();
      $statement->closeCursor();
      $stringName = $firstName[0];
      
      return $stringName;
    }

//Returns the address of current user
function getAddress($db, $user){
      $query = "SELECT address FROM customer WHERE email='$user'";
      $statement = $db->prepare($query);
      $statement->execute();
      $firstName= $statement->fetch();
      $statement->closeCursor();
      $stringName = $firstName[0];
      
      return $stringName;
    }
    
//Updates the user's address
function updateAddress($db, $user,$address){
      $query = "Update customer SET address='$address' WHERE email='$user'";
      $statement = $db->prepare($query);
      $statement->execute();
      $statement->closeCursor();  
    }
    
//Updaates the users first name
function updateFirst($db, $user,$newFirst){
      $query = "Update customer SET firstName='$newFirst' WHERE email='$user'";
      $statement = $db->prepare($query);
      $statement->execute();
      $statement->closeCursor();  
    }
//Updates the users last name.
function updateLast($db, $user,$newLast){
      $query = "Update customer SET lastName='$newLast' WHERE email='$user'";
      $statement = $db->prepare($query);
      $statement->execute();
      $statement->closeCursor();  
    }
//updates the users credit card
function updateCard($db, $user,$newCard){
      $query = "Update customer SET creditCard='$newCard' WHERE email='$user'";
      $statement = $db->prepare($query);
      $statement->execute();
      $statement->closeCursor();  
    }

//Used to update that a shopper has taken an order.
function updateShopper($db, $user,$orderID){
      $query = "Update orders SET shopper='$user' WHERE orderID='$orderID'";
      $statement = $db->prepare($query);
      $statement->execute();
      $statement->closeCursor();  
    }

//Updates the status of the order based on what phase it is in
function updateOrder($db, $orderID,$status){
    //If order is open to a shopper.
    if($status=='o'){
      $query = "Update orders SET status='s' WHERE orderID='$orderID'";

    }
    //If order is being shopped for
    else if($status=='s'){
        $query = "Update orders SET status='d' WHERE orderID='$orderID'"; 
    }
    //If order is being delivered 
     else if($status=='d'){
        $query = "Update orders SET status='c' WHERE orderID='$orderID'"; 
    }
      $statement = $db->prepare($query);
      $statement->execute();
      $statement->closeCursor();  
}
    
//Updates qty of the cart 
function updateQty($db, $user,$itemID,$qty,$plus){
      $query = "Update shoppinglist SET qty='$qty'+$plus  WHERE itemID='$itemID' AND email='$user'";
      $statement = $db->prepare($query);
      $statement->execute();
      $statement->closeCursor();  
    }  

function updatePrice($db, $item,$price){
      $query = "Update items SET price='$price' WHERE itemID='$item'";
      $statement = $db->prepare($query);
      $statement->execute();
      $statement->closeCursor();  
    }    
       
//returns the users credit card.
function getCart($db, $user){
      $query = "SELECT items.itemName, shoppinglist.qty, items.itemID, items.price FROM shoppinglist INNER JOIN items ON shoppinglist.itemID = items.itemID WHERE shoppinglist.email = '$user'";
      $statement = $db->prepare($query);
      $statement->execute();
      $cart= $statement->fetchAll(PDO::FETCH_ASSOC);
      $statement->closeCursor();
      
      return $cart;
    }
    
//Returns the type of user.
function getStatus($db, $user){
      $query = "SELECT userType FROM users WHERE username='$user'";
      $statement = $db->prepare($query);
      $statement->execute();
      $type= $statement->fetch();
      $statement->closeCursor();
      $stringName = $type[0]; 
      return $stringName;
    }
    
//Returns the qry from shopping list for a single item.
function getQty($db, $itemID,$user) {
    $query = "SELECT qty FROM shoppinglist WHERE itemID='$itemID'  AND email='$user'";
    $statement = $db->prepare($query);
    $statement->execute();
    $qtyArr = $statement->fetch();
    $statement->closeCursor();  
    $qty = $qtyArr[0];
    return $qty;
}       


//Removes one from the qty
function removeQty($db, $itemID,$qty,$user){
      if($qty == 1 ){
      $query = "DELETE FROM shoppinglist WHERE itemID ='$itemID' AND email='$user'";
      }
      else{
            echo '<br/>';
      $query = "Update shoppinglist SET qty='$qty'-1 WHERE itemID ='$itemID' AND email='$user'";
      }
      $statement = $db->prepare($query);
      $statement->execute();
      $statement->closeCursor();  
    }   
 
//Creates a new new order
function addOrder($db, $user,$total){
      $query ="INSERT INTO orders(email,orderTotal) VALUES ('$user', $total)";
      $statement = $db->prepare($query);
      $statement->execute();
      $firstName= $statement->fetch();
      $statement->closeCursor();
    }

//Clears the users cart.
function clearCart($db, $user){
      $query = "DELETE FROM shoppinglist WHERE email='$user'";
      $statement = $db->prepare($query);
      $statement->execute();
      $firstName= $statement->fetch();
      $statement->closeCursor();
      $stringName = $firstName[0];
      
      return $stringName;
    }    

//Gets the details of the user's order.
function  getDtails($db,$user){
  $query = "Select itemID,qty FROM shoppinglist WHERE email='$user'";
  $statement = $db->prepare($query);
  $statement->execute();
  $itmes = $statement->fetchAll(PDO::FETCH_ASSOC);
  $statement->closeCursor();
  return $itmes;
}

//Selects most recent order.
function  getOrder($db,$user){
  $query = "Select orderID FROM orders WHERE email='$user' ORDER  BY orderID DESC LIMIT 1";
  $statement = $db->prepare($query);
  $statement->execute();
  $order = $statement->fetch();
  $statement->closeCursor();
  return $order;
}

//Tracks the progress of the order.
function  trackOrder($db,$user){
  $query = "Select status FROM orders WHERE email='$user' ORDER  BY orderID DESC LIMIT 1";
  $statement = $db->prepare($query);
  $statement->execute();
  $order = $statement->fetch();
  $statement->closeCursor();
  $status = $order[0];
  return $status;
}

//Gets all curent orders waiting for a shopper
function  allOrders($db,$user){
  $query = "SELECT orders.orderID, orderdetails.itemID, orderdetails.qty  FROM orders INNER JOIN orderdetails ON orders.orderID = orderdetails.orderID WHERE orders.status = 'o'";
  $statement = $db->prepare($query);
  $statement->execute();
  $order =  $statement->fetchAll(PDO::FETCH_ASSOC);
  $statement->closeCursor();
  return $order;
}

//Gets the order detials when no shopper has picked up the order.
function  getOrderIDs($db,$user,$status){
//  $query = "SELECT orderID FROM orders WHERE orders.status = 'o'";
  $query= "SELECT orders.orderID, orders.orderTotal,customer.firstName, customer.lastName, customer.address FROM orders INNER JOIN customer ON orders.email = customer.email WHERE orders.status = '$status'";
  $statement = $db->prepare($query);
  $statement->execute();
  $order = $statement->fetchAll(PDO::FETCH_ASSOC);
  $statement->closeCursor();
  return $order;
}

//Gets the details for shoppers.
function  getShopperIDs($db,$user,$status){
//  $query = "SELECT orderID FROM orders WHERE orders.status = 'o'";
  $query= "SELECT orders.orderID,orders.orderTotal ,customer.firstName, customer.lastName, customer.address FROM orders INNER JOIN customer ON orders.email = customer.email WHERE orders.status = '$status' AND shopper='$user'";
  $statement = $db->prepare($query);
  $statement->execute();
  $order = $statement->fetchAll(PDO::FETCH_ASSOC);
  $statement->closeCursor();
  return $order;
}

//Gets the order details
function  getOrderDetails($db,$id){
//  $query = "SELECT orderdetails.itemID, orderdetails.qty  FROM orders INNER JOIN orderdetails ON orders.orderID = orderdetails.orderID WHERE orders.orderID = '$id'";
//  $query = "SELECT orders.itemName, orderdetails.qty  FROM orders INNER JOIN orderdetails ON orders.orderID = orderdetails.orderID WHERE orders.orderID = '$id'";
//  $query = "SELECT items.itemName,orderdetails.qty FROM orders INNER JOIN orderdetails.itemID = items.itemID INNER JOIN items ON orderdetails.itemID = items.itemID WHERE orders.orderID='$id'";
  $query ="SELECT items.itemName, orderdetails.qty, items.price FROM orders INNER JOIN orderdetails ON orders.orderID = orderdetails.orderID INNER JOIN items ON orderdetails.itemID = items.itemID WHERE orders.orderID = '$id'";
  $statement = $db->prepare($query);
  $statement->execute();
  $order = $statement->fetchAll(PDO::FETCH_ASSOC);
  $statement->closeCursor();
  return $order;
}


function  pastOrders($db,$user){
//  $query = "SELECT orderID FROM orders WHERE orders.status = 'o'";
  $query= "SELECT orders.orderID, orders.orderTotal ,customer.firstName, customer.lastName, customer.address FROM orders INNER JOIN customer ON orders.email = customer.email WHERE orders.email = '$user' AND orders.status='c'";
  $statement = $db->prepare($query);
  $statement->execute();
  $order = $statement->fetchAll(PDO::FETCH_ASSOC);
  $statement->closeCursor();
  return $order;
}

//Adds the deails of a newly placed order.
function addDetails($db,$orderID,$itemID ,$qty){
      $query ="INSERT INTO orderdetails(orderID,itemID,qty) VALUES ('$orderID', '$itemID', '$qty')";
      $statement = $db->prepare($query);
      $statement->execute();
      $firstName= $statement->fetch();
      $statement->closeCursor();
    }


?>

