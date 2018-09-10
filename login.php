<?php
/** 
 * Copyright 2018 Social Manager.
 * 
 * PHP version 7.2.8
 *
 * @category Album_Manager
 * @package  Facebook
 * @author   Kishan Jasani <kishanjasani007@yahoo.in>
 * @license  https://rtfbchallenge.tk/privacy_policy/privacy_policy.php 
 * @link     ""
 * 
 * You are hereby granted a non-exclusive, worldwide, royalty-free license to
 * use, copy, modify, and distribute this software in source code or binary
 * form for use in connection with the web services and APIs provided by
 * Kishan Jasani.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND
 */
  require_once __DIR__ . "/config.php";

if (isset($_SESSION['accessToken'])) {
    header('Location: https://localhost:8443/SociaManager/index.php'); 
    exit();
}
$permissions = ['email','user_photos'];
$loginUrl = $helper->getLoginUrl(
    'https://localhost:8443/SociaManager/index.php', 
    $permissions
);
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" media="screen,projection" />
        <link type="text/css" rel="stylesheet" href="public/css/main.css" />
        <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+"
          crossorigin="anonymous"></script>
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <style>
            .login-back {
              background-image: url('public/img/background-image.png');
              background-attachment: fixed;
              background-repeat: no-repeat;
              background-size: cover;
            }
            .loginBtn {
              position:absolute;
              top:50%;
              left: 50%;
            }
        </style>
        <title>Social Manager</title>
    </head>

  <body class="login-back">
      <div>      
          <div class="row wrapper">
            <div class="col s12 loginBtn">
            <center>
                <?php echo '<a href="' . htmlspecialchars($loginUrl) . '" class="btn btn-large blue darken-3 button"><i class="fab fa-facebook"></i><span class="text-space">Login With Facebook</span></a>'; ?>
            </center>
            </div>
          </div>
      </div>

      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
  </body>
</html>