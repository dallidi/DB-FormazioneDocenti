<?php
  require_once $_SERVER["DOCUMENT_ROOT"].'/FormazioneDocenti/TierData/DbInterface/CommonDB.php';
  require_once $_SERVER["DOCUMENT_ROOT"].'/FormazioneDocenti/TierData/DataModel/User.php';

  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  if(isset($_SESSION['userInfo'])){
    $user_check=$_SESSION['userInfo'];
    $sql = "SELECT nomeUtente
            FROM Utenti 
            WHERE nomeUtente='$user_check->UserName'";
    $db = connectDB();
    $results = $db->query($sql);
    if (!($row = $results->fetch()))
    {
      header('Location: /FormazioneDocenti/authentication.php?errorTxt=bla bla'); 
    }
    disconnectDB($db);
  }else{
      header('Location: /FormazioneDocenti/authentication.php'); 
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
  
  function sessionIdDocente(){
    if (isset($_SESSION['userInfo'])){
       $usr = $_SESSION['userInfo'];
       return $usr->Docente->Id;
    }
    return 0;
  }
?>