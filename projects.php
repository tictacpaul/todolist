<?php

session_start();

//afk security
if (empty($_SESSION['id'])) {
  header('Location : index.php');
}

$title = "TDL - Mes projets";
require 'header.php';
require 'db.php';

 ?>

<!-- display breadcrumb -->
<nav aria-label="breadcrumb" class="breadMargin pl-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Mes Projets</li>
  </ol>
</nav>

<!-- list of differents projects -->
<div class="container-fluid py-5">
  <div class="row">
    <div class="col-md-9 borderFormRight mx-auto">
      <p class="colTitle text-center">Mes projets</p>
      <div class="row mx-auto">

    <?php

      //getting all projects link to this particular user account
      $req = $bdd->prepare('SELECT id, name, DATE_FORMAT(deadline, "%d/%m/%Y") AS deadlinebis FROM projects WHERE id_user = :id_user');
      $req->execute(array(
        'id_user' => $_SESSION['id']
      ));
      $projects = $req->fetchAll();

      //displaying each project with its name/deadline and a link to its particular list of lists
      foreach ($projects as $project) {

        ?>

        <div class="col-md-4 col-sm-6">
          <div class="postit mt-3">
            <a href="deleteproject.php?id=<?= $project['id'] ?>" class="delete">X</a>
            <p><?= $project['name'] ?></p>
            <p class="datesize"> <?= $project['deadlinebis'] ?></p>
            <a href="lists.php?id=<?= $project['id'] ?>" class="text-center"><button type="button" class="btn btn-warning">Détails</button></a>
          </div>
        </div>
        <?php
      }
     ?>
     </div>
   </div>
   <!-- end of projectlist -->

  <!-- addProjectForm -->
   <div class="col-md-3 borderFormLeft d-flex flex-column pb-3">

     <p class="colTitle text-center">Ajouter un projet</p>

     <div class="postitadd mx-auto mt-3">

       <form class="" action="addproject.php" method="post">
         <div class="form-group">
           <label for="exampleInputName">Nom du Projet</label>
           <input type="text" class="form-control" id="exampleInputName" name="name" placeholder="Faire mon évaluation" required>
         </div>
         <div class="form-group">
           <label for="exampleFormControlTextarea1">Description</label>
           <textarea class="form-control" id="exampleFormControlTextarea1" name="description" rows="3" required></textarea>
         </div>
         <div class="form-group">
           <label for="exampleFormControlDate">DeadLine</label>
           <input type="date" name="date" id="exampleFormControlDate" min="<?= $date=date("Y-m-d") ?>" value="<?= $date ?>" required>
         </div>

         <button type="submit" name="addProject" class="btn btn-warning">Nouveau projet</button>

       </form>

     </div>

   </div>
   <!-- end of addPostIt col -->
  </div>
  <!-- end of row -->
</div>
<!-- end of container -->



<?php
require 'footer.php';
 ?>
