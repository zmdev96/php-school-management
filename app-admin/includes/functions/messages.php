<?php
function messagesPut($type, $msg) {
  $_SESSION['messages'] = [
    'type' => $type,
    'message' => $msg,
  ];
}

function messagesExists() {
    return isset($_SESSION['messages']);
}
function messagesGet() {
  if (isset($_SESSION['messages'])) {
    return $_SESSION['messages'];
  }
}
