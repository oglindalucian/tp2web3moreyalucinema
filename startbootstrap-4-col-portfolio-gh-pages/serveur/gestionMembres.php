<?php
	session_start();
?>


<?php

$con=mysqli_connect("localhost","root","","bdfilms");
if (mysqli_connect_errno()) {
		echo "Probleme de connexion au serveur de bd";
		exit();
	}
	
if (isset($_POST['operation']) && !empty($_POST['operation'])) { 
	$operation=$_POST['operation'];
	switch($operation) {
		case "connexion": connexion(); break;
		case "inscription": inscription(); break;	
		case "deconnexion": deconnexion(); break;
		case "profil": profil(); break;
		case "panier": panier(); break;
		//case "ajouterPanier": ajouterPanier(); break;
		default: ;	
	}
}

$total=$no_film=$prixFilm=$quantiteFilms=1;
if (isset($_GET['no']) && !empty($_GET['no'])) 
		$no_film=test_input($_GET['no']);
if (isset($_GET['prix']) && !empty($_GET['prix'])) 
		$prixFilm=test_input($_GET['prix']);
if (isset($_GET['quantite']) && !empty($_GET['quantite'])) {
		$quantiteFilms=test_input($_GET['quantite']);
		$total=$quantiteFilms*$prixFilm;
}
		$courriel=$_SESSION["CourrielUtilConnecte"];
	// //-----
	 $requete="SELECT * FROM utilisateur WHERE courriel=?";
	 $stmt = $con->prepare($requete);
	 $stmt->bind_param("s", $courriel);
	 $stmt->execute();
	 $result = $stmt->get_result();
	 if(!$ligne = $result->fetch_object()){
		$_SESSION["messagePourUtilisateur"] = "Erreur lors d'ajout au panier.";
	    mysqli_close($con);
		// exit;
	 }
	 $userid = $ligne->id_utilisateur;
	 mysqli_free_result($result);
		
	$requete="INSERT INTO commande values(0,?,?,?,?,?)";
	$stmt = $con->prepare($requete);
	$stmt->bind_param("ddddd", $userid,$no_film,$prixFilm,$quantiteFilms,$total);
	$stmt->execute();
	
	$_SESSION["messagePourUtilisateur"] = "Votre commande a ete ajoute au panier.";
	mysqli_close($con);	
	redirection();	
		

function connexion() {
	if (isset($_POST['courriel']) && !empty($_POST['courriel'])) {
		$courriel = test_input($_POST['courriel']);
	}
	if (isset($_POST['mdp']) && !empty($_POST['mdp'])) {
		$mdp = test_input($_POST['mdp']);
	}
	global $con;
	$ok=false;
	$admin = false;
	$_SESSION["CourrielUtilConnecte"] = "";
	$_SESSION["confirmAdmin"] = "false";
	$_SESSION["messagePourUtilisateur"] = "";
	//$leId = 0;
	$requette = "SELECT courriel, mdp FROM connexion WHERE courriel = ?";   //.$courriel;
	$stmt = $con->prepare($requette);
	$stmt->bind_param("s", $courriel);
	$stmt->execute();
	$result = $stmt->get_result();
	if(!$ligne = $result->fetch_object()){
		$_SESSION["messagePourUtilisateur"] =  "Courriel inexistent!";
		echo "Courriel inexistent!";
		mysqli_close($con);
		exit;
	}
	else {
		if($ligne->mdp === $mdp) {
				$ok = true;
				$_SESSION["CourrielUtilConnecte"] = $courriel;
				$_SESSION["messagePourUtilisateur"] = "Bienvenu sur notre site ".$courriel."!";
				//echo "Bienvenu sur notre site ".$courriel."!";
				//$leId = $ligne->id;
			} else {
				$_SESSION["messagePourUtilisateur"] = "Verifiez votre mot de passe!";
				//echo "Verifiez votre mot de passe!";
			}
			if($ok && $courriel==="admin@admin.ca" && $mdp==="Admin123") {
				$admin = true;
				$_SESSION["messagePourUtilisateur"] = "Vous vous etes connecte en tant qu'administrateur.";
				$_SESSION["confirmAdmin"]="true";
				//echo "Vous vous etes connecte en tant qu'administrateur.";
			}
		mysqli_free_result($result);
		mysqli_close($con);
	}
	
	redirection();	
}

function deconnexion() {
	$_SESSION["CourrielUtilConnecte"] = "";
	$_SESSION["confirmAdmin"] = "false";
	$_SESSION["messagePourUtilisateur"] = "";
	redirection();
}

function inscription() {
	$nom=$_POST['nom'];
	$prenom=$_POST['prenom'];
	$courriel=$_POST['courriel2'];
	$mdp=$_POST['mdp2'];
	$age=$_POST['age'];
	global $con;
	
	$requete="INSERT INTO utilisateur values(0,?,?,?,?)";
	$stmt = $con->prepare($requete);
	$stmt->bind_param("sssd", $courriel,$nom,$prenom,$age);
	$stmt->execute();
	
	$requete="INSERT INTO connexion values(0,?,?)";
	$stmt = $con->prepare($requete);
	$stmt->bind_param("ss", $courriel,$mdp);
	$stmt->execute();
	
	$_SESSION["messagePourUtilisateur"] = "Votre profil a ete bien enregistre.";
	mysqli_close($con);
	redirection();	
}

function profil() {
	global $con;
	$nom=$_POST['nom3'];
	$prenom=$_POST['prenom3'];
	$courriel=$_POST['courriel3'];
	$mdp=$_POST['mdp3'];
	$age=$_POST['age3'];
	try{	
		$requette="UPDATE connexion set courriel=?,mdp=? WHERE courriel=?";
		$stmt = $con->prepare($requette);
		$stmt->bind_param("sss",$courriel, $mdp, $_SESSION["CourrielUtilConnecte"]);
		$stmt->execute();
		
		$requette="UPDATE utilisateur set courriel=?,nom=?,prenom=?,age=? WHERE courriel=?";
		$stmt = $con->prepare($requette);
		$stmt->bind_param("sssds",$courriel, $nom, $prenom, $age, $_SESSION["CourrielUtilConnecte"]);
		$stmt->execute();
		
		$_SESSION["messagePourUtilisateur"] = "Votre profil a ete bien modifie.";
	} catch(Exception $e) {
		$_SESSION["messagePourUtilisateur"] = "Erreur lors du modification du profil.";
	}
	mysqli_close($con);
	redirection();	
	}

function panier() {
global $con;  //select

}

function ajouterPanier() { //insert
global $con;
	
	//-----	
	
	
	// $requete="INSERT INTO commande values(0,?,?,?,?)";
	// $stmt = $con->prepare($requete);
	// $stmt->bind_param("sssd", $courriel,$nom,$prenom,$age);
	// $stmt->execute();
	
	// $_SESSION["messagePourUtilisateur"] = "Votre commande a ete ajoute au panier.";
	// mysqli_close($con);


}	


function redirection() {
	header('Location: ../index.php');
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>