<?php  
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
  require_once $_SERVER["DOCUMENT_ROOT"].'/FormazioneDocenti/TierData/DbInterface/CommonDB.php';
  require_once $_SERVER["DOCUMENT_ROOT"].'/FormazioneDocenti/TierData/DataModel/User.php';

  $errorTxt='Nome utente o password errati!'; 
  if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        header('Location: /FormazioneDocenti/authentication.php?errorTxt='.$errorTxt);
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

      $db = connectDB();
      $sql = "SELECT * FROM Utenti 
              WHERE nomeUtente='$username' AND pwd='$password'";
      $result = $db->query($sql);
      if ($row = $result->fetch()) {
        $usr = new User();
        $group = new Group();
        $docente = new Docente();
        $usr->UserName = $row['nomeUtente'];
        getGroupById($db, $row['Gruppi_idGruppo'], $group);
        $usr->Group = $group;
        getDocenteById($db, $row['Docenti_idDocente'], $docente);
        $usr->Docente = $docente;
        $usr->setLastLogin();
        $_SESSION['userInfo']=$usr; // Initializing Session
        header("Location: /FormazioneDocenti/home.php"); // Redirecting To Other Page
      } else {
        header('Location: /FormazioneDocenti/authentication.php?errorTxt='.$errorTxt);
      }
      disconnectDB($db);
    }
  }
?>