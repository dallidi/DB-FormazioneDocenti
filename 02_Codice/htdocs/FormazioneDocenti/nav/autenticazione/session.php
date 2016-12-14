<?php
  require_once $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php"; 
  require_once "$__ROOT__/tierData/DbInterface/CommonDB.php";
  require_once "$__ROOT__/tierData/DataModel/User.php";

  if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $db = connectDB();
  }
  if(isset($_SESSION['userInfo'])){
    $user_check=$_SESSION['userInfo'];
    $sql = "SELECT nomeUtente
            FROM Utenti 
            WHERE nomeUtente='$user_check->UserName'";
    $results = $db->query($sql);
    if (!($row = $results->fetch()))
    {
      internalRedirectTo("/nav/autenticazione/authentication.php?errorTxt=bla bla"); 
    }
  }else{
      internalRedirectTo("/nav/autenticazione/authentication.php"); 
  }
    
  function checkMinAccess($usrGrp)
  {
    if (isset($_SESSION['userInfo'])){
      $usr = $_SESSION['userInfo'];
      $grp = $usr->Group->Id;
      return $usr->Group->Id <= $usrGrp;
    }
    return false;
  }
  
  function isSelf($id){
    $usr = $_SESSION['userInfo'];
    return $usr->Docente->Id == $id;
  }
  
  function sessionIdDocente(){
    if (isset($_SESSION['userInfo'])){
       $usr = $_SESSION['userInfo'];
       return $usr->Docente->Id;
    }
    return 0;
  }
?>