<?php
  $path = "/Projet_stage";
  require($_SERVER["DOCUMENT_ROOT"].$path."/POO/class_userConnection.php");
  $userConnection = new UserConnection($path, true);
  $userConnection->isValid();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Outil Biblio</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="/Projet_stage/pictures/ico.ico" />
    <!-- Bootstrap Import -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <!-- Website Style -->
<?php
    echo '<link href="'.$path.'/css/style.css" rel="stylesheet">';
    echo '<link href="'.$path.'/css/redefinebootstrap.css" rel="stylesheet">';
    echo '<link href="'.$path.'/css/result.css" rel="stylesheet">';
    echo '<script src="'.$path.'/trie_table_statut/sort_status.js"></script>';
?>
  </head>
  <body>

