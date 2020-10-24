  <?php
  echo "asada";
 ini_set("display_errors", 0); 
ini_set("log_errors", 1); 
         $to = "sandyam190@gmail.com";
         $subject = "This is subject";
         
         $message = "<b>This is HTML message.</b>";
         $message .= "<h1>This is headline.</h1>";
         $header='';
        // $header = "From:sandyam190@gmail.com \r\n";
         $header .= "Cc:rajeshmedicharla1997@gmail.com \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail($to,$subject,$message,$header);
         
         if( $retval == true ) {
            echo "Message sent successfully...";
         }else {
			 echo error_get_last();
            echo "Message could not be sent...";
         }
		 print_r(error_get_last());
      ?>