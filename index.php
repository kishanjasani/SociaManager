<?php
/** 
 * Copyright 2018 Social Manager.
 * 
 * PHP version 7.2.8
 *
 * @category Album_Manager
 * @package  Facebook
 * @author   Kishan Jasani <kishanjasani007@yahoo.in>
 * @license  https://localhost/SocialManager/privacy_policy/privacy_policy.php 
 * @link     ""
 * 
 * You are hereby granted a non-exclusive, worldwide, royalty-free license to
 * use, copy, modify, and distribute this software in source code or binary
 * form for use in connection with the web services and APIs provided by
 * Kishan Jasani.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND
 */
require_once "fb-callback.php";
$response = $fb->get(
    "/me?fields=id,first_name,last_name,email,picture,albums{picture,name}", 
    $accessToken
);
$userData = $response->getGraphNode()->asArray();
$_SESSION['userid'] = $userData['id'];
$_SESSION['email']=$userData['email'];
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Social Manager</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="public/css/main.css" />
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+"
    crossorigin="anonymous"></script>
    <!--Let browser know website is optimized for mobile-->
    <style>
      
    </style>
  </head>

  <body>
      <div class="navbar-fixed">
        <nav class="nav-extended grey darken-4">
            <div class="container">
              <div class="nav-wrapper makeLarge">
                  <a href="#home" class="brand-logo grey-text lighten-2">
                    <span><h5>Social Manager</h5><span>
                  </a>
                  <a href="" class="button-collapse" data-activates="mobile-nav">
                    <i class="material-icons">menu</i>
                  </a>
                  <ul class="right hide-on-med-and-down">
                      <li>
                        <a href="#" class="btn green lighen-1 waves-effect waves-light" id= "download-all-albums">Download All</a>
                      </li>
                      <li>
                        <a href="#" class="btn  lime  waves-effect waves-light" id="move_all">Move All</a>
                      </li>
                      <li>
                        <a href="https://localhost:8443/SociaManager/logout.php" class="">Logout</a>
                      </li>            
                  </ul>
              </div>    
            <div class="nav-content center selectedAlbums">          
                <div class="row center">
                    <div class="col s6"></div>
                    <div class="col s6 ">
                        <a href="#Contact" class="btn-large grey darken-3 waves-effect waves-light" id="download-selected-albums">
                          <i class="material-icons left">send</i> Download Selected</a>
                        <a href="#Contact" class="btn-large amber darken-3 waves-effect waves-light" id="move-selected-albums">
                          <i class="material-icons left">send</i> Move Selected</a>
                    </div>
                </div>
            </div>
          </div>
        </nav>
      </div>

      <ul id="mobile-nav" class="side-nav">
          <li>
              <div class="user-view">
                  <div class="background">
                    <img src="public/img/ocean.jpg" alt="Side bar">
                  </div>
                  <a href="#">
                    <img src="<?php echo $userData['picture']['url'] ?>" alt="Profile Picture" class="circle">
                  </a>
                  <a href="#">
                    <span class="name white-text"><?php echo $userData['first_name'] ." ".$userData['last_name'] ?></span>
                  </a>
                  <a href="#">
                    <span class="email white-text"><?php echo $userData['email'] ?></span>
                  </a>
              </div>
          </li>                  
          <li>
              <a href="#" class="btn grey darken-3 waves-effect waves-light" id= "download-all-albums">Download All Album</a>
          </li>
          <li>
              <a href="#" class="btn grey darken-3 waves-effect waves-light" id="move_all">Move All Album</a>
          </li>
          <li>
            <div class="divider"></div>
          </li>
          <li>
            <a href="#" class="subheader">Account Header</a>
          </li>
          <li>
            <a href="https://localhost:8443/SociaManager/logout.php">Logout</a>
          </li>
      </ul>

    <!--Section : Profile-->
    <section id="profile" class="section section-profile">
        <div class="container">
            <div class="row">
                <div class="col m6">
                  <center>
                    <div class="profilepic">
                      <img style="margin-top: 40px; margin-left:55px;" src="<?php echo $userData['picture']['url'] ?>" alt="Profile Picture" class="materialboxed circle responsive-img">
                    </div>
                    <p class="center teal-text" style="font-size: 25px;"><strong><?php echo $userData['first_name'] ." ". $userData['last_name'] ?></strong><p>            
                  <center>
                </div>
                <div class="col l6 profile-detaile">
                    <table>
                      <tbody>
                          <tr>
                              <td></td>
                              <td><label class="teal-text" for="firstName">First Name</label></td>
                              <td><input type="text" id="firstName" value="<?php echo $userData['first_name'] ?>" readonly></td>
                          </tr>
                          <tr>
                              <td></td>
                              <td><label class="teal-text" for="lastName">Last Name</label></td>
                              <td><input type="text" id="lastName" value="<?php echo $userData['last_name'] ?>" readonly></td>
                          </tr>
                          <tr>
                              <td></td>
                              <td><label class="teal-text" for="email">Email</label></td>
                              <td><input type="text" id="email" value="<?php echo $userData['email'] ?>" readonly></td>
                          </tr>
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Section : Albums -->
    <section id="albums" class="section section-albums">
         <div class="container">       
            <div class="row">
                <h4 class="center">
                  <span class="teal-text">User</span> Albums
                </h4>
                <?php
                foreach ($userData['albums'] as $albumm) {
                    ?>
                <div class="col s12 m4" >
                    <div class="card">
                        <div class="card-image" album-id="<?php echo $albumm['id'] ?>">
                            <div class="modal-trigger" href="#<?php echo $albumm['id'] ?>">
                                <img src="<?php echo $albumm['picture']['url']?>" class="img-decore">
                            </div>
                        </div>
                        <div class="card-content">
                          <center>
                              <button type="button" rel="<?php echo $albumm['id'].','.$albumm['name'];?>" class="btn waves-effect waves-light red single-download"><i class="material-icons">get_app</i></button><br/><br/>
                              <input type="checkbox"  class="select-album" value="<?php echo $albumm['id'].','.$albumm['name'];?>" class="filled-in" />
                              <br/>
                              <span class="card-title"><?php echo $albumm['name'];?></span>
                              <button type="button" rel="<?php echo $albumm['id'].','.$albumm['name'];?>" class="btn waves-effect waves-light blue move-single-album">Move to Drive</button>
                          </center>
                        </div>
                    </div>
                </div>
                    <?php
                }
                ?>
            </div>
        </div> 
        <div id="myNav" class="overlay">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <div class="overlay-content">
                <div class="slideshow-container">
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                </div>
            </div>
        </div>

    </section>

    <div id="display-response"></div>

    <div class="loader"></div>

    <div class="download-process">
        <div class="loaderprocess"></div>
        <h6 class="loadermessage">Loading...!!</h6>
    </div>

    <div id="modal" class="modal">
      <center>
        <div class="modal-content">
          
        </div>
      </center>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
      </div>
    </div>

    <?php
    $google_access_token= "";
    if (isset($_SESSION['google_access_token'])) {
        $google_access_token = $_SESSION['google_access_token'];
    } 
    ?>

    <div id="<?php echo $google_access_token ?>" class="g-access-token"></div>

    <!-- Footer -->

    <footer class="section grey darken-4 white-text center">
      <p class="flow-text">
        Social Manager &copy; 2018
      </p>
    </footer>

      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
      <script src="./public/js/script.js"></script>
  </body>

</html>