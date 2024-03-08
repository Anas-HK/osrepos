<?php
class Login extends CI_Controller {
    public function message($to = 'World') {
        echo "Logged in successfully {$to}!" . PHP_EOL;
    }
}
