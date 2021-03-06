<?php
session_start();
$manager = new Manager($_SESSION["connexiondb"]->pdo);#création de l'objet permettant d'agir sur la base de données
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
    <!-- Website Style -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/redefinebootstrap.css" rel="stylesheet">
    <link href="../css/result.css" rel="stylesheet">
    <script src="../trie_table_statut/sort_status.js"></script>
  </head>
  <body>
