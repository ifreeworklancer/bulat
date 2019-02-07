<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

require_once(__DIR__ . '/web.admin.php');
require_once(__DIR__ . '/web.app.php');
