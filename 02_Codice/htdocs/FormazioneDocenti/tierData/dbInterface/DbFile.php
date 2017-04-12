<?php
  // require_once "$__ROOT__/tierData/dbInterface/DbFile.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php"; 
  require_once "$__ROOT__/tierData/dbInterface/CommonDB.php";

  class DbFileLocation{
    public $Name;
    public $RelPath;

    public static function create($Name, $RelPath)
    {
      $instance = new self();
      $instance->Name = $Name;
      $instance->RelPath = $RelPath;
      return $instance;
    }
    
    public function path(){
      return $this->RelPath.$this->Name;
    }
  }

  class DbFile {
    public $Id;
    public $Name;
    public $Location;
    public $Title;
    public $Description;
    public $Keywords;
    
    public function __construct()
    {
      
    }
    
    public static function create($Id, $Name, $Location,
                                  $Title = "", $Description = "", $Keywords = "")
    {
      $instance = new self();
      $instance->Id = $Id;
      $instance->Name = $Name;
      $instance->Location = $Location;
      $instance->Title = $Title;
      $instance->Description = $Description;
      $instance->Keywords = $Keywords;
      return $instance;
    }

    public static function loadDbData(&$instances, $idFiles = array(),
                                      $nomeOrig = "")
    {
      global $db;
      
      $db = connectDB();

      dbgExport($idFiles);
      $ids = array_filter($idFiles, 'is_int');
      dbgExport($ids);

      $sorting = "";
      $query = "";
      addIdInList($query, $ids, "idFilePointer", $sorting);
      addTxtField($query, "origFileName", $nomeOrig, $sorting);
      $where = "";
      if ($query != "")
      {
        $where = "WHERE $query";
      }
      $sql = "SELECT *
              FROM FilePointers
              $where";
      dbgTrace($sql);
      $rows = $db->query($sql);
      while ($r = $rows->fetch()){
        $id = $r["idFilePointer"];
        $instances[$id] = 
          DbFile::Create($id,
                         $r["origFileName"],
                         DbFileLocation::Create($r["fileName"], 
                                                $r["fileRelPath"]),
                         $r["title"],
                         $r["description"],
                         $r["keywords"]);
      }
    }

    public function storeData(){
      global $db;

      $sql = "SELECT idFilePointer
              FROM FilePointers
              WHERE idFilePointer = ".$this->Id;
      dbgTrace($sql);
      $rows = $db->query($sql);
      $count = $rows->rowCount();
      if ($count == 0 or $Id = 0){
        $this->insert();
      } else if ($count == 1){
        $this->update();
      } else {
        // Error
        dbgTrace("Query ($sql) returned $count results!", cDbgError);
      }
    }

    private function insert(){
      global $db;
      $sql = "INSERT INTO FilePointers
                     (origFileName, fileName, fileRelPath,
                      title, description, keywords)      
              VALUES ('".
                      $this->Name."', '".
                      $this->Location->Name."', '".
                      $this->Location->RelPath."', '".
                      $this->Title. "', '".
                      $this->Description. "', '".
                      $this->Keywords. "')";
      dbgTrace($sql);
      if ($db->query($sql)){
        $this->Id = $db->lastInsertId();
      } else {
        dbgTrace("Error executing ($sql)", cDbgError);
      }
    }

    private function update()
    {
      global $db;
      $sql = "UPDATE FilePointers
              SET origFileName='"    . $this->NameCid . "',
                  fileName='"        . $this->Location->Name . "',
                  fileRelPath='"     . $this->Location->RelPath . "',
                  title='"           . $this->Title . "',
                  description='"     . $this->Description . "',
                  keywords='"        . $this->Keywords . "'
              WHERE idFilePointer='" . $this->Id . "'";
      dbgTrace($sql);
      if (!$db->query($sql)){
        dbgTrace("Error executing ($sql)", cDbgError);
      }
    }
    
  }
?>