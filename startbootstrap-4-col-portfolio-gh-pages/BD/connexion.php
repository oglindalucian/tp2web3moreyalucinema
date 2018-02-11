 <?php
	// define("SERVEUR","localhost");
	// define("USAGER","root");
	// define("PASSE","");
	// define("BD","bdfilms");
	// $connexion = new mysqli(SERVEUR,USAGER,PASSE,BD);
	// if ($connexion->connect_errno) {
		// echo "Probleme de connexion au serveur de bd";
		// exit();
	// }
		
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=bdfilms;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
?>



