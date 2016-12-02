<?php require "head.php" ?>

<?php 
  $doc = new Docente();
  if (isset($_SESSION["userInfo"])){
    $doc = $_SESSION["userInfo"]->Docente;
  }
?>

<body>
<div>
  <?php require "intestazione.php" ?>
  <div class="row centro col-12">
    <?php
       $classOption["all"] = "enable";  // all -> entire list
       $classOption["profiloDocente"] = "selected";
       require "navigation.php" 
    ?>
    <div id="pageHtml" class="col-8">
    <!-- ADD YOUR CODE HERE ----------------------------------------------------->
      <div>
        <form action="GestioneDocente_action.php"
              method="post">
          
          <?php require_once $_SERVER["DOCUMENT_ROOT"].'/FormazioneDocenti/DatiDocente.php' ?>

          <hr>

          <button type="submit" name="action" value="update">Aggiorna</button>
          <input type="hidden" name="idDocente" value="<?php echo $doc->Id ?>">
       </form>
      </div>
      <div>
        <p class="updateInfo">Ultimo aggiornamento: <?php echo $doc->LastUpdate?></p>
      </div>
    <!-- END OF CUSTOM PAGE CODE ------------------------------------------------>
    </div>
  </div>
  <div class="row pie col-12">
    <?php require "footer.php" ?>
  </div>
</div>
</body>
</html>
