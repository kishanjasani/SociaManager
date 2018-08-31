<?php

/** 
 * Copyright 2018 Social Manager.
 * 
 * PHP version 7.2.8
 *
 * @category Album_Manager
 * @package  Facebook
 * @author   Kishan Jasani <kishanjasani007@yahoo.in>
 * @license  https://rtfbchallenge.000webhostapp.com/privacy_policy/privacy_policy.php 
 * @link     ""
 * 
 * You are hereby granted a non-exclusive, worldwide, royalty-free license to
 * use, copy, modify, and distribute this software in source code or binary
 * form for use in connection with the web services and APIs provided by
 * Kishan Jasani.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND
 */

if (!session_id()) {
    session_start();
}
    
    require __DIR__ . '/vendor/autoload.php';
     
    $fb = new Facebook\Facebook(
        [
            'app_id' => 'XXXXXxXXXXXXX', // Replace {app-id} with your app id
            'app_secret' => 'XXXXXxXXXXXXXXXXXXXXXXX', // {app-secrete}
            'default_graph_version' => 'v2.2' 
        ]
    );

    $helper = $fb->getRedirectLoginHelper();
    
    ?>