<?php require $_SERVER["DOCUMENT_ROOT"]."/FormazioneDocenti/head.php" ?>

<?php
  require_once "$__ROOT__/tierData/DbInterface/CommonDB.php";
  require_once "$__ROOT__/tierData/DataModel/Docente.php";
  require_once "$__ROOT__/tierData/DataModel/Corso.php";
  require_once "$__ROOT__/tierData/DataModel/Frequenza.php";
  
  if (!checkMinAccess(3)){
    internalRedirectTo("/nav/autenticazione/NoAccess.php");
  }
  $idDocente = $_SESSION["userInfo"]->Docente->Id;
  $frequenza = new Frequenza;
  function getData($idCorso, &$corso){
    if ($idCorso != 0){
      getCorsoById($idCorso, $corso);
    }
  }
  
  $actionValueName = ["insertPartecipazione", "Inserisci"];
  $inputErrors = array();
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["idCorso"])){
      getData($_GET["idCorso"], $frequenza->Corso);
    }
  }elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["idFrequenza"])){
      getFrequenzaById($_POST["idFrequenza"], $frequenza);
      $actionValueName = ["updatePartecipazione", "Aggiorna"];
    }else{
      if (isset($_POST["idCorso"])){
        getData($_POST["idCorso"], $frequenza->Corso);
      }
      if (isset($_POST["idDocente"])){
        $idDocente = $_POST["idDocente"];
      }
    }
    if (isset($_POST["action"])){
      if ($_POST["action"] == "insertPartecipazione"){
        savePartecipazione($idDocente, $frequenza, $inputErrors, true);
      }elseif($_POST["action"] == "updatePartecipazione"){
        savePartecipazione($idDocente, $frequenza, $inputErrors, false);
      }
    }
  }
  
  function checkPostedDate($name, &$inputErrors){
    $result = false;
    if (isset($_POST[$name])){
      $result = date_create_from_format("d.m.Y", $_POST[$name]);
    }else{
      $inputErrors += [$name => "invalid"];
    }
    if ($result < date_create_from_format("d.m.Y", "01.01.2015")){
      $inputErrors += [$name => "invalid"];
    }
    return $result;
  }

  function checkPostedNum($name, &$inputErrors){
    $result = false;
    if (isset($_POST[$name])){
      $result = $_POST[$name];
    }else{
      $inputErrors += [$name => "invalid"];
    }
    return $result;
  }
  
  function setIfError($name, &$inputErrors){
    if (isset($inputErrors[$name]))
    {
      return $inputErrors[$name];
    }
    return "";
  }
  
  function getOldValue($name, $default){
    if (isset($_POST[$name])){
      $result = $_POST[$name];
    }else{
      $result = $default;
    }
    return $result;
  }
  
  function savePartecipazione($idDocente, $frequenza, &$inputErrors, $insert){
    global $db;

    $errText = "";
    if (($idDocente == 0) || ($frequenza->Corso->Id == 0)){ 
      $idCorso = $frequenza->Corso->Id;
      internalRedirectTo("/nav/partecipazione/partecipazioneRegistrata.php?errorTxt=Id non validi $idDocente $idCorso");
      return;
    }
    
    if (!checkMinAccess(1)){
      $idDocente = sessionIdDocente();
    }

    $inizio = checkPostedDate("inizio", $inputErrors);
    $fine = checkPostedDate("fine", $inputErrors);
    if ($inizio < date_create_from_format("d.m.Y", "01.01.2015") &&
        !isset($inputErrors["inizio"])){
      $inputErrors += ["inizio" => "invalid"];
    }
    if ($fine < $inizio){
      if (!isset($inputErrors["inizio"])){
        $inputErrors += ["inizio" => "invalid"];
      }
      if (!isset($inputErrors["fine"])){
        $inputErrors += ["fine" => "invalid"];
      }
    }
    $inCont = checkPostedNum("mgInContingente", $inputErrors)*2;
    $nonCont = checkPostedNum("mgNonContingente", $inputErrors)*2;
    if ($inCont == 0 && $nonCont == 0){
      $inputErrors += ["mgInContingente" => "invalid", "mgNonContingente" => "invalid"];
    }
    if (count($inputErrors) != 0){
      return;
    }
    $sql = "";
    if ($insert)
    {
      $sql = "INSERT INTO Frequenze (Docenti_idDocente, Corsi_idCorso, 
                                     inizio, fine, 
                                     mgInContingente, mgNonContingente,
                                     lastUpdate)
              VALUES($idDocente, ".$frequenza->Corso->Id.",
                     '".phpDateToSql($inizio)."',
                     '".phpDateToSql($fine)."',
                     ".$inCont.",
                     ".$nonCont.",
                     NOW());";
    }else{
      $sql = "UPDATE Frequenze 
              SET Docenti_idDocente=$idDocente, 
                  Corsi_idCorso=". $frequenza->Corso->Id .", 
                  inizio='".phpDateToSql($inizio)."', 
                  fine='".phpDateToSql($fine)."', 
                  mgInContingente=$inCont, 
                  mgNonContingente=$nonCont,
                  lastUpdate=NOW()
              WHERE idFrequenza=". $frequenza->Id;
    }
    if ($db->exec($sql) == 1){
      internalRedirectTo("/nav/partecipazione/partecipazioneRegistrata.php");
    }else{
      internalRedirectTo("/nav/partecipazione/partecipazioneRegistrata.php?errorTxt=Errore di registrazione!");
    }
  }
