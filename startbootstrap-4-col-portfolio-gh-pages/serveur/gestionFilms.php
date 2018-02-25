<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="fr">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cinema Moreyalu</title>	
	
	<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="../css/4-col-portfolio.css" rel="stylesheet">
	<script language="javascript" src="../js/global.js"></script>
	
	<!--<script language="javascript" src="vendor/bootstrap/js/bootstrap.js"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="../css/films.css" type="text/css" />
	
 
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	
</head>
<body>

<?php
//$bdd = require_once("../BD/connexion.php");
$con=mysqli_connect("localhost","root","","bdfilms");
if (mysqli_connect_errno()) {
		echo "Probleme de connexion au serveur de bd";
		exit();
	}
$operation=$_POST['operation'];
switch($operation) {
	case "enregistrer": enregistrer(); break;
	case "lister": lister(); break;
	case "enlever": enlever(); break;
	case "fiche": fiche(); break;
	case "modifier": modifier(); break;
	case "enregistrerCateg": enregistrerCateg(); break;
	case "listerCateg": listerCateg(); break;
	case "enleverCateg": enleverCateg(); break;
	case "ficheCateg": ficheCateg(); break;
	case "modifierCateg": modifierCateg(); break;
	default: ;
	
}

function enregistrer() {
	$titre=$_POST['titre'];
	$res=$_POST['res'];
	$id_categorie=$_POST['categ'];
	$duree=$_POST['duree'];
	$prix=$_POST['prix'];
	$src=$_POST['src'];	
	$dossier="../pochettes/";
	$nomPochette=sha1($titre.time());
	$pochette="avatar.png";
	if($_FILES['pochette']['tmp_name']!==""){
		//Upload de la photo
		$tmp = $_FILES['pochette']['tmp_name'];
		$fichier= $_FILES['pochette']['name'];
		$extension=strrchr($fichier,'.');
		@move_uploaded_file($tmp,$dossier.$nomPochette.$extension);
		// Enlever le fichier temporaire chargé
		@unlink($tmp); //effacer le fichier temporaire
		$pochette=$nomPochette.$extension;
	}
	global $con;
	$requete="INSERT INTO film values(0,?,?,?,?,?,?,?)";
	$stmt = $con->prepare($requete);
	$stmt->bind_param("ssiidss", $titre,$res,$id_categorie,$duree,$prix,$pochette,$src);
	$stmt->execute();
	//echo "<b>Film ".$con->insert_id." bien enregistre.</b><br><br>";
	//echo "<a href=\"../index.php\"><button type=\"button\" class=\"btn btn-primary\">Accueil</button></a>";
	$_SESSION["messagePourUtilisateur"] =  "<b>Film ".$con->insert_id." bien enregistre.</b><br><br>";
	mysqli_close($con);
	redirection();
}

function lister() {
	$rep="<h1 align=\"center\">LISTE DES FILMS</h1><br>";
	$rep.="<div class=\"container\">";
	$rep.="<a href=\"../index.php\"><button type=\"button\" class=\"btn btn-primary\">Accueil</button></a>";
	$rep.="<table class=\"table table-striped table-hover table-condensed\" style=\"width:80%; margin:auto;\">";
	$rep.="<tr class=\"warning\"><th>NUMERO</th><th>TITRE</th><th>REALISATEUR</th><th>CATEGORIE</th><th>DUREE</th><th>PRIX</th><th>POCHETTE</th></tr>";
	
	$requette="SELECT film.no_film AS numeroFilm, film.titre AS titreFilm, film.realisateur AS realisateur, categorie.nom AS nomCategorie, 
	film.duree AS dureeFilm, film.prix AS prixFilm, film.pochette AS pochetteFilm FROM film, categorie  
	WHERE film.id_categ=categorie.id_categ ORDER BY categorie.nom";
	//$requette = "SELECT * FROM film";
	global $con;
	try{
		$listeFilms=mysqli_query($con,$requette);
		while($ligne=mysqli_fetch_object($listeFilms)){
			$rep.="<tr><td>".($ligne->numeroFilm)."</td><td>".($ligne->titreFilm)."</td><td>".($ligne->realisateur)."</td><td>".($ligne->nomCategorie)."</td><td>".($ligne->dureeFilm)."</td><td>".($ligne->prixFilm)."</td><td><img src='../pochettes/".($ligne->pochetteFilm)."' width=80 height=80></td></tr>";		 
		}
			
		
		mysqli_free_result($listeFilms);
	 }catch (Exception $e){
		echo "Probleme pour lister";
	 }finally {
		$rep.="</table></div><br><br><br>";
		echo $rep;
	 }
	 mysqli_close($con);	
	 $rep="";
  
}

