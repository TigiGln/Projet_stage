<?php
  $position;
  if(file_exists("./POO")) {   //Index and the like
    $position = ".";
  } else if(file_exists("../POO")) { //pages and the like
    $position = "..";
  } else if(file_exists("../../../POO")) { //modules and the like
    $position = "../../..";
  }
  require($position."/views/dbLoader.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Outil Biblio</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
<?php
      echo '<link rel="icon" href="'.$position.'/pictures/ico.ico" />';
?>
    <!-- Bootstrap Import -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <!-- Website Style -->
<?php
    echo '<link href="'.$position.'/css/style.css" rel="stylesheet">';
    echo '<link href="'.$position.'/css/redefinebootstrap.css" rel="stylesheet">';
    echo '<link href="'.$position.'/css/result.css" rel="stylesheet">';
?>
  </head>
  <body>

