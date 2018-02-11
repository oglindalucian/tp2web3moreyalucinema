<?php
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
echo "					<li class=\"nav-item\"><a href=\"#\" onClick=\"rendreVisible('divEnregCateg'); rendreInvisible('lesFilms'); rendreInvisible('divFicheCateg'); rendreInvisible('divEnleverCateg'); rendreInvisible('foot');\">Enregistrer</a></li>\n"; 
echo "					<li class=\"nav-item\"><a href=\"#\" onClick=\"listerCateg(); rendreInvisible('lesFilms');\" >Lister</a></li>\n"; 
echo "					<li class=\"nav-item\"><a href=\"#\" onClick=\"rendreVisible('divFicheCateg'); rendreInvisible('lesFilms'); rendreInvisible('divEnregCateg'); rendreInvisible('divEnleverCateg'); rendreInvisible('foot');\">Modifier</a></li>\n"; 
echo "					<li class=\"nav-item\"><a href=\"#\" onClick=\"rendreVisible('divEnleverCateg'); rendreInvisible('lesFilms'); rendreInvisible('divFicheCateg'); rendreInvisible('divEnregCateg'); rendreInvisible('foot');\">Enlever</a></li>					\n"; 
echo "				</ul> \n"; 
echo "            </li></div>	         \n"; 
 
echo "			  <div class=\"multipleOptions\"><li class=\"dropdown\" class=\"nav-item\" ><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" class=\"nav-link\" href=\"#\">Films <span class=\"caret\"></span></a>\n"; 
echo "				 <ul class=\"dropdown-menu\">\n"; 
echo "					<li class=\"nav-item\"><a href=\"#\" onClick=\"rendreVisible('divEnreg'); rendreInvisible('lesFilms'); rendreInvisible('divFiche'); rendreInvisible('divEnlever'); rendreInvisible('foot');\">Enregistrer</a></li>\n"; 
echo "					<li class=\"nav-item\"><a href=\"#\" onClick=\"lister(); rendreInvisible('lesFilms');\" >Lister</a></li>\n"; 
echo "					<li class=\"nav-item\"><a href=\"#\" onClick=\"rendreVisible('divFiche'); rendreInvisible('lesFilms'); rendreInvisible('divEnreg'); rendreInvisible('divEnlever'); rendreInvisible('foot');\">Modifier</a></li>\n"; 
echo "					<li class=\"nav-item\"><a href=\"#\" onClick=\"rendreVisible('divEnlever'); rendreInvisible('lesFilms'); rendreInvisible('divFiche'); rendreInvisible('divEnreg'); rendreInvisible('foot');\">Enlever</a></li>					\n"; 
echo "				</ul> \n"; 
echo "            </li></div>	         \n"; 

echo "            <li class=\"nav-item\">\n"; 
echo "              <a class=\"nav-link\" href=\"#\">Connexion</a>\n"; 
echo "            </li>\n"; 
echo "            <li class=\"nav-item\">\n"; 
echo "              <a class=\"nav-link\" href=\"#\">Panier</a>\n"; 
echo "            </li>\n"; 
echo "            <li class=\"nav-item\">\n"; 
echo "              <a class=\"nav-link\" href=\"#\">Déconnexion</a>\n"; 
echo "            </li>\n"; 
echo "		</ul>\n"; 
echo "        </div>\n"; 
echo "      </div>\n"; 
echo "    </nav>\n";
?>