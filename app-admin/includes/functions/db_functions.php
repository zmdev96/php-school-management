<?php
// Crypt Password
function crypt_pass($password){
  $salt = '$2a$07$yeNCSNwRpYopOhv0TrrReP$';
  return crypt($password, $salt);
}
 // Get All Record From Specific Table
function getAll($value, $table ) {
  global $con;
  // Select Data
  $stmt = $con->prepare("SELECT $value FROM  $table  ");
  // Execute The Statement
  $stmt->execute();
  // Assign To Variable
  $info = $stmt->fetchAll();
  return $info;
}
// Check if the id exists in database
function check($select, $from , $value) {
  global $con;
  $stmt = $con->prepare("SELECT $select FROM $from WHERE $select = ? ");
  $stmt->execute(array($value));
  $count = $stmt->rowCount();
  return $count;
}

// Get Count From Particular Table
function getCount($item, $table){
  global $con;
  $stmt = $con->prepare("SELECT COUNT($item) FROM $table");
  $stmt->execute();
  return $stmt->fetchColumn();
}
