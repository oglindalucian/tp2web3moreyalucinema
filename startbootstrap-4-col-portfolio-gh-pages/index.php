
<!DOCTYPE html>
<html lang="fr">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Accueil Cinema Moreyalu</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/4-col-portfolio.css" rel="stylesheet">
	<script language="javascript" src="js/global.js"></script>
	<link rel="stylesheet" href="css/films.css" type="text/css" />

  </head>

  <body>

    <!-- Navigation -->
     <?php include 'menu.php';?>

    <!-- Page Content -->
    <div class="container">
	<?php

if (isset($_GET['src']) && !empty($_GET['src'])) {
		$id=$_GET['src'];
echo "<div id=\"video\">";
echo "<span onClick=\"rendreInvisible('video')\">X</span><br>";
$rep="";
	
try{
  	$rep.="<iframe width=\"975px\" height=\"550px\" src='".$id."'>	</iframe>";			
	 } catch (Exception $e){
		echo "<iframe id=\"visionnerFilm\" width=\"975px\" height=\"550px\"
					src=\"https://www.youtube.com/embed/tgbNymZ7vqY\">
				</iframe>";
	 }finally {
		echo $rep;
	 }			
echo "</div>";

}
	?>
	
	<!--les categories-->
		<div id="divEnregCateg">
			<form id="formEnregCateg" class="form-horizontal" enctype="multipart/form-data" action="serveur/gestionFilms.php" method="POST" onSubmit="return validerString('nom_categ');" >
				<h3>Enregistrer categorie</h3><br><br>
				<input type="hidden" value="enregistrerCateg" name="operation">
				<span onClick="rendreInvisible('divEnregCateg')">X</span><br>				
				<div class="form-group">
					<label class="control-label col-sm-2" for="nom_categ">Nom categorie:</label>
					<div class="col-sm-10">
						<input type="text" id="nom_categ" name="nom_categ">
					</div>
				</div>
				<div class="form-group">
				  <div class="col-sm-10">
					<input type="submit" value="Envoyer">
				  </div>
				</div>	
			</form>
		</div>
		<form id="formListerCateg" action="serveur/gestionFilms.php" method="POST">
			<input type="hidden" value="listerCateg" name="operation">
		</form>
		<div id="divEnleverCateg">
			<form id="formEnleverCateg" class="form-horizontal" action="serveur/gestionFilms.php" method="POST" onSubmit="return validerNum('numCateg');">
				<h3>Enlever categorie</h3><br><br>
				<input type="hidden" value="enleverCateg" name="operation">
				<span onClick="rendreInvisible('divEnleverCateg')">X</span><br>
				<div class="form-group">
				  <label class="control-label col-sm-2" for="numCateg">Numero categorie:</label>
				  <div class="col-sm-10">
					<input type="text" id="numCateg" name="numCateg">
				  </div>
				  <br><br>
				</div>
				<div class="form-group">
				  <div class="col-sm-10">
					<input type="submit" value="Envoyer">
				  </div>
				</div>				
			</form>
		</div>
		<div id="divFicheCateg">
			<form id="formFicheCateg" class="form-horizontal" action="serveur/gestionFilms.php" method="POST" onSubmit="return validerNum('numCat');">
				<h3>Obtenir fiche categorie</h3><br><br>
				<input type="hidden" value="ficheCateg" name="operation">
				<span onClick="rendreInvisible('divFicheCateg')">X</span><br>
				<div class="form-group">
				  <label class="control-label col-sm-2" for="numCat">Numero categorie:</label>
				  <div class="col-sm-10">
					<input type="text" id="numCat" name="numCat">
				  </div>
				</div>
				<br><br>				
				<div class="form-group">
				  <div class="col-sm-10">
					<input type="submit" value="Envoyer">
				  </div>
				</div>
			</form>
		</div>
		
		
      
	  <!--les films-->
	  <div id="divEnreg">
			<form id="formEnreg" class="form-horizontal" enctype="multipart/form-data" action="serveur/gestionFilms.php" method="POST" onSubmit="return valider();">
				<h3>Enregistrer film</h3><br><br>
				<input type="hidden" value="enregistrer" name="operation">
				<span onClick="rendreInvisible('divEnreg')">X</span><br>				
				<div class="form-group">
					<label class="control-label col-sm-2" for="titre">Titre:</label>
					<div class="col-sm-10">
						<input type="text" id="titre" name="titre">
					</div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-2" for="res">Realisateur:</label>
				  <div class="col-sm-10">
						<input type="text" id="res" name="res">
				  </div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="categ">Catégorie:</label>
					<div class="col-sm-10">
						<input type="text" id="categ" name="categ">
					</div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-2" for="duree">Duree:</label>
				  <div class="col-sm-10">
						<input type="text" id="duree" name="duree">
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-2" for="duree">Prix:</label>
				  <div class="col-sm-10">
						<input type="text" id="prix" name="prix">
				  </div>
				</div>				
				<div class="form-group">
				  <label class="control-label col-sm-2" for="pochette">Pochette:</label>
				  <div class="col-sm-10">
					<input type="file" id="pochette" name="pochette"><br><br><br>
					<input type="submit" value="Envoyer" ><br>
				  </div>
				</div>
			</form>
		</div>
		<form id="formLister" action="serveur/gestionFilms.php" method="POST">
			<input type="hidden" value="lister" name="operation">
		</form>
		<div id="divEnlever">
			<form id="formEnlever" class="form-horizontal" action="serveur/gestionFilms.php" method="POST" onSubmit="return validerNum('numE');">
				<h3>Enlever film</h3><br><br>
				<input type="hidden" value="enlever" name="operation">
				<span onClick="rendreInvisible('divEnlever')">X</span><br>
				<div class="form-group">
				  <label class="control-label col-sm-2" for="numE">Numero:</label>
				  <div class="col-sm-10">
					<input type="text" id="numE" name="num">
				  </div>
				  <br><br>
				</div>
				<div class="form-group">
				  <div class="col-sm-10">
					<input type="submit" value="Envoyer">
				  </div>
				</div>				
			</form>
		</div>
		<div id="divFiche">
			<form id="formFiche" class="form-horizontal" action="serveur/gestionFilms.php" method="POST" onSubmit="return validerNum('numF');">
				<h3>Obtenir fiche film</h3><br><br>
				<input type="hidden" value="fiche" name="operation">
				<span onClick="rendreInvisible('divFiche')">X</span><br>
				<div class="form-group">
				  <label class="control-label col-sm-2" for="numF">Numero:</label>
				  <div class="col-sm-10">
					<input type="text" id="numF" name="num">
				  </div>
				</div>
				<br><br>				
				<div class="form-group">
				  <div class="col-sm-10">
					<input type="submit" value="Envoyer">
				  </div>
				</div>
			</form>
		</div>
		<div id="descriptionErreurs"><span onClick="rendreInvisible('descriptionErreurs')">X</span></div>

	  
	  
	  
	  <div id="lesFilms">
	  <h1 class="my-4">Bienvenu    
      </h1>
	   <div class="row">
	  <?php
	  $con=mysqli_connect("localhost","root","","bdfilms");
		if (mysqli_connect_errno()) {
				echo "Probleme de connexion au serveur de bd";
				exit();
			}	
	$rep="";
	$requette = "SELECT * FROM film";
	try{
		 $listeFilms=mysqli_query($con,$requette);
		 while($ligne=mysqli_fetch_object($listeFilms)){
			$src=($ligne->source);
			$rep.="<div class=\"col-lg-3 col-md-4 col-sm-6 portfolio-item\">";
			$rep.="<div class=\"card h-100\">";
			//$rep.="<form action=\"index.php\" method=\"GET\" >\n";
			//$rep.="<input type=\"hidden\" name=\"sourceFilm\" value='".($ligne->no_film)."'>";
			$rep.="<a href='index.php?src=".$src."' ><img class=\"card-img-top\" src='pochettes/".($ligne->pochette)."' width=160 height=80 alt=\"\"></a>";
			//$rep.="<a href='index.php?src=".$src."' ><button type=\"submit\" style=\"background-color:transparent; border-color:transparent;\"><img class=\"card-img-top\" src='pochettes/".($ligne->pochette)."' width=160 height=80 alt=\"\"></button></a>";
			//$rep.="</form>";
			$rep.="<div class=\"card-body\">";
			$rep.=" <h4 class=\"card-title\">".($ligne->titre)."</h4>";
			$rep.="<p class=\"card-text\">Realisateur: ".($ligne->realisateur)."</p>";
			$rep.="<p class=\"card-text\">Duree: ".($ligne->duree)."minutes.</p>";
			$rep.="<p class=\"card-text\">Categorie: ".($ligne->id_categ)."</p>";
			$rep.="<p class=\"card-text\">Prix: ".($ligne->prix)."</p>";
			$rep.="</div></div></div>";				 
		}		
	 mysqli_free_result($listeFilms);
	 } catch (Exception $e){
		echo "Probleme pour lister";
	 }finally {
		echo $rep;
	 mysqli_close($con);
		
	 }
	 
		
		?>
	  </div>
	   
	  
	  
	  <!-- Page Heading -->
      
     
	  
      <!-- /.row -->

      <!-- Pagination -->
      <ul class="pagination justify-content-center">
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </a>
        </li>
        <li class="page-item">
          <a class="page-link" href="index.php">1</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="index2.php">2</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">3</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
          </a>
        </li>
      </ul>
	</div> <!-- /#lesFilms -->
    </div>
    <!-- /.container -->

    <!-- Footer -->
    <?php include 'footer.php';?>
	

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
