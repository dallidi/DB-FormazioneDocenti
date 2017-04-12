<?php
  // require_once "$__ROOT__/helpers/fileUpload/acceptFile.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php"; 
  require_once "$__ROOT__/helpers/CustomException.php";
  require_once "$__ROOT__/helpers/Debug.php";
  require_once "$__ROOT__/tierData/dbInterface/DbFile.php";

  try{
    
    $dbFiles = array();
    // $ids = array($_POST['fileId']);
    $ids = array(intval($_GET['fileId']));
    dbgExport($ids);
    DbFile::loadDbData($dbFiles, $ids);
    dbgExport($dbFiles);
    $dbFile = reset($dbFiles);
    dbgExport($dbFile);
    $url = $dbFile->Location->path();
    $origName = $dbFile->Name;
    $content = file_get_contents($url);

    header('Content-Type: application/pdf');
    header('Content-Length: ' . strlen($content));
    header("Content-Disposition: inline; filename='$origName'");
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');
    ini_set('zlib.output_compression','0');

    die($content);    

  } catch (CustomException $e) {
    header("Location: ".$_POST["resultUrl"]."?result=".$e->getUserMessage());
  } catch (Exception $e) {
    header("Location: ".$_POST["resultUrl"]."?result=Errore sconosciuto!");
  }
  
?>