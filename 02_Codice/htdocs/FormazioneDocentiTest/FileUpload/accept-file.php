<?php
  require_once 'Debug.php';
  
  function checkFileType(&$errorTxt){
    $allowed = ['application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 
                'application/pdf'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['descrCorso']['tmp_name']);
    dbgTrace("$mime");
    if (!in_array($mime, $allowed)){
      $errorTxt = "Tipo file non valido";
      return false;
    }
    return true;
  }
  function checkFileValidity(&$errorTxt){
    if (!$_FILES['descrCorso']['name']){
      $errorTxt = "Caricamento file fallito";
      return false;
    }
    if($_FILES['descrCorso']['error']){
      $errorTxt = "Errore di connessione";
      return false;
    }
    if($_FILES['descrCorso']['size'] > (10*1024*1024)){
      $errorTxt = "File troppo grande";
      return false;
    }
    if (!checkFileType($errorTxt)){
      return false;
    }
    return true;
  }
  
  function makeUploadFilename($prefix, $idCorso, $origName){
    $ext = pathinfo($origName, PATHINFO_EXTENSION);
    $filename = $prefix.'_'.$idCorso.'_'.date("Ymd").'.'.$ext;
    return $filename;
  }
  
  $message = "File caricato con successo";
  if (checkFileValidity($message)){
    $new_file_name = makeUploadFilename('Test', 1, $_FILES['descrCorso']['name']); 
    if (move_uploaded_file($_FILES['descrCorso']['tmp_name'], 'c:/temp/uploads/'.$new_file_name)){
      dbgTrace($_FILES['descrCorso']['name'] . " ricevuto e rinominato " . $new_file_name);
      header("Location: /FormazioneDocentiTest/FileUpload/FileUploadResult.php?result=OK");
    } else {
      dbgTrace("Error moving ".$_FILES['descrCorso']['name'] . " to " . $new_file_name);
      header("Location: /FormazioneDocentiTest/FileUpload/FileUploadResult.php?result=Error moving file.");
    }
  }else{
    header("Location: /FormazioneDocentiTest/FileUpload/FileUploadResult.php?result=$message");
    writeUserError($message);
  }
  
?>