<?php 
  require_once $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php"; 
  require_once "$__ROOT__/tierData/DataModel/Docente.php";
  
  $db = connectDB();

  function connectDB(){
    global $db;
    
    $servername = "localhost";
    $username = "";
    $password = "";

    try {
        $db = new PDO("mysql:host=$servername;dbname=FormazioneDocenti", $username, $password);
        // set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
      echo "Connection failed: " . $e->getMessage();
    }
    return $db;
 }
  
  function disconnectDB(){
    global $db;

    $db = null;
  }
  
  function addIdInList(&$query, $listIds, $field, &$orderBy=null){
    if (!$listIds){
      return;
    }
    // $ids = array_filter($listIds, 'is_int');
    // $idList = implode(',', $ids);
    $idList = implode(',', $listIds);
    if ($idList != ""){
      $query = "$query $field IN ($idList)";
      if (!$orderBy){
        if ($orderBy = ""){
          $orderBy = "ORDER BY $field";
        }
      }
    }
  }
  
  function addTxtField(&$query, $field, $fieldValue,
                       &$orderBy = null, $logicOpe = "OR"){
    if ($fieldValue != ""){
      if ($query != ""){
        $query = "$query $logicOpe";
      }
      $query = "$query $field LIKE '%$fieldValue%'";
      if (!$orderBy){
        if ($orderBy = ""){
          $orderBy = "ORDER BY $field";
        }
      }
    }
  }

  function addDateField(&$query, $field, $fieldValue, &$orderBy = null,
                        $logicOpe = "OR", $compOpe="="){
    
    if ($fieldValue != ""){
      if ($query != ""){
        $query = "$query $logicOpe";
      }
      $query = "$query $field $compOpe '$fieldValue'";
      if (!$orderBy){
        if ($orderBy = ""){
          $orderBy = "ORDER BY $field";
        }
      }
    }
  }

  function insertDocente($docente){
    global $db;
    
    $currDate = date("Y-m-d H:i:s");
    $sql = "INSERT INTO `Docenti`
              (cid, nome, cognome, 
               sigla, inizioQuadro, fineQadro, 
               via, viaNo,
               nap, localita, 
               telefono, email, lastUpdate)
            VALUES 
              ($docente->Cid, $docente->Nome, $docente->Cognome, 
               $docente->Sigla, $docente->InizioQ, $docente->FineQ, 
               $docente->Indirizzo->Via, $docente->Indirizzo->ViaNo, 
               $docente->Indirizzo->Nap, $docente->Indirizzo->Localita, 
               $docente->Contatto->Tel, $docente->Contatto->Email, $currDate)";
    $rows = $db->exec($sql);
  }
  
  function getDocenteById($id, &$docente){
    global $db;
    $idList = array($id);
    $instances = array();
    Docente::loadDbData($instances, $idList);
    if (count($instances) == 1){
      $docente = $instances[0];
    }
  }
  
  function getDocenteId($query){
    global $db;
    
    $query = '%' . $query . '%';
    $sql = "SELECT idDocente FROM `Docenti` 
            WHERE sigla LIKE '" . $query . "' OR 
                  cognome LIKE '" . $query . "' OR 
                  nome LIKE '" . $query . "' OR 
                  cid LIKE '" . $query ."'";
    $rows = $db->query($sql);
    if ($r = $rows->fetch()){
      return $r['idDocente'];
    } else {
      return 0;
    }
  }

  function getGroupById($idGruppo, &$group){
    global $db;

    $sql = "SELECT * 
            FROM Gruppi
            WHERE IdGruppo=$idGruppo";
    $rows = $db->query($sql);
    if ($r = $rows->fetch()){
      $group->Id = $r["idGruppo"];
      $group->Descrizione = $r["descrizione"];
    }
  }
  
  function sqlToPhpDate($sqlDate, $format){
    return date($format, strtotime($sqlDate));
  }
  
  function phpDateToSql($date){
    return date_format($date, "Y-m-d");
  }
  
  function sqlNow(){
    return date("Y-m-d H:i:s");
  }
 
  
  function convertDateFormat($dateStr, $fromFormat, $toFormat){
    return date_format(date_create_from_format($fromFormat, $dateStr), $toFormat);
  }
?>
