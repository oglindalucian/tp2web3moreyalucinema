<?php
	session_start();
	
	$nom=$prenom=$courriel=$mdp=""; $age=16;
	//1
	if(@$_SESSION["CourrielUtilConnecte"]===null)
		@$_SESSION["CourrielUtilConnecte"] = "";
	if(@$_SESSION["confirmAdmin"]===null)
		@$_SESSION["confirmAdmin"] = "false";
	if(@$_SESSION["messagePourUtilisateur"]===null)
		@$_SESSION["messagePourUtilisateur"] = "";
	if(@$_SESSION["panier"]===null)
		@$_SESSION["panier"] = "";
	
	
		$con=mysqli_connect("localhost","root","","bdfilms");
if (mysqli_connect_errno()) {
		//echo "Probleme de connexion au serveur de bd";
		//exit();
	}

$courriel=$_SESSION["CourrielUtilConnecte"];
	//-----
try{
	if($courriel!=="") {
		$requette = "SELECT * FROM utilisateur WHERE courriel = ?";   
		$stmt = $con->prepare($requette);
		$stmt->bind_param("s", $courriel);
		$stmt->execute();
		$result = $stmt->get_result();
		if(!$ligne = $result->fetch_object()){
			//$_SESSION["messagePourUtilisateur"] =  "Courriel inexistent!";
			//echo "Courriel inexistent!";
			mysqli_close($con);
			//exit;
		}
		else {
				//$_SESSION["NomUtilConnecte"] = $ligne->nom;
				$nom=$ligne->nom;
				//$_SESSION["PrenomUtilConnecte"] = $ligne->prenom;
				$prenom=$ligne->prenom;
				//$_SESSION["AgeUtilConnecte"] = $ligne->age;
				$age=$ligne->age;			
			}
			mysqli_free_result($result);
		//-----	
			
		$requette = "SELECT * FROM connexion WHERE courriel = ?";   
		$stmt = $con->prepare($requette);
		$stmt->bind_param("s", $courriel);
		$stmt->execute();
		$result = $stmt->get_result();
		if(!$ligne = $result->fetch_object()){
			//$_SESSION["messagePourUtilisateur"] =  "Courriel inexistent!";
			//echo "Courriel inexistent!";
			mysqli_close($con);
			//exit;
		}
		else {
				//$_SESSION["MDPUtilConnecte"] = $ligne->mdp;
				$mdp=$ligne->mdp;
				
				//$_SESSION["ConfirmationUtilConnecte"] = $ligne->mdp;					
			}
			mysqli_free_result($result);
			
		//-----	
			
			mysqli_close($con);
	}
} catch(Exception $e) {}	
			
?>

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
	
	<!--<script language="javascript" src="vendor/bootstrap/js/bootstrap.js"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="css/films.css" type="text/css" />
	
 
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  </head>

  <body onLoad="creerElementsListes();">

    <!-- Navigation -->
     <?php include 'menu.php';?>

    <!-- Page Content -->
    <div class="container">
	
	<?php

