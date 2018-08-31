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
require_once "fb-callback.php";

if (isset($_GET['albumId'])) {
    $albumId = $_GET['albumId'];
    $response_albums = $fb->get($albumId . "/photos?fields=images,id&limit=500", $accessToken);
    $albums=$response_albums->getGraphEdge()->asArray(); 
    $slides =""; 
    foreach ($albums as $album) {
        $albumUrl = $album['images'][0]['source'];
        $slides .= '<div class="mySlides fade">';
        $slides .= '<img src="'. $albumUrl .'" style="width:100%; height: 450px"></div>';
    }
    echo $slides;
}

?>