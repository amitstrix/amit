<?php

   $to = $_POST['email'];
   $subject = "Thanku for order";
         
   $message = "Your order has been successfully placed! Thank you for shopping with us. The total amount for your purchase is ". $_POST['price'] ." Your order name is ". $_POST['product_name'] . ". We'll notify you once your items are on their way. Happy shopping!";
         
   $header = "From:akshurajput355@gmail.com\r\n";         
   $temp = mail ($to,$subject,$message,$header);
         
   if( $temp == true ) 
   {
      echo "Mail Sent";
   }
   else 
   {
      echo "Unable to Send Mail";
   }
?>