function enlever() {
	global $con;
	$num=$_POST['num'];	
	$requete="SELECT * FROM film WHERE no_film=?";
	$stmt = $con->prepare($requete);
	$stmt->bind_param("i", $num);
	$stmt->execute();
	$result = $stmt->get_result();
	if(!$ligne = $result->fetch_object()){
		//echo "<b>Film ".$num." introuvable!</b><br><br>";
		//echo "<a href=\"../index.php\"><button type=\"button\" class=\"btn btn-primary\">Accueil</button></a>";
		mysqli_close($con);
		exit;
		$_SESSION["messagePourUtilisateur"] = "<b>Film ".$num." introuvable!</b><br><br>";
	}
	$pochette=$ligne->pochette;
	if($pochette!="avatar.png"){
		$rmPoc='../pochettes/'.$pochette;
		$tabFichiers = glob('../pochettes/*');
		//print_r($tabFichiers);
		// parcourir les fichier
		foreach($tabFichiers as $fichier){
		  if(is_file($fichier) && $fichier==trim($rmPoc)) {
			// enlever le fichier
			unlink($fichier);
			break;
		  }
		}
	}
	$requete="DELETE FROM film WHERE no_film=?";
	$stmt = $con->prepare($requete);
	$stmt->bind_param("i", $num);
	$stmt->execute();
	mysqli_close($con);
	//echo "<br><b>LE FILM : ".$num." A ETE RETIRE</b><br><br>";
	//echo "<a href=\"../index.php\"><button type=\"button\" class=\"btn btn-primary\">Accueil</button></a>";
	$_SESSION["messagePourUtilisateur"] = "<br><b>LE FILM : ".$num." A ETE RETIRE</b><br><br>";
	redirection();
}

function fiche() {
	$num=$_POST['num'];
	global $con;
	function envoyerForm($ligne){
		global $num;
		$rep="<p align=\"center\"><a href=\"../index.php\"><button type=\"button\" class=\"btn btn-primary\">Accueil</button></a></p>";
		$rep.= "<div id=\"divEnreg2\">";
		$rep.= "<form enctype=\"multipart/form-data\" action=\"gestionFilms.php\" method=\"POST\" onSubmit=\"return valider();\">\n"; 
		//$rep.= "	<h3 align=\"center\">Fiche du film ".$num." </h3><br>\n"; 
		
		//$rep.= "	<span onClick=\"rendreInvisible('divEnreg2')\">X</span><br>\n"; 
		$rep.= "		<nav class=\"navbar navbar-inverse\" style=\"width:40%; margin:auto;\">";
		$rep.= "					<div class=\"container-fluid\">";
		$rep.= "						<div class=\"navbar-header\">";
		$rep.= "						<a class=\"navbar-brand\" href=\"#\">Fiche du film ".$num."</a>";
		$rep.= "						</div>";
		$rep.= "						<ul class=\"nav navbar-nav navbar-right\">";
		$rep.= "						  <li class=\"active\"><a href=\"#\" onClick=\"rendreInvisible('divEnreg2')\">";
		$rep.= "						  <button type=\"button\" class=\"close\" aria-label=\"Close\">";
		$rep.= "							<span aria-hidden=\"true\">&times;</span>";
		$rep.= "							</button>";
		$rep.= "						  </a></li></ul> </div></nav>";						
		
		$rep.='<input type="hidden" name="operation" value="modifier">';
		$rep.="<table class=\"table table-striped table-bordered table-hover table-condensed\" style=\"width:40%; margin:auto;\">";
		$rep.= "<tr class=\"info\"><td>	Numero:</td><td><input type=\"text\" id=\"num\" name=\"num\" value='".$ligne->no_film."' readonly></td></tr>"; 
		$rep.= "<tr><td>	Titre:</td><td><input type=\"text\" id=\"titre\" name=\"titre\" value='".$ligne->titre."'></td></tr>"; 
		$rep.= "<tr><td>	Realisateur:</td><td><input type=\"text\" id=\"res\" name=\"res\" value='".$ligne->realisateur."'></td></tr>";
		$rep.= "<tr><td>	Categorie:</td><td><input type=\"text\" id=\"categ\" name=\"categ\" value='".$ligne->id_categ."' readonly ></td></tr>";		
		$rep.= "<tr><td>	Duree:</td><td><input type=\"text\" id=\"duree\" name=\"duree\" value='".$ligne->duree."'></td></tr>"; 
		$rep.= "<tr><td>	Prix:</td><td><input type=\"text\" id=\"prix\" name=\"prix\" value='".$ligne->prix."'></td></tr>";
		$rep.= "<tr><td>    Pochette:</td><td><input type=\"file\" id=\"pochette\" name=\"pochette\"></td></tr>";
		$rep.= "<tr><td>	Source:</td><td><input type=\"text\" id=\"src\" name=\"src\" value='".$ligne->source."'></td></tr>";
		$rep.="</table>";
		$rep.= "<br><p align=\"center\">	<input type=\"submit\" value=\"Envoyer\" ></p><br>\n"; 
		
		$rep.= "</form>\n";
		$rep.= "<div id=\"descriptionErreurs\"></div>";
		$rep.= "</div>";
		return $rep;
	}
	//Obtenir le film en question
	$requete="SELECT * FROM film WHERE no_film=?";
	$stmt = $con->prepare($requete);
	$stmt->bind_param("i", $num);
	$stmt->execute();
	$result = $stmt->get_result();
	if(!$ligne = $result->fetch_object()){
		$_SESSION["messagePourUtilisateur"] = "Film ".$num." introuvable";
		//echo "Film ".$num." introuvable";
		mysqli_close($con);
		redirection();
		exit;
	}
	echo envoyerForm($ligne);
	mysqli_close($con);
	//redirection();
}

