<?php
  // require_once "$__ROOT__/tierData/DataModel/Sede.php";
  class Sede {
    public $Id;
    public $Sigla;
    public $Descrizione;
    
    public function __construct()
    {
    }

    public function __toString(){
      return $this->Id . ", " . $this->Sigla . ", " . $this->Descrizione;
    }
   
    public static function Create($id, $sigla, $descr)
    {
      $instance = new self();
      $instance->Id = $id;
      $instance->Sigla = $sigla;
      $instance->Descrizione = $descr;
      return $instance;
    }
  }
?>