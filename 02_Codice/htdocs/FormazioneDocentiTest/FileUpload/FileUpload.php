<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Prove</title>
<meta charset="utf-16">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="style\cptbe.css">
<script>

</script>
</head>
<body>

<div>
  <div class="row intestazione col-12">
    <h1>File upload</h1>
  </div>
  <div class="row centro col-12">
    <form action="accept-file.php" method="post" enctype="multipart/form-data">
      Descrizione corso: <input type="file" name="descrCorso" size="25" />
      <input type="submit" name="submit" value="Submit" />
    </form>
  </div>
  <div class="row pie col-12">
  <p>(c)Davide Allidi</p>
  </div>
</div>

</body>
</html>