<?php
ob_start();
  session_start();
  $app = 'web';
  require_once('config.php');
  $page_title = $lang['page_index'];

  // Website Home page
  // Start Content View
  echo 'Welcome ' . $page_title;

ob_end_flush();
