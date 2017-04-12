<?php
  // require_once "$__ROOT__/helpers/fileUpload/fileUpload.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php"; 

  $action = makeUrl("/helpers/fileUpload/acceptFile.php");
  $resultUrl = makeUrl("/helpers/fileUpload/fileUpload.php");
  $hidden = "hidden";
  $result = "";
  if (isset($_GET["result"])){
    $result = $_GET["result"];
    $hidden = "";
  }
?>
<div>
  <form action="<?php echo $action; ?>" method="POST" 
        enctype="multipart/form-data">
    <input type="file" name="uploadFile" size="25" value="carica"/>
    <input type="submit" name="submit" value="Submit" />
    <input type="hidden" name="resultUrl" value="<?php echo $resultUrl; ?>"/>
  </form>
  <?php echo "<p $hidden>$result</p>"; ?>
</div>
