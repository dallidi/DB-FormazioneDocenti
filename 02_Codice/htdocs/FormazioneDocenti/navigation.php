
<?php 
  function addOpt($opt, $item){
    if (isset($opt[$item])){
      echo $opt[$item];
    }
  }
  
  if(!isset($classOption)){ $classOption = "";}

  $classOption["gestioneDocenti"] = "hidden";
  $classOption["rapporto"] = "hidden";  
  if (isset($_SESSION['userInfo'])){
    if(checkMinAccess(1)){
      $classOption["gestioneDocenti"] = "";
      $classOption["rapporto"] = "";
    }
  }
?>
  <div class="col-2">
    <ul class="verticalMenu <?php addOpt($classOption, "all") ?>">
      <li class="<?php addOpt($classOption, 'gestioneDocenti') ?>"><a href="gestioneDocente.php">Gestisci docente</a></li>
      <li class="<?php addOpt($classOption, 'profiloDocente') ?>"><a href="profiloDocente.php">Profilo</a></li>
      <li class="<?php addOpt($classOption, 'partecipazione') ?>"><a href="partecipazione.php">Mia Partecipazione</a></li>
      <li class="<?php addOpt($classOption, 'listaCorsi') ?>"><a href="listaCorsi.php">Lista corsi</a></li>
      <li class="<?php addOpt($classOption, 'rapporto') ?>"><a href="rapporto.php">Rapporto</a></li>
      <li class="<?php addOpt($classOption, 'logout') ?>"><a href="TierLogic/login/logout.php">Logout</a></li>
    </ul>     
  </div>
