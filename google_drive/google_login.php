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
ini_set('max_execution_time', 999999);
require_once __DIR__.DIRECTORY_SEPARATOR.'gClient.php';
require_once "../fb-callback.php";

$gClient =new CreateGoogleClient();
$client = $gClient->createClient();

if (isset($_SESSION['google_access_token']) && $_SESSION['google_access_token']) {
    $client->setAccessToken($_SESSION['google_access_token']);

    $drive = new Google_Service_Drive($client);
    /**
     * Remove the album directory
     * 
     * @param String $accessToken access token of facebook
     * @param String $albumId     album id to store data into drive
     * @param String $albumName   album name 
     * @param String $fb          facebook object
     * @param String $drive       drive object
     * 
     * @return "" 
     */
    $rootFolderName = 'facebook_'.$_SESSION['userid'].'_albums';
            $fileMetaData = new Google_Service_Drive_DriveFile(
                array(
                    'name' => $rootFolderName,
                    'mimeType' => 'application/vnd.google-apps.folder')
            );
            $parentFolder = $drive->files->create(
                $fileMetaData, 
                array('fields' => 'id')
            );
            $parentFolderId = $parentFolder->getId();

    function moveToDrive($accessToken, $albumId, $albumName, $fb, $drive, $parentFolderId) 
    {

        $fileMetadata = new Google_Service_Drive_DriveFile(
            array(
            'name' => $albumName,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents' => array($parentFolderId))
        );
        $SubFolder = $drive->files->create(
            $fileMetadata, 
            array('fields' => 'id')
        );

        $responseImg = $fb->get($albumId.'/photos?fields=source', $accessToken);
        $graphNodeImg = $responseImg->getGraphEdge();
        $resultImg = json_decode($graphNodeImg);

        foreach ($resultImg as $images) {
            $url = $images->source;
            $img = $images->id.".jpeg";
            $folderId = $SubFolder->id;
            $fileMetadata = new Google_Service_Drive_DriveFile(
                array(
                'name' => $img, 
                'parents' => array($folderId))
            );
            try {
                $fileContent = file_get_contents($url);
                $file = $drive->files->create(
                    $fileMetadata, 
                    array(
                    'data' => $fileContent, 'mimeType' => 'image/jpeg',
                    'uploadType' => 'multipart', 'fields' => 'id')
                );
            }catch (Exception $e) {
                $response = "Due to some reason uploading to drive is failed!";
                print "An error occurred: " . $e->getMessage();
            }
        }
        $response = "File successfully backuped!!!";
        return $response;
    }

    if (isset($_GET['single_album']) && !empty($_GET['single_album'])) {
        $response = '<span>Sorry due to some reasons albums is not moved to goofle drive.</span>';
        $single_album = explode(",", $_GET['single_album']);
        $response = moveToDrive(
            $accessToken, 
            $single_album[0], 
            $single_album[1], 
            $fb, 
            $drive,
            $parentFolderId
        );
        return $response;
    }

    if (isset($_GET['selected_albums']) && !empty($_GET['selected_albums'])) {
        $response = '<span>Sorry due to some reasons albums is not moved to goofle drive.</span>';
        $selected_albums = explode("-", $_GET['selected_albums']);
        foreach ( $selected_albums as $selected_album ) {
            $selected_album = explode(",", $selected_album);
            $response .= moveToDrive(
                $accessToken, 
                $selected_album[0], 
                $selected_album[1], 
                $fb, 
                $drive,
                $parentFolderId
            );
        }
        return $response;
    }

    if (isset($_GET['all_albums']) && !empty($_GET['all_albums'])) {
        $response = '<span>Sorry due to some reasons albums is not moved to goofle drive.</span>';
        if ($_GET['all_albums'] == 'all_albums') {
            // graph api request for user data
            $response_albums = $fb->get('/me/albums?fields=id,name', $accessToken);
            // get response
            $albums = $response_albums->getGraphEdge()->asArray();

            if (!empty($albums)) {
                foreach ($albums as $album) {
                    $response .= moveToDrive(
                        $accessToken, 
                        $album['id'], 
                        $album['name'], 
                        $fb, 
                        $drive,
                        $parentFolderId
                    );
                }
                return $response;
            }
        }
    }

} else {
    $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . '/SociaManager/google_drive/g-callback.php';
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
?>
