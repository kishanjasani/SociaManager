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

ini_set('max_execution_time', 999999);
require_once "config.php";
if (isset($_SESSION['accessToken'])) {
    $accessToken = $_SESSION['accessToken'];
} else {
    try {
        $accessToken = $helper->getAccessToken();
        if (!isset($accessToken)) {
            header('Location: https://localhost:8443/SociaManager/login.php');
            exit();
        }
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    // The OAuth 2.0 client handler helps us manage access tokens
    $oAuth2Client = $fb->getOAuth2Client();

    // Get the access token metadata from /debug_token
    $tokenMetadata = $oAuth2Client->debugToken($accessToken);

    // Validation (these will throw FacebookSDKException's when they fail)
    $tokenMetadata->validateAppId('XXXXXXXXXXXX'); // Replace {app-id} with your app id
    // If you know the user ID this access token belongs to, you can validate it here
    $tokenMetadata->validateExpiration();

    if (! $accessToken->isLongLived()) {
        // Exchanges a short-lived access token for a long-lived one
        try {
            $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo "<p>Error getting long-lived access token: </p>\n\n";
            exit;
        }
    }
}

$_SESSION['accessToken'] = (string) $accessToken;

?>