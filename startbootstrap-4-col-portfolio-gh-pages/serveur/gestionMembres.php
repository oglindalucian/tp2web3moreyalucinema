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
		default: ;	
	}
}

	$total=$no_film=$prixFilm=$quantiteFilms=1;
//if(isset($_GET['no']) && !empty($_GET['no']) && isset($_GET['prix']) && !empty($_GET['prix']) && isset($_GET['quantite']) && !empty($_GET['quantite'])) {

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
			$_SESSION["messagePourUtilisateur"] = "";
			//echo "Erreur lors d'ajout au panier.";
			mysqli_close($con);
			// exit;
		 }
		 $userid = $ligne->id_utilisateur;
		 mysqli_free_result($result);
		 // //-----
		 $requete="SELECT prix FROM film WHERE no_film=?";
		 $stmt = $con->prepare($requete);
		 $stmt->bind_param("i", $no_film);
		 $stmt->execute();
		 $result = $stmt->get_result();
		 if(!$ligne = $result->fetch_object()){
			$_SESSION["messagePourUtilisateur"] = "";
			//echo "Erreur lors d'ajout au panier.";
			mysqli_close($con);
			// exit;
		 }
		 $prix = $ligne->prix;
		 $total=$quantiteFilms*$prix;
		 mysqli_free_result($result);
		//----	
		$requete="INSERT INTO commande values(0,?,?,?,?,?)";
		$stmt = $con->prepare($requete);
		$stmt->bind_param("iidid", $userid,$no_film,$prix,$quantiteFilms,$total);
		$stmt->execute();
		
		$_SESSION["messagePourUtilisateur"] = "Votre commande a ete ajoute au panier.";
		//echo "Votre commande a ete ajoute au panier.";
		mysqli_close($con);	
		redirection();
//}		
		
//1
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
	// $_SESSION["CourrielUtilConnecte"] = "";
	// $_SESSION["confirmAdmin"] = "false";
	// $_SESSION["messagePourUtilisateur"] = "";
	//$leId = 0;
	$requette = "SELECT courriel, mdp FROM connexion WHERE courriel = ?";   //.$courriel;
	$stmt = $con->prepare($requette);
	$stmt->bind_param("s", $courriel);
	$stmt->execute();
	$result = $stmt->get_result();
	if(!$ligne = $result->fetch_object()){
		$_SESSION["messagePourUtilisateur"] =  "Courriel inexistent!";
		//echo "Courriel inexistent!";
		mysqli_close($con);
		//exit;
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
	$no_film=$prix=$quantite=$total=$duree=1; $nom=$prenom=$titre=$realisateur=""; $totalFinal=0;
	$courriel=$_SESSION["CourrielUtilConnecte"];
	$requette = "SELECT id_utilisateur, nom, prenom FROM utilisateur WHERE courriel = ?";   
	$stmt = $con->prepare($requette);
	$stmt->bind_param("s", $courriel);
	$stmt->execute();
	$result = $stmt->get_result();
	if(!$ligne = $result->fetch_object()){
		$_SESSION["messagePourUtilisateur"] =  "Erreur d'acces a votre panier.";
		mysqli_close($con);
	}
	else {
		$userid=$ligne->id_utilisateur;
		$nom=$ligne->nom;
		$prenom=$ligne->prenom;
	}
	mysqli_free_result($result);
    //----
	
	// $rep="<div class=\"container\">";
	// $rep.="<div class=\"modal fade\" id=\"myModalPanier\" role=\"dialog\">";
    // $rep.="<div class=\"modal-dialog\">";
    // $rep.="<div class=\"modal-content\">";
    // $rep.="<div class=\"modal-header\">";
    // $rep.="<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>";
    // $rep.="<h1 class=\"modal-title\">LISTE DES FILMS DANS VOTRE PANIER</h1></div>";
    // $rep.="<div class=\"modal-body\">"; 	
	$rep="<div id=\"lepanier\"><h1 align=\"center\">LISTE DES FILMS DANS VOTRE PANIER</h1>";
	$rep.="<table class=\"table table-striped table-hover\" style=\"width:60%; margin:auto;\">";
	$rep.="<tr><th>UTILISATEUR</th><th>FILM</th><th>REALISATEUR</th><th>DUREE</th><th>PRIX</th><th>QUANTITE</th><th>TOTAL</th></tr>";
	$requette = "SELECT commande.id_utilisateur, commande.no_film, commande.prix, commande.quantite, commande.total 
	FROM commande, utilisateur WHERE utilisateur.id_utilisateur=commande.id_utilisateur AND commande.id_utilisateur=".$userid;   
	try{
		$listeFilms=mysqli_query($con,$requette);
		while($ligne=mysqli_fetch_object($listeFilms)){
			$no_film=($ligne->no_film);
			$prix=($ligne->prix);
			$quantite=($ligne->quantite);
			$total=($ligne->total);
			$totalFinal+=$total;
			//nom du chaque film:
				$requette2 = "SELECT titre, realisateur, duree FROM film WHERE no_film = ?";   
				$stmt = $con->prepare($requette2);
				$stmt->bind_param("d", $no_film);
				$stmt->execute();
				$result = $stmt->get_result();
				if(!$ligne = $result->fetch_object()){
					$_SESSION["messagePourUtilisateur"] =  "Erreur d'acces a votre panier.";
					mysqli_close($con);
				}
				else {
					$titre=$ligne->titre;
					$realisateur=$ligne->realisateur;
					$duree=$ligne->duree;
	$rep.="<tr><td> ".$nom.", ".$prenom." </td><td> ".$titre." </td><td> ".$realisateur." </td><td> ".$duree." </td><td> ".$prix." </td><td> ".$quantite." </td><td> ".$total." </td></tr>";		 

				}
				mysqli_free_result($result);
			
		}
		$rep.="<tr><td></td><td></td><td></td><td></td><td></td><td></td><td>".$totalFinal."</td></tr>";	
		
		mysqli_free_result($listeFilms);
	 }catch (Exception $e){
		$_SESSION["messagePourUtilisateur"] = "Probleme pour lister les films dans votre panier";
	 }finally {
		$rep.="</table>";
		$rep.="<button type=\"button\" onClick=\"rendreInvisible('lepanier')\">OK</button></div>";
		// $rep.="</div><div class=\"modal-footer\">";
        // $rep.="<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>";
        // $rep.=" </div> </div> </div> </div></div>";        
      	
		$_SESSION["messagePourUtilisateur"] = $rep;
		
		//$_SESSION["panier"] = $rep;
	 }
	
	 $rep="";
	//mysqli_free_result($result);
	//-----
	
	//header('Location: panier.php');
	
	
	mysqli_close($con);
	redirection();
	
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