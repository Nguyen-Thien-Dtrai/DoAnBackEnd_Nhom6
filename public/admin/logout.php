<?php
require_once 'header-require-models.php';
session_start();
session_destroy();
header('location:http://localhost/TiemBanhNgot/public/login/login.php');