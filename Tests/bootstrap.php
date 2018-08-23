<?php
/** 
 * Copyright 2018 Social Manager.
 * 
 * PHP version 7.2.8
 *
 * @category Album_Manager
 * @package  Tests
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
function loader($class)
{
    $file = $class . '.php';
    if (file_exists($file)) {
        include $file;
    }
}
spl_autoload_register('loader');