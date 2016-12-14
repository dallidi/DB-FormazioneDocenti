<?php require $_SERVER["DOCUMENT_ROOT"]."/FormazioneDocenti/head.php" ?>

<?php 
  $doc = new Docente();
  if (isset($_SESSION["userInfo"])){
    $doc = $_SESSION["userInfo"]->Docente;
  }
?>

<body>
<div>
  <?php require "$__ROOT__/intestazione.php" ?>
  <div class="row centro col-12">
    <?php
      $classOption["all"] = "enable";  // all -> entire list
      $classOption["profiloDocente"] = "selected";
      require "$__ROOT__/navigation.php";
    ?>
    <div id="pageHtml" class="col-8">
    <!-- ADD YOUR CODE HERE --------------------------------------------------->
      <div>
        <form action="<?php echo makeUrl("/nav/gestioneDocente/gestioneDocente_action.php");?>"
              method="post">
          
          <?php require_once "$__ROOT__/helpers/DatiDocente.php" ?>

          <hr>

          <button type="submit" name="action" value="update">Aggiorna</button>
          <input type="hidden" name="idDocente" value="<?php echo $doc->Id ?>">
          <input type="hidden" name="redirect" value="<?php echo makeUrl("/nav/profiloDocente/profiloDocente.php");?>">
       </form>
      </div>
      <div>
        <p class="updateInfo">Ultimo aggiornamento: <?php echo $doc->LastUpdate?></p>
      </div>
    <!-- END OF CUSTOM PAGE CODE ---------------------------------------------->
    </div>
  </div>
  <div class="row pie col-12">
    <?php require "$__ROOT__/footer.php" ?>
  </div>
</div>
</body>
</html>
