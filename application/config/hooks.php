<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH.'libraries\Dotenv.php';
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['pre_system'] = function() {
    $dotenv = new Dotenv(FCPATH);
    $dotenv->loadFile();
};