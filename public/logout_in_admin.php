<?php
require_once "phplibs/templatingService.php";

session_unset();
session_destroy();

header("Location: login.php?redirect=admin.php");
exit;
?>