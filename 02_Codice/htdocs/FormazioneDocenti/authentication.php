<?php
  if(isset($_SESSION['userInfo'])){
    header("Location: /FormazioneDocenti/welcome.php");
  }
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $errorTxt = "";
    if (isset($_GET["errorTxt"])){
      $errorTxt = $_GET["errorTxt"];
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Formazione Docenti</title>
  <meta charset="utf-16">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style\cptbe.css">
  <script>
  </script>
</head>

<body>
<div>
  <?php require "intestazione.php" ?>
  <div class="row centro col-12">
    <?php 
       $classOption["all"] = "disabled";
       require "navigation.php" ?>
    <div id="pageHtml" class="col-8">
      <form action="TierLogic/login/login.php" method="post">
        <label>Nome utente :</label>
        <input id="name" name="username" placeholder="username" type="text">
        <label>Password :</label>
        <input id="password" name="password" placeholder="**********" type="password">
        <input name="submit" type="submit" value=" Login ">
      </form>
      <b><?php echo $errorTxt; ?></b>
    </div>
  </div>
  <div class="row pie col-12">
    <?php require "footer.php" ?>
  </div>
</div>
</body>
</html>
