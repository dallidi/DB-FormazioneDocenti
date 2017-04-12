<?php
  // require_once "$__ROOT__/helpers/fileUpload/acceptFile.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php"; 
  require_once "$__ROOT__/helpers/CustomException.php";
  require_once "$__ROOT__/helpers/Debug.php";
  require_once "$__ROOT__/tierData/dbInterface/DbFile.php";

  try{
    
    $dbFiles = array();
    $ids = array(intval($_GET['fileId']));
    DbFile::loadDbData($dbFiles, $ids);
    $dbFile = reset($dbFiles);
    $url = $dbFile->Location->path();
    $origName = $dbFile->Name;

    if (file_exists($url)) {
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename="'.$origName.'"');
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($url));
      readfile($url);
    }
  } catch (CustomException $e) {
    header("Location: ".$_POST["resultUrl"]."?result=".$e->getUserMessage());
  } catch (Exception $e) {
    header("Location: ".$_POST["resultUrl"]."?result=Errore sconosciuto!");
  }
  
?>