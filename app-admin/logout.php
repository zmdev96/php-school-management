<?php
ob_start();
  session_start();
  $app  = 'app-admin';
  $page = 'login';
  require_once('../config.php');
  session_unset();
  session_destroy();
  redirect('login.php');
ob_end_flush();
