<?php 
  class Address {
    public $Via;
    public $ViaNo;
    public $Nap;
    public $Localita;
    
    public function __construct()
    {
      $this->Via = "";
      $this->ViaNo = "";
      $this->Nap = "";
      $this->Localita ="";
    }
    
    public static function Create($Via, $ViaNo, $Nap, $Localita)
    {
      $instance = new self();
      $instance->Via = $Via;
      $instance->ViaNo = $ViaNo;
      $instance->Nap = $Nap;
      $instance->Localita = $Localita;
      return $instance;
    }
  }
  
  class ContactMeans {
    public $Tel;
    public $Email;
    
    public function __construct()
    {
      $this->Tel = "";
      $this->Email = "";
    }
    
    public static function Create($Tel, $Email)
    {
      $instance = new self();
      $instance->Tel = $Tel;
      $instance->Email = $Email;
      return $instance;
    }
  }
  
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
    
    public function docenteNil()
    {
      $this->Id = 0;
      $this->Cid = 0;
      $this->Nome = "";
      $this->Cognome = "";
      $this->Sigla ="";
      $this->InizioQ = date("Y");
      $this->FineQ = date("Y") + 4;
      $this->Indirizzo = new Address;
      $this->Contatto = new ContactMeans;
      $this->LastUpdate = date("d.m.Y");
    }

    public function __construct()
    {
      $this->docenteNil();
    }
    
    public static function Create($Id, $Cid, $Nome, $Cognome, $Sigla, $InizioQ, 
                                  $FineQ , $Via, $ViaNo, $Nap, $Localita , $Tel,
                                  $Email)
    {
      $instance = new self();
      $instance->Id = $Id;
      $instance->Cid = $Cid;
      $instance->Nome = $Nome;
      $instance->Cognome = $Cognome;
      $instance->Sigla = $Sigla;
      $instance->InizioQ = $InizioQ;
      $instance->FineQ = $FineQ;
      $instance->Indirizzo->Via = $Via;
      $instance->Indirizzo->ViaNo = $ViaNo;
      $instance->Indirizzo->Nap = $Nap;
      $instance->Indirizzo->Localita = $Localita;
      $instance->Contatto->Tel = $Tel;
      $instance->Contatto->Email = $Email;
      $instance->LastUpdate = date("d.m.Y");
      return $instance;
    }

    public function fullName(){
      return $this->Cognome . " " . $this->Nome;
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