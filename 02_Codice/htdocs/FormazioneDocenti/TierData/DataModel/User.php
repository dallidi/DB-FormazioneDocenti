<?php 
  require_once $_SERVER["DOCUMENT_ROOT"].'/FormazioneDocenti/TierData/DataModel/Docente.php';
  
  class Group {
    public $Id;
    public $Descrizione;
    
    public function groupNil()
    {
      $this->Id = 0;
      $this->Descrizione = "";
    }

    public function __construct()
    {
      $this->groupNil();
    }
    
    public static function Create($Id, $Descrizione)
    {
      $instance = new self();
      $instance->Id = $Id;
      $instance->Descrizione = $Descrizione;
      return $instance;
    }
  }
  
  class User {
    public $Id;
    public $UserName;
    public $Group;
    public $LastLogin;
    public $Docente;
    
    public function userNil()
    {
      $this->Id = 0;
      $this->UserName = "";
      $this->Group = new Group();
      $this->Docente = new Docente();
      $this->setLastLogin();
    }

    public function __construct()
    {
      $this->userNil();
    }
    
    public static function Create($Id, $UserName, $Group, $Docente)
    {
      $instance = new self();
      $instance->Id = $Id;
      $instance->UserName = $UserName;
      $instance->Group = $Group;
      $instance->Docente = $Docente;
      $instance->SetLastLogin();
      return $instance;
    }
    
    public function setLastLogin(){
      $this->LastLogin = date("d.m.Y H:i:s");
    }
  }
  
  function compUserName($a, $b)
  {
    if ($a == $b){
      return 0;
    }elseif ($a < $b){
      return -1;
    }
    return 1;
  }
  
?>