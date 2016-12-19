<?php 
  require_once "$__ROOT__/tierData/DataModel/Address.php";
  require_once "$__ROOT__/tierData/DataModel/ContactMeans.php";
  require_once "$__ROOT__/tierData/DataModel/Sede.php";

  require_once "$__ROOT__/tierData/dbInterface/CommonDB.php";
  require_once $_SERVER["DOCUMENT_ROOT"].
               '/FormazioneDocenti/helpers/Debug.php';

              
  class Docente {
    public $Id;
    public $Cid;
    public $Nome;
    public $Cognome;
    public $Sigla;
    public $InizioQ;
    public $FineQ;
    public $Indirizzo;
    public $Contatto;
    public $LastUpdate;
    public $Sede;

    private static $orderByMap;
    
    public function __construct()
    {
      Docente::initStaticVars();
      $this->Id = 0;
      $this->InizioQ = date("Y");
      $this->FineQ = date("Y") + 4;
      $this->Indirizzo = new Address();
      $this->Contatto = new ContactMeans();
    }

    public function __toString(){
      return $this->Id . ", " . $this->Cid . ", " .
             $this->Cognome . " " . 
             $this->Nome . ", " . 
             $this->Sigla . ", " . 
             $this->InizioQ . ", " . 
             $this->FineQ . ", " . 
             $this->Indirizzo . ", " . 
             $this->Contatto . ", " . 
             $this->LastUpdate . ", " . 
             $this->Sede;
    }
   
    private static function initStaticVars(){
      if (!self::$orderByMap){
        self::$orderByMap = array();
        self::$orderByMap["Id"] = "idDocente";
        self::$orderByMap["Cid"] = "cid";
        self::$orderByMap["Nome"] = "nome";
        self::$orderByMap["Cognome"] = "cognome";
        self::$orderByMap["Sigla"] = "sigla";
        self::$orderByMap["InizioQ"] = "inizioQuadro";
        self::$orderByMap["FineQ"] = "fineQuadro";
        self::$orderByMap["LastUpdate"] = "lastUpdate";
        self::$orderByMap["Indirizzo.Via"] = "via";
        self::$orderByMap["Indirizzo.ViaNo"] = "viaNo";
        self::$orderByMap["Indirizzo.Nap"] = "nap";
        self::$orderByMap["Indirizzo.Localita"] = "localita";
        self::$orderByMap["Contatto.Tel"] = "telefono";
        self::$orderByMap["Contatto.Email"] = "email";
      }
    }
    
    public static function Create($Cid, $Nome, $Cognome, $Sigla, $InizioQ, 
                                  $FineQ , $Indirizzo , $Contatto, $Id = 0)
    {
      $instance = new self();
      $instance->Id = $Id;
      $instance->Cid = $Cid;
      $instance->Nome = $Nome;
      $instance->Cognome = $Cognome;
      $instance->Sigla = $Sigla;
      $instance->InizioQ = $InizioQ;
      $instance->FineQ = $FineQ;
      $instance->Indirizzo= $Indirizzo;
      $instance->Contatto = $Contatto;
      $instance->LastUpdate = date("d.m.Y");
      $instance->Sede = Sede::Create(1, "CPT-Be", "Centro Professionale Tecnico Bellinzona");
      return $instance;
    }
      
    public static function loadDbData(&$instances, $listIds=null, $cid="", 
                             $nome="", $cognome="",
                             $sigla="", $orderBy=""){
      global $db;
      
      $sorting = "";
      $query = "";
      addIdInList($query, $listIds, "idDocente", $sorting);
      addTxtField($query, "nome", $nome, $sorting);
      addTxtField($query, "cognome", $cognome, $sorting);
      addTxtField($query, "cid", $cid, $sorting);
      addTxtField($query, "sigla", $sigla, $sorting);
      $where = "";
      if ($query != ""){
        $where = "WHERE $query";
      }
      if ($orderBy == ""){
        $where = "$where $sorting";
      } else {
        $where = "$where ORDER BY ". self::$orderByMap[$orderBy];
      }
      $sql = "SELECT *
              FROM Docenti
              $where";
      dbgTrace($sql);
      $rows = $db->query($sql);
      while ($r = $rows->fetch())
      {
        $idDoc = $r["idDocente"];
        $indirizzo = Address::Create($r["via"], $r["viaNo"],
                                     $r["nap"], $r["localita"]);
        $contatto = ContactMeans::Create($r["telefono"], $r["email"]);
        $instances[] =
        Docente::create($r["cid"], $r["nome"], $r["cognome"], 
                        $r["sigla"], 
                        sqlToPhpDate($r["inizioQuadro"], "Y"),
                        sqlToPhpDate($r["fineQuadro"], "Y"), 
                        $indirizzo , $contatto, $idDoc);
      }
    }
    
    public function storeData(){
      global $db;
      $sql = "SELECT idDocente
              FROM Docenti
              WHERE idDocente = ".$this->Id;
      dbgTrace($sql);
      $rows = $db->query($sql);
      $count = $rows->rowCount();
      if ($count == 0 or $Id = 0){
        $this->insert();
      } else if ($count == 1){
        $this->update();
      } else {
        // Error
        dbgTrace("Query ($sql) returned $count results!", cDbgError);
      }
    }

    public function fullName(){
      return $this->Cognome . " " . $this->Nome;
    }
    
    private function insert(){
      global $db;
      $sql = "INSERT INTO Docenti
                     (cid, nome, cognome, sigla,
                      inizioQuadro, fineQuadro, lastUpdate,
                      via, viaNo, nap, localita, 
                      telefono, email, Sedi_idSede)      
              VALUES ('".
                      $this->Cid."', '".
                      $this->Nome."', '".
                      $this->Cognome."', '".
                      $this->Sigla. "', '".
                      phpDateToSql($this->InizioQ)."', '".
                      phpDateToSql($this->FineQ)."', '".
                      sqlNow()."', '".
                      $this->Indirizzo->Via."', '".
                      $this->Indirizzo->ViaNo."', '".
                      $this->Indirizzo->Nap."', '".
                      $this->Indirizzo->Localita."', '".
                      $this->Contatto->Tel."', '".
                      $this->Contatto->Email."', '".
                      $this->Sede->Id."')";
      dbgTrace($sql);
      if ($db->query($sql)){
        $this->Id = $db->lastInsertId();
      } else {
        dbgTrace("Error executing ($sql)", cDbgError);
      }
    }

    private function update()
    {
      global $db;
      $sql = "UPDATE Docenti
              SET cid='"         . $this->Cid . "',
                  nome='"        . $this->Nome . "',
                  cognome='"     . $this->Cognome . "',
                  sigla='"       . $this->Sigla . "',
                  inizioQuadro='". phpDateToSql($this->InizioQ) . "',
                  fineQuadro='"  . phpDateToSql($this->FineQ) . "',
                  lastUpdate='"  . sqlNow() . "',
                  via='"         . $this->Indirizzo->Via . "',
                  viaNo='"       . $this->Indirizzo->ViaNo . "',
                  nap='"         . $this->Indirizzo->Nap . "',
                  localita='"    . $this->Indirizzo->Localita . "',
                  telefono='"    . $this->Contatto->Tel . "',
                  email='"       . $this->Contatto->Email . "',
                  Sedi_idSede='" . $this->Sede->Id . "'
              WHERE idDocente='" . $this->Id . "'";
      dbgTrace($sql);
      if (!$db->query($sql)){
        dbgTrace("Error executing ($sql)", cDbgError);
      }
    }
  }
  
  function compFullName($a, $b)
  {
    if ($a->fullName() == $b->fullName()){
      return 0;
    }elseif ($a->fullName() < $b->fullName()){
      return -1;
    }
    return 1;
  }
  
?>