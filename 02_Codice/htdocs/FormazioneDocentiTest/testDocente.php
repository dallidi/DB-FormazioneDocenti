<?php 
  require $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php";
  require_once "$__ROOT__/TierData/DataModel/Docente.php";
  
  connectDB();

  function arrayToHtmlTable($anArray)
  {
    echo "<table>
          <thead>
            <tr>
              <th>Key</th>
              <th>Value</th>
            </tr>
          </thead>
          <tbody>";
    foreach ($anArray as $key => $value) {
      echo "<tr>
              <td>$key</td>
              <td>$value</td>
            </tr>";
    }
    echo "</tbody>
          </table>";    
  }
?>
<head>
<title>Formazione Docenti Test</title>
<meta charset="utf-16">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo makeUrl("/style/cptbe.css");?>">
<script>
</script>
</head>
<body>
<div>
  <?php require "$__ROOT__/intestazione.php" ?>
  <div class="row centro col-12">
    <?php
       $classOption["all"] = "enable";  // all -> entire list
       $classOption["testPage"] = "selected";
       require "$__ROOT__/navigation.php" 
    ?>
    <div id="pageHtml" class="col-8">
    <!-- ADD YOUR CODE HERE ----------------------------------------------------->
      <?php 
        $listaDocenti = array();
        Docente::loadDbData($listaDocenti, array(1, 2));
        arrayToHtmlTable($listaDocenti);
        unset($listaDocenti);
        $listaDocenti = array();
        Docente::loadDbData($listaDocenti, array(1, 2), "99901");
        arrayToHtmlTable($listaDocenti);
        unset($listaDocenti);
        $listaDocenti = array();
        Docente::loadDbData($listaDocenti, array(1, 2), "99901", "04");
        arrayToHtmlTable($listaDocenti);
        unset($listaDocenti);
        $listaDocenti = array();
        Docente::loadDbData($listaDocenti, array(1, 2), "99901", "04", "05");
        arrayToHtmlTable($listaDocenti);
        unset($listaDocenti);
        $listaDocenti = array();
        Docente::loadDbData($listaDocenti, array(1, 2), "99901", "04", "05",
                                           "03", "Id");
        arrayToHtmlTable($listaDocenti);
        unset($listaDocenti);
        $listaDocenti = array();
        Docente::loadDbData($listaDocenti, array(1, 2), "99901", "04", "05",
                                           "03", "Indirizzo.Nap");
        arrayToHtmlTable($listaDocenti);
        unset($listaDocenti);
        $listaDocenti = array();
        Docente::loadDbData($listaDocenti, array(1, 2), "99901", "04", "05",
                                           "03", "Contatto.Tel");
        arrayToHtmlTable($listaDocenti);
        // loadDbData(&$listaDocenti, $listIds=null, $cid="", 
                             // $nome="", $cognome="",
                             // $sigla="", $inizioQ="", $fineQ="",
                             // $orderBy="")        
        unset($listaDocenti);
        $listaDocenti = array();
        Docente::loadDbData($listaDocenti);
        arrayToHtmlTable($listaDocenti);
      ?>
    <!-- END OF CUSTOM PAGE CODE ------------------------------------------------>
    </div>
 </div>
  <div class="row pie col-12">
    <?php require "$__ROOT__/footer.php" ?>
  </div>
</div>
</body>
</html>

<?php disconnectDB(); ?>