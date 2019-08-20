  <?php
  $sess = session_id(); 
  if (!$sess) 
  {     
    // If the session hasn’t already been started, start it now and look up the id     
    session_start();     
    $sess = session_id();
    //echo $sess;
    //echo '</br>';
  }

   // RIS request --- requires curl support enabled in PHP
   // php_mbstring support enabled in your php.ini file
  
  // If using Direct Download
  require 'C:/xampp/htdocs/php-sdk-latest/src/autoload.php';
  //  OR

  // If using Composer installation
  //require __DIR__ . './vendor/autoload.php';

  // Minimal RIS inquiry example:
  try {
    $inquiry = new Kount_Ris_Request_Inquiry();
    $uniqueno = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 22));
    $orderno = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10));
    $uniquesessiondid = $sess;
    $inquiry->setSessionId($uniquesessiondid);
    $inquiry->setPayment('CARD', '4111111111111111');
    $inquiry->setOrderNumber($orderno);
    //$inquiry->setPayment('GOOG', '4111111111111112');
    $inquiry->setTotal(600);
    $inquiry->setEmail('sanjeev.kumar@intimetec.com');
    $inquiry->setIpAddress('49.206.242.238');
    $inquiry->setMack('Y');
    $inquiry->setWebsite("DEFAULT");
    $cart = array();
    $cart[] = new Kount_Ris_Data_CartItem("TV", "LZG-123", "32-inch LCD", 1, 129999);
    $inquiry->setCart($cart);
    $inquiry->setAuth('A');
   
    // additional optional setters..
    // setGender value can be either "M" or "F"

    $inquiry->setGender("M");
    $inquiry->setDateOfBirth("2017-03-12");

    //Set billing address and phone number
    $inquiry->setBillingAddress("5th Main","Near Presidency School","Bangalore","Karnataka", "560076", 
      "IN");

    $inquiry->setBillingPhoneNumber("9148291177");

    //Set shipping address and phone no
    $inquiry->setShippingAddress("24", "Village post-Raaje", "Darbhanga", "Bihar", "847424", "IN");
    $inquiry->setShippingPhoneNumber("8789878987");
    $inquiry->setShippingName("Default Shipname");
    $inquiry->setShippingEmail("shipping@email.com");

    //Get Unique No
    $inquiry->setUnique($uniqueno);

    $response = $inquiry->getResponse();
    // optional getter
    $warnings = $response->getWarnings();

    $score = $response->getScore();
    $omniscore = $response->getOmniScore();
    $auto = $response->getAuto();
    print_r($response);

  } catch (Exception $e) {
    print_r($e);
    // handle exception
  }
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <title>
      
    </title>
    <meta http-equiv="Content-Security-Policy" content="img-src https://*.kaptcha.com; script-src 'unsafe-inline' https://*.kaptcha.com; child-src https://*.kaptcha.com">
    <script type='text/javascript' src='https://tst.kaptcha.com/collect/sdk?m=900431&s=<?php echo $uniquesessiondid; ?>'></script>
  </head>
  <body class='kaxsdc' data-event='load'>
    <script type='text/javascript'>
      var client=new ka.ClientSDK();
      client.autoLoadEvents();
    </script>
  </body>
  </html>