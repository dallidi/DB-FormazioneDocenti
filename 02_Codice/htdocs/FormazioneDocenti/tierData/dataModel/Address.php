<?php
  // require_once "$__ROOT__/tierData/DataModel/Address.php";

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
    
     public function __toString(){
      return $this->Via . " " . $this->ViaNo . ", " . 
             $this->Nap . " "  . $this->Localita;
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
?>