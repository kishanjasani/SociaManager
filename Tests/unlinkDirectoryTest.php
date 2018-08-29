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
class UnlinkDirectoryTest extends PHPUnit_Framework_TestCase
{
    protected $unlink_directory;
    /** 
     * Call before all test
     * 
     * @return ""
     */
    protected function setUp() 
    {
        $this->unlink_directory = new Unlink_Directory();
    }

    /** 
     * Test method to reove directory
     * 
     * @param String $directory Directory to delete
     * 
     * @return ""
     */
    function testRemoveDirectory($directory = null) 
    {
        $actual = $this->unlinkDirectory->removeDirectory($directory);
        $this->assertEquals($actual, $actual);
    }

    /** 
     * Call after all test
     * 
     * @return ""
     */
    protected function tearDown() 
    {
        unset($this->unlink_directory);
    }
}
//Run this file using command vendor/bin/phpunit Tests
?>
