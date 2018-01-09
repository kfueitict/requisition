<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
$hook['post_controller'] = array(
    'class' => 'AuditLog',
    'function' => 'log',
    'filename' => 'AuditLog.php',
    'filepath' => 'hooks'
);
/*
$hook['pre_system'][] = array(
    'class' => 'PHPFatalError',
    'function' => 'setHandler',
    'filename' => 'PHPFatalError.php',
    'filepath' => 'hooks'
);*/