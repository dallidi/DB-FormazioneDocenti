<?php 
  
  class Frequenza {
    public $Id;
    public $Docente;
    public $Corso;
    public $Inizio;
    public $Fine;
    public $Contingente;
    public $NonContingente;
    public $PtrAttestato;
    public $PtrRapporto;
    public $Rapporto;
    
    public function frequenzaNil(){
      $this->Id = 0;
      $this->Docente->docenteNil();
      $this->Corso->corsoNil();
      $this->Inizio = date("d.m.Y");
      $this->Fine = date("d.m.Y");
      $this->Contingente = 0;
      $this->NonContingente = 0;
      $this->PtrAttestato = "";
      $this->PtrRapporto = "";
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
      $instance->PtrAttestato = $PtrAttestato;
      $instance->PtrRapporto = $PtrRapporto;
      $instance->Rapporto = $Rapporto;
      return $instance;
    }

  }
    
?>