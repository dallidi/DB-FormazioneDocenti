<?php require $_SERVER["DOCUMENT_ROOT"]."/FormazioneDocenti/head.php" ?>

<?php
  require_once "$__ROOT__/tierData/DataModel/Corso.php";
  if (!checkMinAccess(1)){
    internalRedirectTo("/nav/autenticazione/NoAccess.php");
  }
  
  $idCorso = 0;
  $corso = new Corso;
  $inputErrors = array();
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["idCorso"])){
      $idCorso = $_GET["idCorso"];
    }
    if ($idCorso != 0){
      Corso::getById($idCorso, $corso);
    }
  }elseif($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["action"])){
      if ($_POST["action"] == "aggiorna"){
        if (isset($_POST["idCorso"])){
          Corso::getById($_POST["idCorso"], $corso);
          saveCorso($corso, $inputErrors, false);
        }else{
          internalRedirectTo("/corsoRegistrato.php?errorTxt=Id corso non pervenuto!");
        }
      }
      if ($_POST["action"] == "inserisci"){
        $corso->CreatoDa = $_SESSION["userInfo"]->Docente->Id;
        saveCorso($corso, $inputErrors, true);
      }
    }
  }
  
  function saveCorso(&$corso, &$inputErrors, $insert){
    global $db;

    if (isset($_POST["titolo"])){
      $corso->Titolo = $_POST["titolo"];
    }
    if (isset($_POST["sigla"])){
      $corso->Sigla = $_POST["sigla"];
    }
    if (isset($_POST["descrizione"])){
      $corso->Descrizione = $_POST["descrizione"];
    }
    if (isset($_POST["tema"])){
      $corso->Tema = $_POST["tema"];
    }
    $sql = "";
    if ($insert)
    {
      $sql = "INSERT INTO Corsi (titolo, sigla, descrizione, tema, 
                                 ptrDescrizione, Docenti_idDocente, lastUpdate,
                                 Ambiti_idAmbito, Organizzatori_idOrganizzatore)
              VALUES('".$corso->Titolo."', 
                     '".$corso->Sigla."', 
                     '".$corso->Descrizione."', 
                     '".$corso->Tema."', 
                     '".$corso->PtrDescrizione."', 
                     '".$corso->CreatoDa."', 
                     NOW(), 1, 1);";
    }else{
      $sql = "UPDATE Corsi 
              SET titolo='".$corso->Titolo."', 
                  sigla='".$corso->Sigla."', 
                  descrizione='".$corso->Descrizione."', 
                  tema='".$corso->Tema."', 
                  ptrDescrizione='".$corso->PtrDescrizione."', 
                  lastUpdate=NOW()
              WHERE idCorso=". $corso->Id;
    }
    if ($db->exec($sql) == 1){
      internalRedirectTo("/corsoRegistrato.php");
    }else{
      internalRedirectTo("/corsoRegistrato.php?errorTxt=Errore di registrazione!");
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
      <p>Mdifica corso</p>
      <form action="modificaCorso.php" method="POST">
        <table class="leftAlign" style="padding-bottom: 0">
          <tbody>
            <tr>
              <th>Sigla</th>
              <th>Titolo</th>
              <th>Tema</th>
            </tr>
            <tr>
              <td><input class="sigla" type="text" name="sigla" value="<?php echo $corso->Sigla ?>"/></td>
              <td><input class="titolo" type="text" name="titolo" value="<?php echo $corso->Titolo?>"/></td>
              <td><input class="tema" type="text" name="tema" value="<?php echo $corso->Tema ?>"></td>
            </tr>
            <tr>
              <th colspan="3">Descrizione</th>
            </tr>
            <tr>
              <td colspan="3"><textarea name="descrizione"><?php echo $corso->Descrizione ?></textarea></td>
            </tr>
          <tbody>
        </table>
        <hr>
        <button type="submit" name="action" value="aggiorna">Aggiorna</button>
        <button type="submit" name="action" value="inserisci">Inserisci nuovo</button>
        <input type="hidden" name="idCorso" value="<?php echo $corso->Id ?>">
      </form>
      <?php 
      ?>

    <!-- END OF CUSTOM PAGE CODE ------------------------------------------------>
    </div>
  </div>
  <div class="row pie col-12">
    <?php require "$__ROOT__/footer.php" ?>
  </div>
</div>
</body>
</html>
