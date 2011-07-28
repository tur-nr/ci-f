<?php

if (!function_exists('fDatabase')) {
    function fDatabase ($type, $database=null, $user=null, $pass=null, $host=null, $port=null, $time=null)
    {
        if (true === $type) {
            if (!defined('ENVIRONMENT') || !file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database'.EXT)) {
                if (!file_exists($file_path = APPPATH.'config/database'.EXT)) {
                    throw new fUnexpectedException('Could not locate database configurations.');
                }
            }
            
            include($file_path);
            
            $type     = $db[$active_group]['dbdriver'];
            $database = $db[$active_group]['database'];
            $user     = $db[$active_group]['username'];
            $pass     = $db[$active_group]['password'];
            $host     = $db[$active_group]['hostname'];
            $port     = null;
            $time     = null;
        }
        else {
            if (is_null($database)) {
                throw new fProgrammerException('No database was specified.');
            }
        }
        
        return new fDatabase($type, $database, $user, $pass, $host, $port, $time);
    }
}