<?php
  try{
	//Connexion à mysql
	  $db = new PDO('mysql:host=localhost;dbname=todolist;charset=utf8', 'root', 'root');
  }
  catch(Exception $e){
	// Si erreur, stop le script
        die('Erreur : '.$e->getMessage());
  }

//données à faire
$todo=$_POST["tache"];
$todosanitized=filter_var($todo,FILTER_SANITIZE_STRING);
if (isset($_POST["ajouter"]) AND isset($_POST['tache'])){
  $db->exec('INSERT INTO todolist (Ajouter, Fait) VALUES ("'.$todosanitized.'",0)');
}

if(isset($_POST["done"])){
    foreach($_POST["A_faire"] as $key => $value){
      $db->query('UPDATE todolist SET Fait=1 WHERE ID="'.$value.'"');
    }
  }

// données faites
$tododb=$db->query('SELECT * FROM todolist WHERE Fait=0');
 $data=$tododb->fetchAll(PDO::FETCH_ASSOC);
  if(!empty($todosanitized) && isset($todosanitized)){
    $db->query('INSERT INTO Ajouter (tache, fait) VALUES ("'.$todosanitized.'","0")');
    }

  if(isset($_POST["delete"])) {
    foreach($_POST["Done"] as $key => $value){
          $db->query('DELETE FROM todolist WHERE ID="'.$value.'"');
  }
}

//données archivées
  $done=$db->query('SELECT * FROM todolist WHERE Fait=1');
    $datadone=$done->fetchAll(PDO::FETCH_ASSOC);
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css?family=Mukta+Malar" rel="stylesheet">
<title>TO-DO LIST</title>
</head>
<body>
  <div class="page">
    <h1>TO DO LIST </h1>
    <section class="tache">
      <h2>Ajouter une tâche</h2>
        <form class="" action="index.php" method="post">
          <input type="text" name="tache" value="">
          <input type="submit" name="ajouter" value="Ajouter">
        </form>
    </section>
  <div class="listes">
    <h2>A faire</h2>
      <section class="afaire">
        <form action="index.php" method="post" name="formafaire">
          <?php
            foreach ($data as $key => $value) {
              ?>
              <label class="afaire"> <input type="checkbox" name="A_faire[]" value="<?=$value['ID']?>"> </label> <?= $value['Ajouter'] ?><br/>
              <?php
            }
          ?>
          <input type="submit" name="done" value="Fait">
        </form>
    </section>

      <h2>Fait</h2>
        <section class="archive">
          <form action="index.php" method="post" name="formchecked">
            <div class="fait">
              <?php
              foreach ($datadone as $key => $value) {
              ?>
                <label class="fait"> <input type="checkbox" name="Done[]" value="<?=$value['ID']?>" checked></label> <?= $value['Ajouter'] ?><br/>
              <?php
              }
            ?>
            <input type="submit" name="delete" value="Supprimer">
          </div>
        </form>
    </section>
  </div>
  </div>
</body>
</html>
