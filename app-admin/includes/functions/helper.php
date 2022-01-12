<?php

// Redirect Function

function redirect($path) {
  session_write_close();
  if ($path == 'back') {
    header('Location:' . $_SERVER['HTTP_REFERER']);
    exit;
  }else {
    header('Location:' . $path);
    exit;
  }
}

// pre autput

function pre($data){
  echo '<pre>';
    var_dump($data);
  echo '</pre>';
  return $data;
  die;
}