if (isset($_GET['src']) && !empty($_GET['src'])) {
		$id=$_GET['src'];

echo "<div id=\"video\">";
//echo "<span onClick=\"rendreInvisible('video')\">X</span><br>";
echo "<button type=\"button\" class=\"close\" aria-label=\"Close\" onClick=\"rendreInvisible('video')\">";
echo "<span aria-hidden=\"true\">&times;</span></button>";

$rep="";
	
try{
  	$rep.="<iframe width=\"975px\" height=\"550px\" src='".$id."'>	</iframe>";	
	//$rep.="	<video width=\"975px\" height=\"550px\" controls> <source src='".$id."' type=\"video/mp4\"> Your browser does not support HTML5 video. </video>	";
	//$rep.="<video src='".$id."' controls=\"true\"></video>";
	 } catch (Exception $e){
		echo "<iframe id=\"visionnerFilm\" width=\"975px\" height=\"550px\"
					src=\"https://www.youtube.com/embed/tgbNymZ7vqY\">
				</iframe>";
	 }finally {
		echo $rep;
	 }			
echo "</div>";

} else {
	// echo "<div id=\"video\">";
	// echo "<span onClick=\"rendreInvisible('video')\">X</span><br>";
	// echo "Desole! Le film n'est pas encore disponible.";
	// echo "</div>";
	}
	?>
	
	
	<!--connexion-->
		<div id="connexion">
			<form id="formEnregCateg" class="form-horizontal" enctype="multipart/form-data" action="serveur/gestionMembres.php" method="POST" onSubmit="return validerConnexion();" >
				<!--<h3>Connexion</h3><br><br>-->
				<input type="hidden" value="connexion" name="operation">
				<nav class="navbar navbar-inverse" style="width:30%;">
					<div class="container-fluid">
						<div class="navbar-header">
						<a class="navbar-brand" href="#">Connexion</a>
						</div>
						<ul class="nav navbar-nav navbar-right">
						  <li class="active"><a href="#" onClick="rendreInvisible('connexion')">
						  <button type="button" class="close" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						  </a></li>
						</ul>
					  </div>
					</nav>
				<!--<span onClick="rendreInvisible('connexion')">X</span><br>-->				
				<div class="form-group">
					<label class="control-label col-sm-2" for="courriel">Courriel:</label>
					<div class="col-sm-10">
						<input type="text" id="courriel" name="courriel">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="mdp">Mot de passe:</label>
					<div class="col-sm-10">
						<input type="text" id="mdp" name="mdp">
					</div>
				</div>
				<div class="form-group">
				  <div class="col-sm-10">
					<input type="submit" value="Envoyer">
				  </div>
				</div>	
			</form>
			<p><a href="#" onClick="rendreInvisible('connexion'); rendreVisible('inscription'); rendreInvisible('divEnreg'); rendreInvisible('lesFilms'); rendreInvisible('divFiche'); rendreInvisible('divEnlever'); rendreInvisible('foot'); rendreInvisible('divFicheCateg'); rendreInvisible('divEnregCateg'); rendreInvisible('divEnleverCateg'); rendreInvisible('descriptionErreurs');">Pas encore inscrit?</a></p>

		</div>
		
		<!--inscription-->
		<div id="inscription">
			<form id="formEnregCateg" class="form-horizontal" enctype="multipart/form-data" action="serveur/gestionMembres.php" method="POST" onSubmit="return validerInscription();" >
				<!--<h3>Inscription</h3><br><br>-->
				<input type="hidden" value="inscription" name="operation">
				<nav class="navbar navbar-inverse" style="width:30%;">
					<div class="container-fluid">
						<div class="navbar-header">
						<a class="navbar-brand" href="#">Inscription</a>
						</div>
						<ul class="nav navbar-nav navbar-right">
						  <li class="active"><a href="#" onClick="rendreInvisible('inscription')">
						  <button type="button" class="close" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						  </a></li>
						</ul>
					  </div>
					</nav>
				<!--<span onClick="rendreInvisible('inscription')">X</span><br>-->				
				<div class="form-group">
					<label class="control-label col-sm-2" for="nom">Nom:</label>
					<div class="col-sm-10">
						<input type="text" id="nom" name="nom">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="prenom">Prénom:</label>
					<div class="col-sm-10">
						<input type="text" id="prenom" name="prenom">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="courriel2">Courriel:</label>
					<div class="col-sm-10">
						<input type="text" id="courriel2" name="courriel2">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="mdp2">Mot de passe:</label>
					<div class="col-sm-10">
						<input type="text" id="mdp2" name="mdp2">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="cmdp2">Confirmer mot de passe:</label>
					<div class="col-sm-10">
						<input type="text" id="cmdp2" name="cmdp2">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="age">Age:</label>
					<div class="col-sm-10">
						<select id="age" name="age">
						</select>
					</div>
				</div>
				<div class="form-group">
				  <div class="col-sm-10">
					<input type="submit" value="Envoyer">
				  </div>
				</div>	
			</form>
		</div>
		
		<!--profil    $nom=$prenom=$courriel=$mdp=$confirm=""; $age=16;-->
		<div id="profil">
			<form id="formEnregCateg" class="form-horizontal" enctype="multipart/form-data" action="serveur/gestionMembres.php" method="POST" onSubmit="return validerProfil();" >
				<!--<h3>Votre profil</h3><br><br>-->
				<input type="hidden" value="profil" name="operation">
				<nav class="navbar navbar-inverse" style="width:30%;">
					<div class="container-fluid">
						<div class="navbar-header">
						<a class="navbar-brand" href="#">Votre profil</a>
						</div>
						<ul class="nav navbar-nav navbar-right">
						  <li class="active"><a href="#" onClick="rendreInvisible('profil')">
						  <button type="button" class="close" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						  </a></li>
						</ul>
					  </div>
					</nav>
				<!--<span onClick="rendreInvisible('profil')">X</span><br>-->				
				<div class="form-group">
					<label class="control-label col-sm-2" for="nom3">Nom:</label>
					<div class="col-sm-10">
						<input type="text" id="nom3" name="nom3" value="<?php echo $nom;?>" >
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="prenom3">Prénom:</label>
					<div class="col-sm-10">
						<input type="text" id="prenom3" name="prenom3" value="<?php echo $prenom;?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="courriel3">Courriel:</label>
					<div class="col-sm-10">
						<input type="text" id="courriel3" name="courriel3" value="<?php echo $courriel;?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="mdp3">Mot de passe:</label>
					<div class="col-sm-10">
						<input type="text" id="mdp3" name="mdp3" value="<?php echo $mdp;?>" >
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="cmdp3">Confirmer mot de passe:</label>
					<div class="col-sm-10">
						<input type="text" id="cmdp3" name="cmdp3" value="<?php echo $mdp;?>" >
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="age3">Age:</label>
					<div class="col-sm-10">
						<select id="age3" name="age3">
						</select>
					</div>
				</div>
				<div class="form-group">
				  <div class="col-sm-10">
					<input type="submit" value="Envoyer">
				  </div>
				</div>	
			</form>
		</div>
		<script>
		</script>
	
	<!--les categories-->
		<div id="divEnregCateg">
			<form id="formEnregCateg" class="form-horizontal" enctype="multipart/form-data" action="serveur/gestionFilms.php" method="POST" onSubmit="return validerString('nom_categ');" >
				<!--<h3>Enregistrer categorie</h3><br><br>-->
				<input type="hidden" value="enregistrerCateg" name="operation">
				<nav class="navbar navbar-inverse" style="width:30%;">
					<div class="container-fluid">
						<div class="navbar-header">
						<a class="navbar-brand" href="#">Enregistrer categorie</a>
						</div>
						<ul class="nav navbar-nav navbar-right">
						  <li class="active"><a href="#" onClick="rendreInvisible('divEnregCateg')">
						  <button type="button" class="close" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						  </a></li>
						</ul>
					  </div>
					</nav>
				<!--<span onClick="rendreInvisible('divEnregCateg')">X</span><br>-->				
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
				<!--<h3>Enlever categorie</h3><br><br>-->
				<input type="hidden" value="enleverCateg" name="operation">
				<nav class="navbar navbar-inverse" style="width:30%;">
					<div class="container-fluid">
						<div class="navbar-header">
						<a class="navbar-brand" href="#">Enlever categorie</a>
						</div>
						<ul class="nav navbar-nav navbar-right">
						  <li class="active"><a href="#" onClick="rendreInvisible('divEnleverCateg')">
						  <button type="button" class="close" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						  </a></li>
						</ul>
					  </div>
					</nav>
				<!--<span onClick="rendreInvisible('divEnleverCateg')">X</span><br>-->
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
				<!--<h3>Obtenir fiche categorie</h3><br><br>-->
				<input type="hidden" value="ficheCateg" name="operation">
				<nav class="navbar navbar-inverse" style="width:30%;">
					<div class="container-fluid">
						<div class="navbar-header">
						<a class="navbar-brand" href="#">Obtenir fiche categorie</a>
						</div>
						<ul class="nav navbar-nav navbar-right">
						  <li class="active"><a href="#" onClick="rendreInvisible('divFicheCateg')">
						  <button type="button" class="close" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						  </a></li>
						</ul>
					  </div>
					</nav>
				<!--<span onClick="rendreInvisible('divFicheCateg')">X</span><br>-->
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
				<!--<h3>Enregistrer film</h3><br><br>-->
				<input type="hidden" value="enregistrer" name="operation">
				<nav class="navbar navbar-inverse" style="width:30%;">
					<div class="container-fluid">
						<div class="navbar-header">
						<a class="navbar-brand" href="#">Enregistrer film</a>
						</div>
						<ul class="nav navbar-nav navbar-right">
						  <li class="active"><a href="#" onClick="rendreInvisible('divEnreg')">
						  <button type="button" class="close" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						  </a></li>
						</ul>
					  </div>
					</nav>
				<!--<span onClick="rendreInvisible('divEnreg')">X</span><br>-->				
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
				  <label class="control-label col-sm-2" for="src">Source:</label>
				  <div class="col-sm-10">
						<input type="text" id="src" name="src">
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
				<!--<h3>Enlever film</h3><br><br>-->
				<input type="hidden" value="enlever" name="operation">
				<nav class="navbar navbar-inverse" style="width:30%;">
					<div class="container-fluid">
						<div class="navbar-header">
						<a class="navbar-brand" href="#">Enlever film</a>
						</div>
						<ul class="nav navbar-nav navbar-right">
						  <li class="active"><a href="#" onClick="rendreInvisible('divEnlever')">
						  <button type="button" class="close" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						  </a></li>
						</ul>
					  </div>
					</nav>
				<!--<span onClick="rendreInvisible('divEnlever')">X</span><br>-->
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
				<!--<h3>Obtenir fiche film</h3><br><br>-->
				<input type="hidden" value="fiche" name="operation">
				<nav class="navbar navbar-inverse" style="width:30%;">
					<div class="container-fluid">
						<div class="navbar-header">
						<a class="navbar-brand" href="#">Obtenir fiche film</a>
						</div>
						<ul class="nav navbar-nav navbar-right">
						  <li class="active"><a href="#" onClick="rendreInvisible('divFiche')">
						  <button type="button" class="close" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						  </a></li>
						</ul>
					  </div>
					</nav>
				<!--<span onClick="rendreInvisible('divFiche')">X</span><br>-->
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
		<div id="descriptionErreurs">
			<nav class="navbar navbar-inverse" style="width:30%;">
					<div class="container-fluid">
						<div class="navbar-header">
						<a class="navbar-brand" href="#"></a>
						</div>
						<ul class="nav navbar-nav navbar-right">
						  <li class="active"><a href="#" onClick="rendreInvisible('descriptionErreurs')">
						  <button type="button" class="close" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						  </a></li>
						</ul>
					  </div>
					</nav>
			<!--<span onClick="rendreInvisible('descriptionErreurs')">X</span>-->
		</div>

	  
	  
	  
	  <div id="lesFilms">
	  <br><br>
      
	  <div class="row">
	  <?php
	  $con=mysqli_connect("localhost","root","","bdfilms");
		if (mysqli_connect_errno()) {
				echo "Probleme de connexion au serveur de bd";
				exit();
			}	
	$rep="";
	//$requette = "SELECT film.no_film, film.titre, film.realisateur, film.duree, categorie.nom, film.prix,
	//film.pochette film.source FROM film, categorie WHERE film.id_categ=categorie.id_categ";
	$requette = "SELECT * FROM film";
	try{
		 $listeFilms=mysqli_query($con,$requette);
		 while($ligne=mysqli_fetch_object($listeFilms)){
			$src=($ligne->source);
			$categ=($ligne->id_categ);
			switch($categ) {
				case "1": $categ="Action";break;
				case "2": $categ="Comedie";break;
				case "3": $categ="Drama";break;
				case "4": $categ="Thriller";break;
				case "5": $categ="Romance";break;
				case "6": $categ="Horror";break;
				case "7": $categ="Documentaire";break;
				default: ;				
			}
			$rep.="<div class=\"col-lg-3 col-md-4 col-sm-6 portfolio-item\">";
			$rep.="<div class=\"card h-100\">";
			//$rep.="<form action=\"index.php\" method=\"GET\" >\n";
			//$rep.="<input type=\"hidden\" name=\"sourceFilm\" value='".($ligne->no_film)."'>";
			$rep.="<a onClick=\"rendreVisible('lieuFilm')\" href='index.php?src=".$src."' ><img class=\"card-img-top\" src='pochettes/".($ligne->pochette)."' width=160 height=80 alt=\"\"></a>";
			//$rep.="<a href='index.php?src=".$src."' ><button type=\"submit\" style=\"background-color:transparent; border-color:transparent;\"><img class=\"card-img-top\" src='pochettes/".($ligne->pochette)."' width=160 height=80 alt=\"\"></button></a>";
			//$rep.="</form>";
			$rep.="<div class=\"card-body\">";
			$rep.=" <h4 class=\"card-title\">".($ligne->titre)."</h4>";
			$rep.="<p class=\"card-text\">Realisateur: ".($ligne->realisateur)."</p>";
			$rep.="<p class=\"card-text\">Duree: ".($ligne->duree)."minutes.</p>";
			$rep.="<p class=\"card-text\">Categorie: ".$categ."</p>";
			$rep.="<p class=\"card-text\">Prix: ".($ligne->prix)."</p>";
			$rep.="Quantite: <select id=\"quantite\" nom=\"quantite\"><option value='1'>1</option>
			<option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option></select><br>";
			$rep.="<p class=\"card-text\"><a href='serveur/gestionMembres.php?no=".($ligne->no_film)."prix=".($ligne->prix)."quantite=	
			1'>Ajouter au panier</a></p></br>";			
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
