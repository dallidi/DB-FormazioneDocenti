<?php 
  require $_SERVER["DOCUMENT_ROOT"]."/FormazioneDocenti/head.php"; 
  require_once "$__ROOT__/TierData/DataModel/config.php";
  function arrayToHtmlTable($anArray)
  {
    echo "<table>
          <thead>
            <tr>
              <th>Key</th>
              <th></th>
            </tr>
          </thead>
          <tbody>";
    foreach ($anArray as $key => $value) {
      echo "<tr>
              <td>$key</td>
              <td>".$value->xy."</td>
            </tr>";
    }
    echo "</tbody>
          </table>";    
  }
?>
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
        $parList = array();
        Config::loadDbData($parList);
        arrayToHtmlTable($parList);
      ?>
    <!-- END OF CUSTOM PAGE CODE ------------------------------------------------>
    </div>
     <?php
       $classOption["all"] = "disabled";  // all -> entire list
       require "$__ROOT__/functions.php" 
    ?>
 </div>
  <div class="row pie col-12">
    <?php require "$__ROOT__/footer.php" ?>
  </div>
</div>
</body>
</html>