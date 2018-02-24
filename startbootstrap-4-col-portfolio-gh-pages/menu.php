
<?php
$connexion = "Connexion";
$deconnexion = "Déconnexion";
$admin=false;
$courriel="";
$_SESSION["confirmAdmin"]="";
//if($_SESSION["CourrielUtilConnecte"]!=null)
	$courriel=$_SESSION["CourrielUtilConnecte"];
$msg="";
if($_SESSION["messagePourUtilisateur"]!=null)
	$msg=$_SESSION["messagePourUtilisateur"];
if($msg!=="") {$msg="<br><h1>".$_SESSION["messagePourUtilisateur"]."</h1>";}
	if($_SESSION["confirmAdmin"]!=null && $_SESSION["confirmAdmin"]==="true") 
		$admin=true;
if($courriel!=="")
	$connexion="Profil";

echo "<nav class=\"navbar navbar-expand-lg navbar-dark bg-dark fixed-top\">\n"; 
echo "      <div class=\"container\">\n"; 
echo "        <a class=\"navbar-brand\" href=\"#\">Cinéma Moreyalu</a>\n"; 
echo "        <button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarResponsive\" aria-controls=\"navbarResponsive\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">\n"; 
echo "          <span class=\"navbar-toggler-icon\"></span>\n"; 
echo "        </button>\n"; 
echo "        <div class=\"collapse navbar-collapse\" id=\"navbarResponsive\">\n"; 
echo "         <ul class=\"navbar-nav ml-auto\">\n"; 
echo "			  <li class=\"nav-item active\">\n"; 
echo "				<a class=\"nav-link\" href=\"index.php\">Accueil</a>\n"; 
echo "			  </li>\n";

echo "			  <div class=\"multipleOptions\"><li class=\"dropdown\" class=\"nav-item\" ><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" class=\"nav-link\" href=\"#\">Catégories <span class=\"caret\"></span></a>\n"; 
echo "				 <ul class=\"dropdown-menu\">\n"; 
//echo "					<li class=\"nav-item\"><a href=\"#\" onClick=\"rendreVisible('divEnregCateg'); rendreInvisible('lesFilms'); rendreInvisible('divFicheCateg'); rendreInvisible('divEnleverCateg'); rendreInvisible('foot');\">Enregistrer</a></li>\n"; 
echo "					<li class=\"nav-item\"><a href=\"#\" onClick=\"listerCateg(); rendreInvisible('lesFilms');\" >Lister</a></li>\n"; 
if($admin===true) {
	echo "				<li class=\"nav-item\"><a href=\"#\" onClick=\"rendreVisible('divFicheCateg'); rendreInvisible('lesFilms'); rendreInvisible('divEnregCateg'); rendreInvisible('divEnleverCateg'); rendreInvisible('foot'); rendreInvisible('connexion'); rendreInvisible('inscription'); rendreInvisible('divEnreg'); rendreInvisible('divEnlever'); rendreInvisible('divFiche'); rendreInvisible('descriptionErreurs'); rendreInvisible('profil');\">Modifier</a></li>\n"; 
}
//echo "					<li class=\"nav-item\"><a href=\"#\" onClick=\"rendreVisible('divEnleverCateg'); rendreInvisible('lesFilms'); rendreInvisible('divFicheCateg'); rendreInvisible('divEnregCateg'); rendreInvisible('foot');\">Enlever</a></li>					\n"; 
echo "				</ul> \n"; 
echo "            </li></div>	         \n"; 
 
