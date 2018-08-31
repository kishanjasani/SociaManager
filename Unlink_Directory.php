<?php
/** 
 * Copyright 2018 Social Manager.
 * 
 * PHP version 7.2.8
 *
 * @category Album_Manager
 * @package  HelperClass
 * @author   Kishan Jasani <kishanjasani007@yahoo.in>
 * @license  https://localhost/SocialManager/privacy_policy/privacy_policy.php 
 * @link     ""
 * You are hereby granted a non-exclusive, worldwide, royalty-free license to
 * use, copy, modify, and distribute this software in source code or binary
 * form for use in connection with the web services and APIs provided by
 * Kishan Jasani.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND
 */
class Unlink_Directory
{
    /**
     * Remove the album directory
     * 
     * @param String $directory Name of the directory
     * 
     * @return String 
     */
    function removeDirectory($directory) 
    {
        if (isset($directory)) {
            foreach (glob("{$directory}/*") as $file) {
                if (is_dir($file)) { 
                    $this->removeDirectory($file);
                } else {
                    unlink($file);
                }
            }
            rmdir($directory);
        }
    }
}
?>