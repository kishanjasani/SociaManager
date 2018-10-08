<?php
/** 
 * Copyright 2018 Social Manager.
 * PHP version 7.2.8
 *
 * It will move your album to google drive
 * 
 * @category Album_Manager
 * @package  Google
 * @author   Kishan Jasani <kishanjasani007@yahoo.in>
 * @license  https://fbrtchallenge.tk/privacy_policy/privacy_policy.php 
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
require_once __DIR__.'/gClient.php';
require_once "../fb-callback.php";
require_once '../LibGearman.php';

$gClient =new CreateGoogleClient();
$client = $gClient->createClient();

if (isset($_SESSION['google_access_token'])) {
    $client->setAccessToken($_SESSION['google_access_token']);

    $drive = new Google_Service_Drive($client);

    $rootFolderName = 'facebook_' . $_SESSION['userid'] . '_albums';
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

    if (isset($_GET['single_album']) && !empty($_GET['single_album'])) {
        $single_album = explode(",", $_GET['single_album']);
        if (class_exists('GearmanClient')) {
            $gearman = new LibGearman();
            $gearman->gearman_client();
            try{
                $gearman->do_job_background('moveToDrive', serialize(['accessToken' => $_SESSION['accessToken'], 'albumId' => $single_album[0], 'albumName' => $single_album[1],'google_access_token' => $_SESSION['google_access_token'], 'parentFolderId' => $parentFolderId]));
            } catch (Exception $e) {
                echo "Gearman Client unable to handle request : " . $e->getMessage();
            }  
        }
        else {
            echo "Gearman Does Not Support";
        }
        $response = "Your Albums Will successfully backuped with in few time!!!";
        echo $response;
    }

    if (isset($_GET['selected_albums']) && !empty($_GET['selected_albums'])) {
        $selected_albums = explode("-", $_GET['selected_albums']);
        foreach ($selected_albums as $selected_album) {
            $selected_album = explode(",", $selected_album);
            if (class_exists('GearmanClient')) {
                $gearman = new LibGearman();
                $gearman->gearman_client();
                try{
                    $gearman->do_job_background('moveToDrive', serialize(['accessToken' => $_SESSION['accessToken'], 'albumId' => $selected_album[0], 'albumName' => $selected_album[1],'google_access_token' => $_SESSION['google_access_token'], 'parentFolderId' => $parentFolderId]));
                } catch (Exception $e) {
                    echo "Gearman Client unable to handle request : " . $e->getMessage();
                }  
            }
            else {
                echo "Gearman Does Not Support";
            }
        }
        $response = "Your Selected Albums will successfully backuped with in few time!!!";
        echo $response;
    }

    if (isset($_GET['all_albums']) && !empty($_GET['all_albums'])) {
        if ($_GET['all_albums'] == 'all_albums') {
            // graph api request for user data
            $response_albums = $fb->get('/me/albums?fields=id,name', $accessToken);
            // get response
            $albums = $response_albums->getGraphEdge()->asArray();

            if (!empty($albums)) {
                foreach ($albums as $album) {
                    if (class_exists('GearmanClient')) {
                        $gearman = new LibGearman();
                        $gearman->gearman_client();
                        try{
                            $gearman->do_job_background('moveToDrive', serialize(['accessToken' => $_SESSION['accessToken'], 'albumId' => $album['id'], 'albumName' => $album['name'],'google_access_token' => $_SESSION['google_access_token'], 'parentFolderId' => $parentFolderId]));
                        } catch (Exception $e) {
                            echo "Gearman Client unable to handle request : " . $e->getMessage();
                        }  
                    }
                    else {
                        echo "Gearman Does Not Support";
                    }
                }
                $response = "Your All Albums will successfully backuped with in few time!!!";
                echo $response;
            }
        }
    }

} else {
    $redirect_uri = 'https://localhost:8443/SociaManager/google_drive/g-callback.php';
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
?>
