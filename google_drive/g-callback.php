<?php
/** 
 * Copyright 2018 Social Manager.
 * PHP version 7.2.8
 *
 * It will Zip the file
 * 
 * @category Album_Manager
 * @package  Zipper
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
require_once 'gClient.php';
$gClient =new CreateGoogleClient();
$client = $gClient->createClient();

if (! isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
    $client->authenticate($_GET['code']);
    $_SESSION['google_access_token'] = $client->getAccessToken();
    $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . '/SociaManager/index.php';
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
};
?>