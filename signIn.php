<?php
include($_SERVER["DOCUMENT_ROOT"].'/views/header.html');
?>
<link href="/css/signIn.css" rel="stylesheet">
<main class="form-signin">
  <form action="connexion.php" method="post">
    <div class="text-center">
      <img src="/pictures/logo_big.png" width="150">
      <h1>Outil Bibilio</h1>
    </div>
    <br>
    <!-- if something happen, error or can't connect, save the message to print it here like:
      $connectErr = "<div class='alert alert-danger' role='alert'><span class='error'>message d'erreur</span></div>";        -->
    <?php
      //echo($connectErr);
    ?>
    <div class="form-floating">
      <input type="email" class="form-control" id="floatingInput" placeholder="john@doe.com">
      <label for="floatingInput">Email</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">password</label>
    </div>
    <br>
    <button class="w-100 btn btn-lg btn-outline-primary" type="submit">Connection</button>
    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Connect me Automatically
      </label>
    </div>
  </form>
</main>
<?php
include($_SERVER["DOCUMENT_ROOT"].'/views/footer.html');
?>