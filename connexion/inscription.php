<!--
Formulaire pour l'inscription d'un utilisateur
-->
<!DOCTYPE html >
<html lang="en">
  <head>
      <meta charset="utf-8" />
      <title>Page de recherche d'article</title>
  </head>
  <body>
    <form method="get" action="enregistrement.php" enctype="multipart/form-data">
        <p>
          <input type="text" name="name_user" id="name_user">
          <label for="name_user">Pseudo</label>
        </p>
        <p>
          <input type="email" name="email" id="email">
          <label for="email">Email</label>
        </p>
        <p>
          <input type="password" name="password" id="password">
          <label for="password">Password</label>
        </p>
        <select name="profile" id="profile">
						<option value="expert">Expert</option>
						<option value="assistant">Assistant</option>
        </select>
        <p>
          <input type="submit" value="Enregistrer">
        </p>
    </form>
  </body>
</html>
