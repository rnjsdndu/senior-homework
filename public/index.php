<?php 
require_once "../db.php";
session_start();
require_once "../router.php";
require_once "../lib.php";
require_once "../controller/page.php";
router::handleRequest();