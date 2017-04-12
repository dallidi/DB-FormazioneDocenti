<?php
  // require_once "$__ROOT__/helpers/fileUpload/acceptFile.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php"; 
  require_once "$__ROOT__/helpers/CustomException.php";
  require_once "$__ROOT__/helpers/Debug.php";
  require_once "$__ROOT__/tierData/dbInterface/DbFile.php";
  
  function checkFileType(){
    $allowed = ['application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 
                'application/pdf'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['uploadFile']['tmp_name']);
    if (!in_array($mime, $allowed)){
      throw new CustomException("Tipo file non valido", "$mime not allowed");
    }
  }
  
  function checkFileValidity(){
    if (!$_FILES['uploadFile']['name']){
      throw new CustomException("Caricamento file fallito");
    }
    if($_FILES['uploadFile']['error']){
      throw new CustomException("Errore di connessione");
    }
    if($_FILES['uploadFile']['size'] > (10*1024*1024)){
      throw new CustomException("File troppo grande", 
                 "File too big, size=".$_FILES['uploadFile']['size']);
    }
    checkFileType();
  }
  
  function makeUploadFilename($prefix, $idCorso, $origName){
    $ext = pathinfo($origName, PATHINFO_EXTENSION);
    $filename = $prefix.'_'.$idCorso.'_'.date("Ymd").'.'.$ext;
    return $filename;
  }
  
  function makeUploadFilePath(){
    return 'c:/temp/uploads/';
  }
  
  function storeOnDb($origName, $newName, $newFilePath){
    dbgTrace("Saving $origName to $newFilePath$newName");
    $dbFileLocation = DbFileLocation::Create($newName, $newFilePath);
    $dbFile = DbFile::Create(0, $origName, $dbFileLocation);
    $dbFile->storeData();
  }
  
  try{
    checkFileValidity();
    $origName = $_FILES['uploadFile']['name'];
    $newFileName = makeUploadFilename('Test', 1, $origName); 
    $newFilePath = makeUploadFilePath();
    if (move_uploaded_file($_FILES['uploadFile']['tmp_name'], $newFilePath.$newFileName)){
      dbgTrace($_FILES['uploadFile']['name'] . " ricevuto e rinominato " . $newFileName);
      header("Location: ".$_POST["resultUrl"]."?result=OK");
    } else {
      dbgTrace("Error moving ".$_FILES['uploadFile']['name'] . " to " . $newFileName);
      header("Location: ".$_POST["resultUrl"]."?result=Error moving file.");
    }
    storeOnDb($origName, $newFileName, $newFilePath);
  } catch (CustomException $e) {
    header("Location: ".$_POST["resultUrl"]."?result=".$e->getUserMessage());
  } catch (Exception $e) {
    header("Location: ".$_POST["resultUrl"]."?result=Errore sconosciuto!");
  }
  
?>