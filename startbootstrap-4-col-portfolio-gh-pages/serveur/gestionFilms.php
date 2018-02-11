
	
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
	$requete="INSERT INTO film values(0,?,?,?,?,?,?)";
	$stmt = $con->prepare($requete);
	$stmt->bind_param("ssiids", $titre,$res,$id_categorie,$duree,$prix,$pochette);
	$stmt->execute();
	echo "Film ".$con->insert_id." bien enregistre";
	mysqli_close($con);
}

function lister() {
	$rep="<caption>LISTE DES FILMS</caption>";
	$rep.="<table border=1>";
	$rep.="<tr><th>NUMERO</th><th>TITRE</th><th>REALISATEUR</th><th>CATEGORIE</th><th>DUREE</th><th>PRIX</th><th>POCHETTE</th></tr>";
	
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
		$rep.="</table>";
		echo $rep;
	 }
	 mysqli_close($con);
	
	
	// =============================
	 $rep="";
  //   $requette="SELECT f.no_film, f.titre, f.realisateur, c.nom, 
  // f.duree, f.prix, f.pochette FROM film f, categorie  c
  // WHERE f.id_categ=c.id_categ ";
   // $requette="select * from film";
   // if($result = mysqli_query($con, $requette)) {
      // if(mysqli_num_rows($result) > 0) {
        // $rep.="<caption>LISTE DES FILMS</caption>";
		// $rep.="<table border=1>";
		// $rep.="<tr><th>NUMERO</th><th>TITRE</th><th>REALISATEUR</th><th>CATEGORIE</th><th>DUREE</th><th>PRIX</th><th>POCHETTE</th></tr>";
         
         // while($row = mysqli_fetch_array($result)){
            // $rep.= "<tr>";
            // $rep.= "<td>" . $row['no_film'] . "</td>";
            // $rep.= "<td>" . $row['titre'] . "</td>";
			// $rep.= "<td>" . $row['realisateur'] . "</td>";
			// $rep.= "<td>" . $row['id_categ'] . "</td>";
            // $rep.= "<td>" . $row['duree'] . "</td>";
			// $rep.= "<td>" . $row['prix'] . "</td>";
			// $rep.= "<td><img src='../pochettes/" . $row['pochette'] . "' width=80 height=80></td>";			
            // $rep.= "</tr>";
         // }
         // $rep.= "</table>";
         // mysqli_free_result($result);
      // } else {
         // echo "No records matching your query were found.";
      // }
   // } else {
      // echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
   // }
   // mysqli_close($con);
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
		echo "Film ".$num." introuvable";
		mysqli_close($con);
		exit;
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
	echo "<br><b>LE FILM : ".$num." A ETE RETIRE</b>";
}

function fiche() {
	$num=$_POST['num'];
	global $con;
	function envoyerForm($ligne){
		global $num;
		
		$rep  = "<div id=\"divEnreg\">";
		$rep.= "<form enctype=\"multipart/form-data\" action=\"gestionFilms.php\" method=\"POST\" onSubmit=\"return valider();\">\n"; 
		$rep.= "	<h3>Fiche du film ".$num." </h3><br><br>\n"; 
		$rep.= "	<span onClick=\"rendreInvisible('divEnreg')\">X</span><br>\n"; 
		$rep.='<input type="hidden" name="operation" value="modifier">';
		$rep.= "	Numero:<input type=\"text\" id=\"num\" name=\"num\" value='".$ligne->no_film."' readonly><br>\n"; 
		$rep.= "	Titre:<input type=\"text\" id=\"titre\" name=\"titre\" value='".$ligne->titre."'><br>\n"; 
		$rep.= "	Realisateur:<input type=\"text\" id=\"res\" name=\"res\" value='".$ligne->realisateur."'><br><br>\n";
		$rep.= "	Categorie:<input type=\"text\" id=\"categ\" name=\"categ\" value='".$ligne->id_categ."' readonly><br><br>\n";		
		$rep.= "	Duree:<input type=\"text\" id=\"duree\" name=\"duree\" value='".$ligne->duree."'><br>\n"; 
		$rep.= "	Prix:<input type=\"text\" id=\"prix\" name=\"prix\" value='".$ligne->prix."'><br>\n";
		$rep.= "  Pochette:<input type=\"file\" id=\"pochette\" name=\"pochette\"><br><br>";
		$rep.= "	<input type=\"submit\" value=\"Envoyer\"><br>\n"; 
		$rep.= "</form>\n";
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
		echo "Film ".$num." introuvable";
		mysqli_close($con);
		exit;
	}
	echo envoyerForm($ligne);
	mysqli_close($con);
}

function modifier() {
	global $con;
	$num=$_POST['num'];
	$titre=$_POST['titre'];
	$res=$_POST['res'];
	$id_categ=$_POST['categ'];
	$duree=$_POST['duree'];
	$prix=$_POST['prix'];	
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
	$requette="UPDATE film set titre=?,realisateur=?,id_categ=?,duree=?,prix=?,pochette=? WHERE no_film=?";
	$stmt = $con->prepare($requette);
	$stmt->bind_param("ssiidsi",$titre,$res,$id_categ,$duree,$prix,$pochette,$num);
	$stmt->execute();
	mysqli_close($con);
	echo "<br><b>LE FILM : ".$num." A ETE MODIFIE</b>";
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
	$rep="<caption>LISTE DES CATEGORIES</caption>";
	$rep.="<table border=1>";
	$rep.="<tr><th>NOM CATEGORIE</th><th>NOM FILM</th></tr>";
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
		$rep.="</table>";
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
		
		$rep  = "<div id=\"divEnreg\">";
		$rep.= "<form enctype=\"multipart/form-data\" action=\"gestionFilms.php\" method=\"POST\" onSubmit=\"return validerString2('nomCat');\">\n"; 
		$rep.= "	<h3>Fiche de la categorie ".$numCat." </h3><br><br>\n"; 
		$rep.= "	<span onClick=\"rendreInvisible('divEnreg')\">X</span><br>\n"; 
		$rep.='<input type="hidden" name="operation" value="modifierCateg">';
		$rep.= "	Numero:<input type=\"text\" id=\"numCat\" name=\"numCat\" value='".$ligne->id_categ."' readonly><br>\n"; 
		$rep.= "	Titre:<input type=\"text\" id=\"nomCat\" name=\"nomCat\" value='".$ligne->nom."'><br>\n"; 
		$rep.= "	<input type=\"submit\" value=\"Envoyer\"><br>\n"; 
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
		echo "Categorie ".$numCat." introuvable";
		mysqli_close($con);
		exit;
	}
	echo envoyerForm($ligne);
	mysqli_close($con);
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
	echo "<br><b>La categorie : ".$numCat." A ETE MODIFIE</b>";
}

?>

