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
    $docenti = array();
    Docente::LoadDbData($docenti);
  } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = 0;
    if (isset($_POST["action"])){
      if ($_POST["action"] == "find"){
        $query = $_POST["findQuery"];
        $docenti = array();
        Docente::LoadDbData($docenti, null, $query, $query, $query, $query,
                            "Cognome");
      }
    }
    if (isset($_POST["idDocente"])){
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
    <div id="pageHtml" class="col-10">
    <!-- ADD YOUR CUSTOM PAGE CODE HERE --------------------------------------->
    <?php
      require "$__ROOT__/nav/gestioneDocente/formDati.php";
      require "$__ROOT__/nav/gestioneDocente/formTrova.php";

    ?>
    <!-- END OF CUSTOM PAGE CODE ---------------------------------------------->
    </div>
  </div>
  <div class="row pie col-12">
    <?php require "$__ROOT__/footer.php" ?>
  </div>
</div>
</body>
</html>
