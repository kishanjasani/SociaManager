<?php
    $code = $_SERVER['REDIRECT_STATUS'];
    $codes = array(
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error'
    );
    $source_url = 'http'.((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 's' : '').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if (array_key_exists($code, $codes) && is_numeric($code)) {
        $error_code = $code;
        $error_name = $codes[$code];
        $error = "Error $code: {$codes[$code]}";
    } else {
        //die('Unknown error');   
        $error_code = 1000;
        $error_name = "Unknown";
        $error = "Error Unknown";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $error_code; ?> : <?php echo $error_name; ?></title>
    <link rel="stylesheet" href="/public/css/lost.css">
</head>
    <body>
        <section id="not-found">
            <div id="title"><?php echo $error_code; ?> Error Page &bull; <?php echo $error_name; ?></div>
            <div id="loginBtn"><center><a href="https://rtfbchallenge.tk/login.php">Go back </a></center></div>
            <div class="circles">
            <p><?php echo $error_code; ?><br>
            <small><?php echo $error; ?></small>
            </p>
            <span class="circle big"></span>
            <span class="circle med"></span>
            <span class="circle small"></span>
            </div>
        </section>
    </body>
</html>