function modifier() {
	global $con;
	$num=$_POST['num'];
	$titre=$_POST['titre'];
	$res=$_POST['res'];
	$id_categ=$_POST['categ'];
	$duree=$_POST['duree'];
	$prix=$_POST['prix'];
	$src=$_POST['src'];
	$dossier="../pochettes/";
	$requette="SELECT pochette FROM film WHERE no_film=?";
	$stmt = $con->prepare($requette);
	$stmt->bind_param("i", $num);
	$stmt->execute();
	$result = $stmt->get_result();
	$ligne = $result->fetch_object();
	$pochette=$ligne->pochette;
	if($_FILES['pochette']['tmp_name']!==""){
		//enlever ancienne pochette
		if($pochette!="avatar.png"){
			$rmPoc='../pochettes/'.$pochette;
			$tabFichiers = glob('../pochettes/*');
			//print_r($tabFichiers);
			// parcourir les fichier
			foreach($tabFichiers as $fichier){
			  if(is_file($fichier) && $fichier==trim($rmPoc)) {
				// enlever le fichier
				unlink($fichier);
				break;
				//
			  }
			}
		}
		$nomPochette=sha1($titre.time());
		//Upload de la photo
		$tmp = $_FILES['pochette']['tmp_name'];
		$fichier= $_FILES['pochette']['name'];
		$extension=strrchr($fichier,'.');
		$pochette=$nomPochette.$extension;
		@move_uploaded_file($tmp,$dossier.$nomPochette.$extension);
		// Enlever le fichier temporaire chargé
		@unlink($tmp); //effacer le fichier temporaire
	}
	$requette="UPDATE film set titre=?,realisateur=?,id_categ=?,duree=?,prix=?,pochette=?,source=? WHERE no_film=?";
	$stmt = $con->prepare($requette);
	$stmt->bind_param("ssiidssi",$titre,$res,$id_categ,$duree,$prix,$pochette,$src,$num);
	$stmt->execute();
	mysqli_close($con);
	//echo "<br><b>LE FILM : ".$num." A ETE MODIFIE</b>";
	$_SESSION["messagePourUtilisateur"] = "<br><b>LE FILM : ".$num." A ETE MODIFIE</b>";
	redirection();
}

function enregistrerCateg() {
	$nom_categ = $_POST['nom_categ'];
	
	global $con;
	$requete="INSERT INTO categorie values(0,?)";
	$stmt = $con->prepare($requete);
	$stmt->bind_param("s", $nom_categ);
	$stmt->execute();
	echo "Categorie ".$con->insert_id." bien enregistre";
	mysqli_close($con);
}

function listerCateg() {
	$rep="<h1 align=\"center\">LISTE DES CATEGORIES</h1>";
	$rep.="<div class=\"container\">";
	$rep.="<a href=\"../index.php\"><button type=\"button\" class=\"btn btn-primary\">Accueil</button></a>";
	$rep.="<table class=\"table table-striped table-hover table-condensed\" style=\"width:30%; margin:auto;\">";
	$rep.="<tr class=\"info\"><th>NOM CATEGORIE</th><th>NOM FILM</th></tr>";
	$requette="SELECT * FROM categorie";
	//$requette="SELECT nom, titre FROM categorie, film WHERE categorie.id_categ=film.id_categ";
	global $con;
	 try{
		 $listeCategs=mysqli_query($con,$requette);
		 while($ligne=mysqli_fetch_object($listeCategs)){
			$rep.="<tr><td>".($ligne->id_categ)."</td><td>".($ligne->nom)."</td></tr>";		 
		}
		mysqli_free_result( $listeCategs);
	 }catch (Exception $e){
		echo "Probleme pour lister";
	 }finally {
		$rep.="</table></div>";
		echo $rep;
	 }
	 mysqli_close($con);
}

