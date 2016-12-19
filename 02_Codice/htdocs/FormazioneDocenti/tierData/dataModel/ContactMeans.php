<?php
  // require_once "$__ROOT__/tierData/DataModel/ContactMeans.php";
  class ContactMeans {
    public $Tel;
    public $Email;
    
    public function __construct()
    {
    }

    public function __toString(){
      return $this->Tel . ", " . $this->Email;
    }
   
    public static function Create($Tel, $Email)
    {
      $instance = new self();
      $instance->Tel = $Tel;
      $instance->Email = $Email;
      return $instance;
    }
  }
?>