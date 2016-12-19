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
        Docente::loadDbData($listaDocenti);
        arrayToHtmlTable($listaDocenti);
        $nextCid = ($listaDocenti[count($listaDocenti)-1]->Cid)+1;
        unset($listaDocenti);
        
        $doc = Docente::Create(
               $nextCid, "DocNome".$nextCid, "DocCognome01", "Doc01",
               DateTime::createFromFormat("j.m.Y", "01.09.2017"), 
               DateTime::createFromFormat("j.m.Y", "31.08.2021"), 
               Address::Create("Via Doc", "01", "8001", "Loc01"),
               ContactMeans::Create("+41 79 800 80 01",
                                    "docNome01.docCognome01@abc.ch"));
                                 
        $doc->storeData();
                                  
        $listaDocenti = array();
        Docente::loadDbData($listaDocenti);
        arrayToHtmlTable($listaDocenti);
        unset($listaDocenti);

        $doc->Nome = $doc->Nome . "(mod)";
        $doc->Cognome = $doc->Cognome . "(mod)";
        $doc->storeData();
        
        $listaDocenti = array();
        Docente::loadDbData($listaDocenti);
        arrayToHtmlTable($listaDocenti);
        unset($listaDocenti);
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