function enleverCateg() {
	global $con;
	$numCateg=$_POST['numCateg'];		
	$requete="SELECT * FROM categorie WHERE id_categ=?";
	$stmt = $con->prepare($requete);
	$stmt->bind_param("i", $numCateg);
	$stmt->execute();
	$result = $stmt->get_result();
	if(!$ligne = $result->fetch_object()){
		echo "Categorie ".$numCateg." introuvable";
		mysqli_close($con);
		exit;
	}
	
	$requete="DELETE FROM categorie WHERE id_categ=?";
	$stmt = $con->prepare($requete);
	$stmt->bind_param("i", $numCateg);
	$stmt->execute();
	mysqli_close($con);
	echo "<br><b>La categorie : ".$numCateg." A ETE RETIRE</b>";
}

function ficheCateg() {
	$numCat=$_POST['numCat'];
	global $con;
	function envoyerForm($ligne){
		global $numCat;
		$rep="<p align=\"center\"><a href=\"../index.php\"><button type=\"button\" class=\"btn btn-primary\">Accueil</button></a></p>";
		$rep.= "<div id=\"divEnreg3\">";
		$rep.= "<form enctype=\"multipart/form-data\" action=\"gestionFilms.php\" method=\"POST\" onSubmit=\"return validerString2('nomCat');\">\n"; 
		//$rep.= "	<h3>Fiche de la categorie ".$numCat." </h3><br><br>\n"; 
		//$rep.= "	<span onClick=\"rendreInvisible('divEnreg3')\">X</span><br>\n"; 
		
		$rep.= "		<nav class=\"navbar navbar-inverse\" style=\"width:30%; margin:auto;\">";
		$rep.= "					<div class=\"container-fluid\">";
		$rep.= "						<div class=\"navbar-header\">";
		$rep.= "						<a class=\"navbar-brand\" href=\"#\">Fiche de la categorie ".$numCat."</a>";
		$rep.= "						</div>";
		$rep.= "						<ul class=\"nav navbar-nav navbar-right\">";
		$rep.= "						  <li class=\"active\"><a href=\"#\" onClick=\"rendreInvisible('divEnreg3')\">";
		$rep.= "						  <button type=\"button\" class=\"close\" aria-label=\"Close\">";
		$rep.= "							<span aria-hidden=\"true\">&times;</span>";
		$rep.= "							</button>";
		$rep.= "						  </a></li></ul> </div></nav>";			
		
		$rep.='<input type="hidden" name="operation" value="modifierCateg">';
		
		$rep.="<table class=\"table table-striped table-bordered table-hover table-condensed\" style=\"width:27%; margin:auto;\">";
		$rep.= "<tr class=\"info\"><td>		Numero:</td><td><input type=\"text\" id=\"numCat\" name=\"numCat\" value='".$ligne->id_categ."' readonly></td></tr>"; 
		$rep.= "<tr><td>	Titre:</td><td><input type=\"text\" id=\"nomCat\" name=\"nomCat\" value='".$ligne->nom."'></td></tr>"; 
		$rep.="</table>";
		$rep.= "<br><p align=\"center\">	<input type=\"submit\" value=\"Envoyer\" ></p><br>\n"; 
		$rep.= "</form>\n";
		$rep.= "</div>";
		return $rep;
	}
	//Obtenir le film en question
	$requete="SELECT * FROM categorie WHERE id_categ=?";
	$stmt = $con->prepare($requete);
	$stmt->bind_param("i", $numCat);
	$stmt->execute();
	$result = $stmt->get_result();
	if(!$ligne = $result->fetch_object()){
		//echo "Categorie ".$numCat." introuvable";
		$_SESSION["messagePourUtilisateur"] = "Categorie ".$numCat." introuvable";
		mysqli_close($con);
		redirection();
		exit;
	}
	echo envoyerForm($ligne);
	mysqli_close($con);
	//redirection();
}

function modifierCateg() {
	global $con;
	$numCat=$_POST['numCat'];
	$nomCat=$_POST['nomCat'];
	$requette="UPDATE categorie set nom=? WHERE id_categ=?";
	$stmt = $con->prepare($requette);
	$stmt->bind_param("si",$nomCat,$numCat);
	$stmt->execute();
	mysqli_close($con);
	//echo "<br><b>La categorie : ".$numCat." A ETE MODIFIE</b>";
	$_SESSION["messagePourUtilisateur"] = "<br><b>La categorie : ".$numCat." A ETE MODIFIE</b>";
	redirection();
}

function redirection() {
	header('Location: ../index.php');
}

?>

</body>
</html>

