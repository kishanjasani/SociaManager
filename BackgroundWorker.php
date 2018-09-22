<?php
//Gearman Library
require_once 'LibGearman.php';

require __DIR__ . '/vendor/autoload.php';
/**
* Background Job Processor For Move Album To drive
* @category php
* @package SocialManager
* @author Kishan Jasani <kishanjasani007@yahoo.in>
* @license https://github.com/kishanjasani/SociaManager
*/
class BackgroundWorker {

    public $main_arr = array();

    public function worker() {
        $gearman = new LibGearman();
        $worker = $gearman->gearman_worker();
        $gearman->add_worker_function('moveToDrive', 'BackgroundWorker::moveToDrive');
        $gearman->add_worker_function('getAlbum', 'BackgroundWorker::getAlbum');

        while ($gearman->work()) {
            if (!$worker->returnCode()) {
                echo date('c') . " worker done successfully \n";
            }
            if ($worker->returnCode() != GEARMAN_SUCCESS) {
                echo "return_code: " . $gearman->current('worker')->returnCode() . "\n";
                break;
            }
        }
    }

    /**
     * Remove the album directory
     *
     * @param String $accessToken    access token of facebook
     * @param String $albumId        album id to store data into drive
     * @param String $albumName      album name
     * @param String $fb             facebook object
     * @param String $drive          drive object
     * @param String $parentFolderId ParentId
     *
     * @return ""
     */

    public static function moveToDrive($job = null) {
        $data = unserialize($job->workload());
        global $main_arr;
        $fb = new Facebook\Facebook(
            [
                'app_id' => 'XXXXXXXXXX',
                'app_secret' => 'XXXXXXXXXX',
                'default_graph_version' => 'v2.2'
            ]
        );
        $client = new Google_Client();
        $client->setAuthConfigFile(__DIR__ . '/client_secret.json');
        $client->setAccessType("online");
        $client->setIncludeGrantedScopes(true);
        $client->addScope(Google_Service_Drive::DRIVE);
        $client->setAccessToken($data['google_access_token']);
        $fileMetadata = new Google_Service_Drive_DriveFile(
            array(
            'name' => $data['albumName'],
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents' => array($data['parentFolderId']))
        );
        $drive = new Google_Service_Drive($client);
        $SubFolder = $drive->files->create(
            $fileMetadata,
            array('fields' => 'id')
        );

        $request_albums_photo = $fb->get($data['albumId'] ."/photos?fields=images&limit=100", $data['accessToken']);
        $arr_alb = $request_albums_photo->getGraphEdge();
        $i = 0;
        $resultAlbum = self::getAlbum($fb, $arr_alb, $i);

        $count = 1;
        foreach ($resultAlbum as $images) {
            $url = $images['images'];
            $img = $count.".jpeg";
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
                print "An error occurred: " . $e->getMessage();
            }

            $count++;
        }
        $main_arr = array();
    }

    public static function getAlbum($fb,$arr_alb,$i)
    {
        global $main_arr;
        foreach ($arr_alb as $graphNode) {
            $main_arr[$i]['images'] = $graphNode['images'][0]['source'];
            $i++;
        }
        $arr_alb = $fb->next($arr_alb);
        if(!empty($arr_alb)) {
            self::getAlbum($fb, $arr_alb, $i);
        }
        return $main_arr;
    }
}

$background = new BackgroundWorker();
$background->worker();
