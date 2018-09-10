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
require_once "fb-callback.php";

$zip_folder = "";
$album_download_directory = 'public/' . uniqid() . '/';
mkdir($album_download_directory, 0777, true);

$main_arr = array();

/**
 * It will downloads the album from facebook
 * 
 * @param String $accessToken              acess token for the access albums
 * @param String $album_download_directory directory where album will be store
 * @param String $album_id                 Id of ther album 
 * @param String $album_name               Album name
 * @param String $fb                       Facebook Object
 * 
 * @return 0
 */
function Download_album(
    $accessToken, 
    $album_download_directory, 
    $album_id, 
    $album_name, 
    $fb
) {
    global $main_arr;
    $album_directory = $album_download_directory.$album_name;
    if (!file_exists($album_directory)) {
         @mkdir($album_directory, 0777) || exit("Coudn't able to create directory");
    }

    $request_albums_photo = $fb->get($album_id . "/photos?fields=images&limit=100", $accessToken);
    $arr_alb = $request_albums_photo->getGraphEdge();
    
    $i = 0;
    $resultAlbum = getAlbum($fb, $arr_alb, $album_name, $i);
    $count = 1;
    foreach ($resultAlbum as $album_photo) {
        file_put_contents(
            $album_directory . "/" . $count . ".jpg", 
            fopen($album_photo['images'], 'r')
        );
        $count++;
    }
    $main_arr = array();
}

/**
 * It will export the album from facebook and puut it into json file
 * 
 * @param String $accessToken acess token for the access albums
 * @param String $album_id    Id of ther album 
 * @param String $album_name  Album name
 * @param String $fb          Facebook Object
 * 
 * @return 0
 */
function Export_album($accessToken, $album_id, $album_name, $fb) 
{
    $request_albums_photo = $fb->get($album_id . "/photos?fields=images&limit=100", $accessToken);
    $arr_alb = $request_albums_photo->getGraphEdge();
    $i = 0;
    $resultAlbum = getAlbum($fb, $arr_alb, $album_name, $i);
    
    $response_json = json_encode(array($album_name => $resultAlbum), JSON_PRETTY_PRINT);
    $jsonFilename = './public/jsonData/fb-album_' . date("Y-m-d") . '_' . date("H-i-s") . '.json';
    $jsonFile = fopen($jsonFilename, "a") or die("Unable to open file!");
    fwrite($jsonFile, $response_json);
    fclose($jsonFile);
    
    echo '<a href="' . $jsonFilename . '" id="download-link" target="_blank" class="btn" >See JSON File</a>';
} 


/**
 * It will fetch all the album from the facebook and put it in array
 * 
 * @param String $fb         Facebook Object
 * @param String $arr_alb    limited array of the album
 * @param String $album_name Album name
 * @param String $i          taking care of index value of array 
 * 
 * @return "$main_arr"
 */
function getAlbum($fb, $arr_alb, $album_name, $i)
{
    global $main_arr;
    foreach ($arr_alb as $graphNode) {
        $main_arr[$i]['images'] = $graphNode['images'][0]['source'];
        $i++;
    }
    $arr_alb_ar = $fb->next($arr_alb);
    if (!empty($arr_alb_ar)) {
        getAlbum($fb, $arr_alb_ar, $album_name, $i);
    }
    return $main_arr;
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
    zipFolder($album_download_directory);
}

//---------- For Selected Albums download -----------------------------------------//
if (isset($_GET['selected_albums']) && !empty($_GET['selected_albums'])) {
    $selected_albums = explode("-", $_GET['selected_albums']);
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
    zipFolder($album_download_directory);
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
            zipFolder($album_download_directory);
        }
    }
}

//---------------Export Single album-------------------------//
if (isset($_GET['single_export']) && !empty($_GET['single_export'])) {
    $single_album = explode(",", $_GET['single_export']);
    Export_album(
        $accessToken,  
        $single_album[0], 
        $single_album[1],
        $fb
    );
}

function zipFolder($album_download_directory){
    if (isset($_GET['zip'])) {
        include_once 'zipper.php';
        $zipper = new Zipper();
        echo $zipper->getZip($album_download_directory);
    }
}
?>