<?php 
  
  class Frequenza {
    public $Id;
    public $Docente;
    public $Corso;
    public $Inizio;
    public $Fine;
    public $Contingente;
    public $NonContingente;
    public $Documenti;
    public $Rapporto;
    
    const RICHIESTA       = "RICHIESTA";
    const APPROVAZIONE    = "APPROVAZIONE";
    const ISCRIZIONE      = "ISCRIZIONE";
    const CONFERMA        = "CONFERMA";
    const CERTIFICATO     = "CERTIFICATO";
    const GIUSTIFICAZIONE = "GIUSTIFICAZIONE";
    const RAPPORTO        = "RAPPORTO";
    
    public function frequenzaNil(){
      $this->Id = 0;
      // TO DEL $this->Docente->docenteNil();
      $this->Corso->corsoNil();
      $this->Inizio = date("d.m.Y");
      $this->Fine = date("d.m.Y");
      $this->Contingente = 0;
      $this->NonContingente = 0;
      $this->Documenti = array();
      $this->Rapporto = "";
      
    }

    public function __construct()
    {
      $this->Docente = new Docente;
      $this->Corso = new Corso;
      $this->frequenzaNil();
    }
    
    public static function Create($Id, $Docente, $Corso, $Inizio, $Fine, 
                                  $Contingente, $NonContingente, $PtrAttestato,
                                  $PtrRapporto, $Rapporto)
    {
      $instance = new self();
      $instance->Id = $Id;
      $instance->Docente = $Docente;
      $instance->Corso = $Corso;
      $instance->Inizio = $Inizio;
      $instance->Fine = $Fine;
      $instance->Contingente = $Contingente;
      $instance->NonContingente = $NonContingente;
      $instance->Documenti = $PtrAttestato;
      $instance->Rapporto = $Rapporto;
      return $instance;
    }
    
    public static function updateDoc($cat, $doc){
      
    }

    public function setRichiesta($doc){
      updateDoc(RICHIESTA, $doc);
    }

    public function setApprovazione(){
      updateDoc(APPROVAZIONE, $doc);
    }
    
    public function setIscrizione(){
      updateDoc(ISCRIZIONE, $doc);
    }
    
    public function setConferma(){
      updateDoc(CONFERMA, $doc);
    }
    
    public function setCertificato(){
      updateDoc(CERTIFICATO, $doc);
    }
    
    public function setGiustificazione(){
      updateDoc(GIUSTIFICAZIONE, $doc);
    }
    
    public static function getById($idFrequenza, &$frequenza){
      global $db;

      $sql = "SELECT * 
              FROM Frequenze
              WHERE idFrequenza=$idFrequenza";
      $rows = $db->query($sql);
      if ($r = $rows->fetch()){
        $frequenza->Id = $r["idFrequenza"];
        getDocenteById($r["Docenti_idDocente"], $frequenza->Docente);
        Corso::getById($r["Corsi_idCorso"], $frequenza->Corso);
        $frequenza->Inizio = date_create_from_format("Y-m-d", $r["inizio"]);
        $frequenza->Fine = date_create_from_format("Y-m-d", $r["fine"]);
        $frequenza->Contingente = intval($r["mgInContingente"])/2;
        $frequenza->NonContingente = intVal($r["mgNonContingente"])/2;
        // TO DO $frequenza->PtrAttestato = $r["ptrAttestato"];
        // TO DO $frequenza->PtrRapporto = $r["ptrRapporto"];
        $frequenza->Rapporto = $r["rapporto"];
      }
    }
    

  }
    
?>