?>

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
      <div class="subpage">
        <div class="row centro col-12">
          <form action="partecipaCorso.php"
                method="post">
             <table class="leftAlign" style="padding-bottom: 0">
              <tr>
                <th>Sigla</th>
                <th>Tema</th>
                <th>Titolo</th>
              </tr>
              <tr>
                <td><?php echo (isset($_POST["idFrequenza"])) ? $frequenza->Corso->Sigla : $frequenza->Corso->Sigla ?></td>
                <td><?php echo (isset($_POST["idFrequenza"])) ? $frequenza->Corso->Tema : $frequenza->Corso->Tema ?></td>
                <td><?php echo (isset($_POST["idFrequenza"])) ? $frequenza->Corso->Titolo : $frequenza->Corso->Titolo ?> </td>
              </tr>
              <tr>
                <th colspan="3">Descrizione</th>
              </tr>
              <tr>
                <td colspan="3"><?php echo (isset($_POST["idFrequenza"])) ? $frequenza->Corso->Descrizione : $frequenza->Corso->Descrizione ?></td>
              </tr>
            </table>
            <hr>

             <table class="leftAlign" style="padding-bottom: 0">
              <tr>
                <th>Inizio</th><th>Fine</th>
              </tr>
              <tr>
                <td><input class="<?php echo setIfError("inizio", $inputErrors)?>" 
                           type="text" name="inizio" placeholder="gg.mm.aaaa"
                           value="<?php echo (isset($_POST["idFrequenza"])) ? date_format($frequenza->Inizio, "d.m.Y") : getOldValue("inizio", "") ?>"></td>
                <td><input class="<?php echo setIfError("fine", $inputErrors)?>" 
                           type="text" name="fine" placeholder="gg.mm.aaaa"
                           value="<?php echo (isset($_POST["idFrequenza"])) ? date_format($frequenza->Fine, "d.m.Y") : getOldValue("fine", "") ?>"></td>
              </tr>
              <tr>
                <th>In contingente [g]</th><th>Fuori contingente [g]</th>
              </tr>
              <tr>
                <td><input class="<?php setIfError("mgInContingente", $inputErrors)?>"
                           type="number" name="mgInContingente" min="0" step="0.5"
                           value="<?php echo (isset($_POST["idFrequenza"])) ? $frequenza->Contingente : getOldValue("mgInContingente", "0") ?>" size="2"></td>
                <td><input class="<?php setIfError("mgNonContingente", $inputErrors)?>" 
                           type="number" name="mgNonContingente" min="0" step="0.5" 
                           value="<?php echo (isset($_POST["idFrequenza"])) ? $frequenza->NonContingente : getOldValue("mgNonContingente", "0") ?>" size="2"></td>
              </tr>
            </table>

            <hr>

            <button type="submit" name="action" value="<?php echo $actionValueName[0] ?>"><?php echo $actionValueName[1] ?></button>
            <input type="hidden" name="idDocente" value="<?php echo $idDocente ?>">
            <input type="hidden" name="idCorso" value="<?php echo $frequenza->Corso->Id ?>">
            <?php 
              if(isset($_POST["idFrequenza"])){
                echo '<input type="hidden" name="idFrequenza" value="'.$frequenza->Id.'">';
              }
            ?>
          </form>
        </div>
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