echo "			  <div class=\"multipleOptions\"><li class=\"dropdown\" class=\"nav-item\" ><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" class=\"nav-link\" href=\"#\">Films <span class=\"caret\"></span></a>\n"; 
echo "				 <ul class=\"dropdown-menu\">\n"; 
if($admin===true) {
	echo "				<li class=\"nav-item\"><a href=\"#\" onClick=\"rendreVisible('divEnreg'); rendreInvisible('lesFilms'); rendreInvisible('divFiche'); rendreInvisible('divEnlever'); rendreInvisible('foot'); rendreInvisible('connexion'); rendreInvisible('inscription'); rendreInvisible('divFicheCateg'); rendreInvisible('divEnregCateg'); rendreInvisible('divEnleverCateg'); rendreInvisible('descriptionErreurs'); rendreInvisible('profil');\">Enregistrer</a></li>\n"; 
}
echo "					<li class=\"nav-item\"><a href=\"#\" onClick=\"lister(); rendreInvisible('lesFilms');\" >Lister</a></li>\n"; 
if($admin===true) {
	echo "				<li class=\"nav-item\"><a href=\"#\" onClick=\"rendreVisible('divFiche'); rendreInvisible('lesFilms'); rendreInvisible('divEnreg'); rendreInvisible('divEnlever'); rendreInvisible('foot'); rendreInvisible('connexion'); rendreInvisible('inscription'); rendreInvisible('divFicheCateg'); rendreInvisible('divEnregCateg'); rendreInvisible('divEnleverCateg'); rendreInvisible('descriptionErreurs'); rendreInvisible('profil');\">Modifier</a></li>\n"; 
	echo "				<li class=\"nav-item\"><a href=\"#\" onClick=\"rendreVisible('divEnlever'); rendreInvisible('lesFilms'); rendreInvisible('divFiche'); rendreInvisible('divEnreg'); rendreInvisible('foot'); rendreInvisible('connexion'); 
rendreInvisible('inscription'); rendreInvisible('divFicheCateg'); rendreInvisible('divEnregCateg'); rendreInvisible('divEnleverCateg'); rendreInvisible('descriptionErreurs');\">Enlever</a></li>					\n"; 
}
echo "				</ul> \n"; 
echo "            </li></div>	         \n"; 

if($courriel==="") {
	echo "            <li class=\"nav-item\">\n"; 
	echo "              <a class=\"nav-link\" href=\"#\" onClick=\"rendreVisible('connexion'); rendreInvisible('profil'); rendreInvisible('inscription');  rendreInvisible('divEnreg'); rendreInvisible('lesFilms'); rendreInvisible('divFiche'); rendreInvisible('divEnlever'); rendreInvisible('foot'); rendreInvisible('divFicheCateg'); rendreInvisible('divEnregCateg'); rendreInvisible('divEnleverCateg'); rendreInvisible('descriptionErreurs'); rendreInvisible('profil');\">".$connexion."</a>\n"; 
	echo "            </li>\n"; 
} else {
	echo "            <li class=\"nav-item\">\n"; 
	echo "              <a class=\"nav-link\" href=\"#\" onClick=\"rendreVisible('profil'); rendreInvisible('connexion'); rendreInvisible('inscription');  rendreInvisible('divEnreg'); rendreInvisible('lesFilms'); rendreInvisible('divFiche'); rendreInvisible('divEnlever'); rendreInvisible('foot'); rendreInvisible('divFicheCateg'); rendreInvisible('divEnregCateg'); rendreInvisible('divEnleverCateg'); rendreInvisible('descriptionErreurs'); \">".$connexion."</a>\n"; 
	echo "            </li>\n"; 
}

if($admin===false && $courriel!=="") {
	echo "            <li class=\"nav-item\">\n"; 
	echo "              <a class=\"nav-link\" href=\"#\"><form id=\"formPanier\" action=\"serveur/gestionMembres.php\" method=\"POST\">
	<input type=\"hidden\" value=\"panier\" name=\"operation\"><input type=\"submit\" value=\"Panier\"></form></a>\n"; 
	echo "            </li>\n"; 
}

if($courriel!=="") {
	echo "            <li class=\"nav-item\">\n"; 
	echo "              <a class=\"nav-link\" href=\"#\"><form id=\"formDeconnexion\" action=\"serveur/gestionMembres.php\" method=\"POST\">
	<input type=\"hidden\" value=\"deconnexion\" name=\"operation\"><input type=\"submit\" value='".$deconnexion."'></form></a>\n"; 
	echo "            </li>\n"; 
}

echo "		</ul>\n"; 
echo "        </div>\n"; 
echo "      </div>\n"; 
echo "    </nav>\n";
echo $msg;
?>