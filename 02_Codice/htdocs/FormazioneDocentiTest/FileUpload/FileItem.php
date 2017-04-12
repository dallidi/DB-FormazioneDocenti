<?php
  // require_once "$__ROOT__/tierData/dataModel/FileItem.php";
  require_once $_SERVER["DOCUMENT_ROOT"].
               '/FormazioneDocenti/baseUrl.php';
  
  class FileItem{
    const cUploadsDir = "C:/xampp/Uploads/FormazioneDocenti";
    
    private $id;
    private $origName;
    private $name;
    private $title;
    private $description;
    private $keywords;

    public function __construct($anOrigName)
    {
      $this->origName = $anOrigName;
      $this->id = 0;
    }
    
    public function getId(){
      return $this->id;
    }
    
    public function getOrigName(){
      return $this->origName;
    }
    
    public function getName(){
      return $this->name;
    }

    public function setName($aName){
      $this->name = $aName;
      dbgTrace("update DB", cDbgToDo);
      dbgTrace("rename file", cDbgToDo);
    }
    
    public function getUploadDir(){
      return self::cUploadsDir;
    }
    
    public function getRelPath(){
      return "/";
    }

    public function getPath(){
      return $this->getUploadDir() . $this->getRelPath();
    }
    
    public function setRelPath($aPath){
      $this->relPath = $aPath;
      dbgTrace("update DB", cDbgToDo);
      dbgTrace("move file", cDbgToDo);
    }

    public function getTitle(){
      return $this->Title;
    }
    
    public function setTitle($aTitle){
      $this->Title = $aTitle;
      dbgTrace("update DB", cDbgToDo);
    }

    public function getDescription(){
      return $this->Description;
    }
    
    public function setDescription($aDescription){
      $this-> = $aDescription;
      dbgTrace("update DB", cDbgToDo);
    }

    public function getKeywords(){
      return $this->Keywords;
    }
    
    public function setKeywords($aKeywords){
      $this->Keywords = $aKeywords;
      dbgTrace("update DB", cDbgToDo);
    }

    public function save(){
      dbgTrace("update DB", cDbgToDo);
      $this->id = 1; // TO DO set id according to DB.
    }
  }
  
  class DocCorsoFile extends FileItem{
    const cFileNameSep = '_';
    private $idCorso;
    
    public function __construct($anOrigName)
    {
      parent::__construct($anOrigName);
      $idCorso = 0;
    }
    
    public function setIdCorso($idCorso){
      $this->idCorso = $idCorso;
      $this->setName($this->makeName());
    }

    public function getRelPath(){
      return "/Corsi/";
    }
    
    private function makeName(){
      $fileName = $this->idCorso . self::cFileNameSep .
                  "Doc" . self::cFileNameSep .
                  $this->getId();
    }
  }

  class DocFreqFile extends FileItem{
    const cFileNameSep = '_';
    private $idFreq;
    private $idFileType;
    
    public function __construct($anOrigName)
    {
      parent::__construct($anOrigName);
      $idFreq = 0;
      $idFileType = 0;
    }
    
    public function setIdFreq($idFreq){
      $this->idFreq = $idFreq;
      $this->setName($this->makeName());
    }

    public function setIdFileType($idFileType){
      $this->idFileType = $idFileType;
      $this->setName($this->makeName());
    }

    public function getRelPath(){
      return "/Frequenze/";
    }
    
    private function makeName(){
      $fileName = $this->idCorso . self::cFileNameSep .
                  "Doc" . self::cFileNameSep .
                  $this->getId();
    }
  }

?>