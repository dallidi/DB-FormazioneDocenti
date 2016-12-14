<?php 
  require_once "$__ROOT__/tierData/dbInterface/CommonDB.php";
  
  class ConfigPar {
    public $id;
    public $Name;
    public $Type;
    public $Data;
    
    public function __construct()
    {
    }
    
    public static function Create($Id, $Name, $Type, $Data)
    {
      $instance = new self();
      $instance->Id = $Id;
      $instance->Name = $Name;
      $instance->Type = $Type;
      $instance->Data = $Data;
      return $instance;
    }
    public static function LoadDbData(&$config, $name="", $type="")
    {
      $config
    }
  }
    
?>