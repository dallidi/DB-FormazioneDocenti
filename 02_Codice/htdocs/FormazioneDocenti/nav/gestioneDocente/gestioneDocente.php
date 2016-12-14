<?php require $_SERVER["DOCUMENT_ROOT"]."/FormazioneDocenti/head.php" ?>

<?php
  require_once "$__ROOT__/tierData/DbInterface/CommonDB.php";
  require_once "$__ROOT__/tierData/DataModel/Docente.php";
  if (!checkMinAccess(1)){
    internalRedirectTo("/nav/autenticazione/NoAccess.php");
  }

  $doc = new Docente();
  $id = 0;
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["ID"])){
      $id = $_GET["ID"];
      getDocenteById($id, $doc);
    }
  }

?>

<body>
<div>
  <?php require "$__ROOT__/intestazione.php" ?>
  <div class="row centro col-12">
    <?php
       $classOption["all"] = "enable";  // all -> entire list
       $classOption["gestioneDocenti"] = "selected";
       require "$__ROOT__/navigation.php" 
    ?>
    <div id="pageHtml" class="col-8">
    <!-- ADD YOUR CUSTOM PAGE CODE HERE ----------------------------------------->
      <form action="gestioneDocente_action.php"
            method="post">
        <table class="leftAlign">
          <tr>
            <th class="center" colspan="2">Quadriennio</th>
          </tr>
          <tr>
            <th class="center">Inizio</th><th class="center">Fine</th><th>Settore</th>
          </tr>
          <tr>
            <td>
              <select  name="inizioQ">
                <?php
                  for ($i=2016; $i<=2036; $i++) {
                    echo '<option value="'.$i.' "';
                    if ($i == (int)sqlToPhpDate($doc->InizioQ, "Y")){
                      echo 'selected';
                    }
                    echo '>'.$i.'</option>';
                  }
                  ?>
              </select> 
            </td>
            <td>
              <select  name="fineQ">
                <?php
                  for ($i=2020; $i<=2040; $i++) {
                    echo '<option value="'.$i.' "';
                    if ($i == (int)sqlToPhpDate($doc->FineQ, "Y")){
                      echo 'selected';
                    }
                    echo '>'.$i.'</option>';
                  }
                  ?>
              </select> 
            </td>
            <td><input type="text" name="settore" value="<?php echo '' ?>" size="50"></td>
          </tr>
        </table>

        <hr>
        
        <?php require_once "$__ROOT__/helpers/datiDocente.php" ?>

        <hr>

        <button type="submit" name="action" value="find">Trova</button>
        <input type="text" name="findQuery" placeholder="termine di ricerca">
        <button type="submit" name="action" value="update">Aggiorna</button>
        <button type="submit" name="action" value="freeze">Blocca</button>
        <button type="submit" name="action" value="archive">Archivia</button>
        <input type="hidden" name="idDocente" value="<?php echo $doc->$id ?>">
        <input type="hidden" name="subPage" value="GestioneDocente.php">
        
      </form>
     <!-- END OF CUSTOM PAGE CODE ------------------------------------------------>
    </div>
  </div>
  <div class="row pie col-12">
    <?php require "$__ROOT__/footer.php" ?>
  </div>
</div>
</body>
</html>
