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
require_once __DIR__.'/../vendor/autoload.php';
session_start();
/**
 * Create a google Client for move album to Drive
 */

class CreateGoogleClient
{
    /**
     * Create a google Client for move album to Drive
     * 
     * @return GoogleClient
     */
    function createClient()
    {
        $client = new Google_Client();
        $client->setAuthConfigFile('../client_secrets.json');
        $client->setAccessType("offline");
        $client->setIncludeGrantedScopes(true);
        $client->addScope(Google_Service_Drive::DRIVE);
        return $client;
    }
}
?>