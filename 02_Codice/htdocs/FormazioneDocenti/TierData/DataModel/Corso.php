<?php 
  require_once "$__ROOT__/tierData/DataModel/Docente.php";
  
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
  }
  
  class Corso {
    public $Id;
    public $Sigla;
    public $Titolo;
    public $Descrizione;
    public $Tema;
    public $PtrDescrizione;
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
      $this->PtrDescrizione = "";
      $this->Ambito->ambitoNil();
      $this->Organizzatore->organizzatoreNil();
      $this->CreatoDa->docenteNil();
    }
    
    public function __construct()
    {
      $this->Ambito = new Ambito;
      $this->Organizzatore = new Organizzatore;
      $this->CreatoDa = new Docente;
      $this->corsoNil();
    }
    
    public static function Create($Id, $Sigla, $Titolo, $Descrizione, $Tema, 
                                  $PtrDescrizione, $Ambito, $Organizzatore,
                                  $CreatoDa)
    {
      $instance = new self();
      $instance->Id = $Id;
      $instance->Sigla = $Sigla;
      $instance->Titolo = $Titolo;
      $instance->Descrizione = $Descrizione;
      $instance->Tema = $Tema;
      $instance->PtrDescrizione = $PtrDescrizione;
      $instance->Ambito = $Ambito;
      $instance->Organizzatore = $Organizzatore;
      $instance->CreatoDa = $CreatoDa;
      return $instance;
    }

  }
    
?>