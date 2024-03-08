<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$random_bytes = random_bytes(32);
$secret_key = base64_encode($random_bytes);

$config['jwt_key'] = $secret_key;
?>
