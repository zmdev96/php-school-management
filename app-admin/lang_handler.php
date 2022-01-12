<?php
ob_start();
  session_start();
  $app  = 'app-admin';
  require_once('../config.php');
  $_SESSION['app_lang'] = APP_LANGUAGE;
  $lang = isset($_GET['lang']) ? $_GET['lang']: 'index';
  if ($lang == 'en') {
    if (isset($_SESSION['app_lang']) && $_SESSION['app_lang'] == 'ar') $_SESSION['app_lang'] = 'en';
    redirect('back');
  }elseif ($lang == 'ar') {
    if (isset($_SESSION['app_lang']) && $_SESSION['app_lang'] == 'en') $_SESSION['app_lang'] = 'ar';
    redirect('back');
  }
ob_end_flush();
