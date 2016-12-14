<?php require $_SERVER["DOCUMENT_ROOT"]."/FormazioneDocenti/head.php" ?>
<body>
<div>
  <?php require "$__ROOT__/intestazione.php" ?>
  <div class="row centro col-12">
    <?php
       $classOption["all"] = "enable";  // all -> entire list
       require "$__ROOT__/navigation.php" 
    ?>
    <div id="pageHtml" class="col-8">
    <!-- ADD YOUR CODE HERE ----------------------------------------------------->
      <?php 
        $msgClass = "notifySuccess"; 
        $msg = "Registrazione effettuata con successo!";
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
          if (isset($_GET["errorTxt"])){
            $msgClass = "notifyError"; 
            $msg = $_GET["errorTxt"];
          }
        }
      ?>
      <div class="<?php echo $msgClass ?>">
        <?php echo $msg; ?>
      </div>

    <!-- END OF CUSTOM PAGE CODE ------------------------------------------------>
    </div>
  </div>
  <div class="row pie col-12">
    <?php require "$__ROOT__/footer.php" ?>
  </div>
</div>
</body>
</html>
