<?php

require __DIR__ . "/vendor/autoload.php";

use App\Core\Session;

new Session();

require __DIR__ . "/routes/web.php";