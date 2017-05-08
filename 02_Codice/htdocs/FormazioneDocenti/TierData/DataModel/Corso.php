<?php 
  require_once "$__ROOT__/tierData/DataModel/Docente.php";
  require_once "$__ROOT__/tierData/dbInterface/DbFile.php";
  
  class Ambito {
    public $Id;
    public $Descrizione;
    
    public function ambitoNil()
    {
      $this->Id = 0;
      $this->Descrizione = "";
    }
    
    public function __construct()
    {
      $this->ambitoNil();
    }
    
    public static function Create($Id, $Descrizione)
    {
      $instance = new self();
      $instance->Id = $Id;
      $instance->Descrizione = $Descrizione;
      return $instance;
    }
    
    public static function getById($idAmbito, &$ambito){
     global $db;
     
     $sql = "SELECT * 
              FROM Ambiti
              WHERE idAmbito=$idAmbito";
      $rows = $db->query($sql);
      if ($r = $rows->fetch()){
        $ambito->Descrizione = $r["descrizione"];
      }
    }
  }
  
  class Organizzatore {
    public $Id;
    public $Nome;
    
    public function organizzatoreNil(){
      $this->Id = "";
      $this->Nome = "";
    }
    
    public function __construct()
    {
      $this->organizzatoreNil();
    }
    
    public static function Create($Id, $Nome)
    {
      $instance = new self();
      $instance->Id = $Id;
      $instance->Nome = $Nome;
      return $instance;
    }
    
    public static function getById($idOrganizzatore, 
                                                &$organizzatore){
      global $db;

      $sql = "SELECT * 
              FROM Organizzatori
              WHERE idOrganizzatore=$idOrganizzatore";
      $rows = $db->query($sql);
      if ($r = $rows->fetch()){
        $organizzatore->Nome = $r["nome"];
      }
    }
  }
  
  class Corso {
    public $Id;
    public $Sigla;
    public $Titolo;
    public $Descrizione;
    public $Tema;
    public $Doc;
    public $Ambito;
    public $Organizzatore;
    public $CreatoDa;

    public function corsoNil()
    {
      $this->Id = 0;
      $this->Sigla = "";
      $this->Titolo = "";
      $this->Descrizione = "";
      $this->Tema ="";
      $this->Ambito->ambitoNil();
      $this->Organizzatore->organizzatoreNil();
    }
    
    private function getDoc(){
      global $db;
      
      $idCorso = $this->Id;
      $sql = "SELECT *
              FROM DocCorsi
              WHERE Corsi_idCorso = $idCorso";
      dbgTrace($sql);
      $rows = $db->query($sql);
      $fpIds = array();
      while ($r = $rows->fetch())
      {
        $fpIds[] = intval($r["FilePointers_idFilePointers"]);
      }
      if (count($fpIds) > 0){
        DbFile::loadDbData($this->Doc, $fpIds);
      }
   }
    
    public function __construct()
    {
      $this->Ambito = new Ambito;
      $this->Organizzatore = new Organizzatore;
      $this->CreatoDa = new Docente;
      $this->Doc = array();
      $this->corsoNil();
    }
    
    public static function Create($Id, $Sigla, $Titolo, $Descrizione, $Tema,
                                  $Ambito, $Organizzatore, $CreatoDa)
    {
      $instance = new self();
      $instance->Id = $Id;
      $instance->Sigla = $Sigla;
      $instance->Titolo = $Titolo;
      $instance->Descrizione = $Descrizione;
      $instance->Tema = $Tema;
      $instance->Ambito = $Ambito;
      $instance->Organizzatore = $Organizzatore;
      $instance->CreatoDa = $CreatoDa;
      return $instance;
    }
    
    public static function getById($idCorso, &$corso){
      global $db;

      $sql = "SELECT * 
              FROM Corsi
              WHERE IdCorso=$idCorso";
      $rows = $db->query($sql);
      if ($r = $rows->fetch()){
        $corso->Id = $r["idCorso"];
        $corso->Sigla = $r["sigla"];
        $corso->Titolo = $r["titolo"];
        $corso->Descrizione = $r["descrizione"];
        $corso->Tema = $r["tema"];
        Ambito::getById($r["Ambiti_idAmbito"], $corso->Ambito);
        Organizzatore::getById($r["Organizzatori_idOrganizzatore"], 
                               $corso->Organizzatore);
        $corso->getDoc();
      }
    }
  }
  
?>