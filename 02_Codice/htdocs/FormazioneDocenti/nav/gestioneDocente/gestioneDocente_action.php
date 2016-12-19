<?php
  require_once $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php"; 
  require_once "$__ROOT__/tierData/DbInterface/CommonDB.php";
  require_once "$__ROOT__/tierData/DataModel/Docente.php";
  require_once "$__ROOT__/nav/autenticazione/session.php";
  // if (!checkMinAccess(1)){
    // internalRedirectTo("/nav/autenticazione/NoAccess.php");
  // }
  
  function updateDocente(){
    global $db;

    $id = $_POST['idDocente'];
    if ($id == 0){
      $sql = "INSERT INTO Docenti (sigla, cognome, nome, cid, viaNo, via, nap,
                                   localita, telefono, email, lastUpdate)
              VALUES('" . $_POST['sigla'] . "',
                     '" . $_POST['cognome'] . "',
                     '" . $_POST['nome'] . "',
                      " . $_POST['cid'] . ",
                     '" . $_POST['viaNo'] . "',
                     '" . $_POST['via'] . "',
                     '" . $_POST['nap'] . "',
                     '" . $_POST['localita'] . "',
                     '" . $_POST['telefono'] . "',
                     '" . $_POST['email'] . "',
                     NOW());";
      $db->exec($sql);
      // $id = $db->query('SELECT LAST_INSERT_ID() as docId')->fetch()["docId"];
    }else{
       $sql = "UPDATE Docenti 
               SET sigla='"    . $_POST['sigla'] . "',
                   cognome='"  . $_POST['cognome'] . "',
                   nome='"     . $_POST['nome'] . "',
                   cid="       . $_POST['cid'] . ",
                   viaNo='"    . $_POST['viaNo'] . "',
                   via='"      . $_POST['via'] . "',
                   nap='"      . $_POST['nap'] . "',
                   localita='" . $_POST['localita'] . "',
                   telefono='" . $_POST['telefono'] . "',
                   email='"    . $_POST['email'] . "',
                   lastUpdate=NOW()
              WHERE idDocente=" . $id . ";";
      $db->exec($sql);
   }
    return $id; 
  }
?>

<?php 
  require_once $_SERVER["DOCUMENT_ROOT"].
               '/FormazioneDocenti/helpers/Debug.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    dbgTrace("Computing POST");
    $idDoc = 0;
    if (isset($_POST["action"])){
      if ($_POST["action"] == "find"){
        $idDoc = getDocenteId($_POST["findQuery"]);
      } elseif ($_POST["action"] == "update"){
        dbgTrace("Computing updateDocente");
        $idDoc = updateDocente();
        getDocenteById($idDoc, $doc);
        dbgTrace("Docente = $doc");
        $_SESSION['userInfo']->Docente = $doc;
      } elseif ($_POST["action"] == "freeze"){
      } elseif ($_POST["action"] == "archive"){
      }
    }
    if (isset($_POST["redirect"]))
    {
      dbgTrace("Redirecting to ".$_POST["redirect"]);
      header("Location: ".$_POST["redirect"]);
    } else {
      dbgTrace("Redirecting to /nav/gestioneDocente/gestioneDocente.php?ID=$idDoc");
      internalRedirectTo("/nav/gestioneDocente/gestioneDocente.php?ID=$idDoc");
    }
  }
?>
