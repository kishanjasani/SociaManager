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

$zip_folder = "";
$album_download_directory = 'public/'.uniqid().'/';
mkdir($album_download_directory, 0777, true);

/**
 * It will downloads the album from facebook
 * 
 * @param String $accessToken              acess token for the access albums
 * @param String $album_download_directory directory where album will be store
 * @param String $album_id                 Id of ther album 
 * @param String $album_name               Album name
 * @param String $fb                       Facebook Object
 * 
 * @return ""
 */
function Download_album(
    $accessToken, 
    $album_download_directory, 
    $album_id, 
    $album_name, 
    $fb
) {
    $request_album_photos = $fb->get($album_id . "/photos?fields=source", $accessToken); //photos?fields=source
    $album_photos=$request_album_photos->getGraphEdge()->asArray();

    $album_directory = $album_download_directory.$album_name;
    if (!file_exists($album_directory)) {
         mkdir($album_directory, 0777);
    }

    $i = 1;
    foreach ( $album_photos as $album_photo ) {
        file_put_contents(
            $album_directory.'/'.$i.".jpg", 
            fopen($album_photo['source'], 'r')
        );
        $i++;
    }
}

//---------- For 1 album download -------------------------------------------------//
if (isset($_GET['single_album']) && !empty($_GET['single_album'])) {
    $single_album = explode(",", $_GET['single_album']);
    Download_album(
        $accessToken, 
        $album_download_directory, 
        $single_album[0], 
        $single_album[1], 
        $fb
    );
}

//---------- For Selected Albums download -----------------------------------------//
if (isset($_GET['selected_albums']) && !empty($_GET['selected_albums'])) {
    $selected_albums = explode("/", $_GET['selected_albums']);
    foreach ($selected_albums as $selected_album) {
        $selected_album = explode(",", $selected_album);
        Download_album(
            $accessToken, 
            $album_download_directory, 
            $selected_album[0], 
            $selected_album[1], 
            $fb
        );
    }
}

//---------- Download all album code --------------------------------------//
if (isset($_GET['all_albums']) && !empty($_GET['all_albums'])) {
    if ($_GET['all_albums'] == 'all_albums') {
        $response_albums = $fb->get('/me/albums?fields=id,name', $accessToken);
        $albums = $response_albums->getGraphEdge()->asArray();
        if (!empty($albums)) {
            foreach ($albums as $album) {
                Download_album(
                    $accessToken, 
                    $album_download_directory, 
                    $album['id'], 
                    $album['name'], 
                    $fb
                );
            }
        }
    }
}

if (isset($_GET['zip'])) {
    include_once 'zipper.php';
    $zipper = new Zipper();
    echo $zipper->getZip($album_download_directory);
}
?>