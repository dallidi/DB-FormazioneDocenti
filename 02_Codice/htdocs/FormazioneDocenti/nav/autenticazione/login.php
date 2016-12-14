<?php  
  require_once $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php"; 
  require_once "$__ROOT__/tierData/DbInterface/CommonDB.php";

  if (session_status() == PHP_SESSION_NONE) {
    session_start();
    connectDB();
  }
  require_once "$__ROOT__/tierData/DataModel/User.php";

  $errorTxt='Nome utente o password errati!'; 
  if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        internalRedirectTo("/nav/autenticazione/authentication.php?errorTxt=$errorTxt");
    }
    else
    {
      // Define $username and $password
      $username=$_POST['username'];
      $password=$_POST['password'];

      // To protect MySQL injection for Security purpose
      $username = stripslashes($username);
      $password = stripslashes($password);
      $username = mysql_real_escape_string($username);
      $password = mysql_real_escape_string($password);

      $sql = "SELECT * FROM Utenti 
              WHERE nomeUtente='$username' AND pwd='$password'";
      $result = $db->query($sql);
      if ($row = $result->fetch()) {
        $usr = new User();
        $group = new Group();
        $docente = new Docente();
        $usr->UserName = $row['nomeUtente'];
        getGroupById($row['Gruppi_idGruppo'], $group);
        $usr->Group = $group;
        getDocenteById($row['Docenti_idDocente'], $docente);
        $usr->Docente = $docente;
        $usr->setLastLogin();
        $_SESSION['userInfo']=$usr; // Initializing Session
        internalRedirectTo("/home.php"); 
      } else {
        internalRedirectTo("/nav/autenticazione/authentication.php?errorTxt=$errorTxt");
      }
    }
  }
?>