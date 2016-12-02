<?php
  require_once $_SERVER["DOCUMENT_ROOT"].'/FormazioneDocenti/TierData/DbInterface/CommonDB.php';
  require_once $_SERVER["DOCUMENT_ROOT"].'/FormazioneDocenti/TierData/DataModel/Docente.php';
  require_once $_SERVER["DOCUMENT_ROOT"].'/FormazioneDocenti/TierLogic/login/session.php';
  if (!checkMinAccess(1)){
    header('Location: /FormazioneDocenti/TierLogic/login/NoAccess.php');
  }
  
  function updateDocente($db){
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
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idDoc = 0;
    if (isset($_POST["action"])){
      $db = connectDB();
      if ($_POST["action"] == "find"){
        $idDoc = getDocenteId($db, $_POST["findQuery"]);
      } elseif ($_POST["action"] == "update"){
        $idDoc = updateDocente($db);
      } elseif ($_POST["action"] == "freeze"){
      } elseif ($_POST["action"] == "archive"){
      }
      disconnectDB($db);
    }
    header("Location: /FormazioneDocenti/gestioneDocente.php?&ID=".$idDoc );
  }
?>
