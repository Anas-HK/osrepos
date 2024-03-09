<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$length = 32; // Length in bytes (256 bits)
$key = bin2hex(random_bytes($length));


$config['jwt_key'] = $key;
$config['jwt_algorithm'] = 'HS256';
$config['jwt_expire_time'] = 3600; // Token expiration time in seconds (1 hour in this example)
$config['token_header'] = 'Authorization';