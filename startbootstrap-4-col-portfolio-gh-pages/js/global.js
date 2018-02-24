function rendreVisible(elem){
	document.getElementById(elem).style.display='block';
}

function rendreInvisible(elem){
	document.getElementById(elem).style.display='none';
}

function lister(){
	document.getElementById('formLister').submit();
}

function listerCateg(){
	document.getElementById('formListerCateg').submit();
}

function validerNum(elem){
	var num=document.getElementById(elem).value;
	var numRegExp=new RegExp("^[0-9]{1,4}$");
	if(num!="" && numRegExp.test(num))
		return true;
	else {
		var err = document.getElementById("descriptionErreurs");
		err.innerHTML = "Veuillez utiliser seulement des caracteres numeriques, de 1 a 4 caracteres svp!";
		rendreVisible("descriptionErreurs");
	}
	return false;
}

function validerString(elem){
	var num=document.getElementById(elem).value;
	var numRegExp=new RegExp("^[a-zA-Z0-9]{2,30}$");
	if(num!="" && numRegExp.test(num))
		return true;
	else {
		var err = document.getElementById("descriptionErreurs");
		err.innerHTML = "Veuillez utiliser seulement des lettres et des chiffres, de 2 a 30 caracteres svp!";
		rendreVisible("descriptionErreurs");
	}
	return false;
}

function validerString2(elem){
	var num=document.getElementById(elem).value;
	var numRegExp=new RegExp("^[a-zA-Z]{2,30}$");
	if(num!="" && numRegExp.test(num))
		return true;
	else {
		//var err = document.getElementById("descriptionErreurs");
		//err.innerHTML = "Veuillez utiliser seulement des letteres, de 1 a 4 caracteres svp!";
		//rendreVisible("descriptionErreurs");
		//alert("Veuillez utiliser seulement des letteres, de 1 a 4 caracteres svp!");
	}
	return false;
}

function valider(){
	var titre=document.getElementById('titre').value;  
	var duree=document.getElementById('duree').value; 
	var res=document.getElementById('res').value; 
	var categ=document.getElementById('categ').value; 
	var prix=document.getElementById('prix').value; 
	var numRegExp1=new RegExp("^[0-9]{1,4}$"); //prix, duree
	var numRegExp2=new RegExp("^[a-zA-Z0-9]{2,30}$"); //res, titre
	var numRegExp3=new RegExp("^[1-7]$"); //categ
	if(titre!="" && duree!="" && res!="" && categ!="" && prix!="") {
		if(numRegExp1.test(categ) && numRegExp1.test(prix) && numRegExp1.test(duree) && numRegExp2.test(res) && numRegExp2.test(titre)) {
			return true; 
		}
		else {
			var err = document.getElementById("descriptionErreurs");
			err.innerHTML = "Veuillez utiliser des 1 a 4 chiffres pour le prix et la duree, de 2 a 30 lettres pour le realisateur et le titre, les chiffres 1 a 7 pour la categorie!";
			rendreVisible("descriptionErreurs");
		}
	} else {
		var err = document.getElementById("descriptionErreurs");
			err.innerHTML = "Il faut completer tous les champs!";
			rendreVisible("descriptionErreurs");
	}
	return false;
}

function creerElementsListes() {
	var listeAge = document.getElementById("age");
	for(var i=16; i<81; i++) {
		var options = document.createElement("option");
		options.textContent = i;
		options.value = i;
		listeAge.appendChild(options);
	}
	
	var listeAge2 = document.getElementById("age3");
	for(var i=16; i<81; i++) {
		var options = document.createElement("option");
		options.textContent = i;
		options.value = i;
		listeAge2.appendChild(options);		
	}	
	
}

function validerConnexion() {
	if(!validerCourriel("courriel")) {
		var err = document.getElementById("descriptionErreurs");
		err.innerHTML = "Veuillez fournir un courriel valide svp!";
		rendreVisible("descriptionErreurs");
		return false;
	}
	if(!validerMDP("mdp")) {
		var err = document.getElementById("descriptionErreurs");
		err.innerHTML = "Veuillez fournir un mot de passe valide contenant de 6 a 8 lettres et/ou chiffres!";
		rendreVisible("descriptionErreurs");
		return false;
	}
	return true;
}

function validerCourriel(courriel) {
	var email=document.getElementById(courriel).value;
	var numRegExp=new RegExp("^[a-zA-Z0-9_-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,3}$");
	if(email!="" && numRegExp.test(email))
		return true;
	return false;
}

function validerMDP(mdp) {
	var mdp=document.getElementById(mdp).value;
	var numRegExp=new RegExp("^[A-Za-z0-9]{6,8}$");
	if(mdp!="" && numRegExp.test(mdp))
		return true;
	return false;
}

function validerInscription() {
	var mdp = document.getElementById("mdp2").value;
	var cmdp = document.getElementById("cmdp2").value;
	var nom = document.getElementById("nom").value;
	var prenom = document.getElementById("prenom").value;
	var email = document.getElementById("courriel2").value;
	if (!(mdp!="" && cmdp!="" && nom!="" && prenom!="" && email!="")) {
		var err = document.getElementById("descriptionErreurs");
		err.innerHTML = "Veuillez completer tous les champs svp!";
		rendreVisible("descriptionErreurs");
		return false;
	}
	if(!validerString('nom')) return false;
	if(!validerString('prenom')) return false;
	if(!validerCourriel("courriel2")) {
		var err = document.getElementById("descriptionErreurs");
		err.innerHTML = "Veuillez fournir un courriel valide svp!";
		rendreVisible("descriptionErreurs");
		return false;
	}
	if(!validerMDP("mdp2") || !validerMDP("cmdp2")) {
		var err = document.getElementById("descriptionErreurs");
		err.innerHTML = "Veuillez fournir un mot de passe valide contenant de 6 a 8 lettres et/ou chiffres!";
		rendreVisible("descriptionErreurs");
		return false;
	}
	if(mdp!==cmdp) {
		var err = document.getElementById("descriptionErreurs");
		err.innerHTML = "Le mot de passe et la confirmation ne coincident pas!";
		rendreVisible("descriptionErreurs");
		return false;
	}
	
	return true;
}

function validerProfil() {
	var mdp = document.getElementById("mdp3").value;
	var cmdp = document.getElementById("cmdp3").value;
	var nom = document.getElementById("nom3").value;
	var prenom = document.getElementById("prenom3").value;
	var email = document.getElementById("courriel3").value;
	if (!(mdp!="" && cmdp!="" && nom!="" && prenom!="" && email!="")) {
		var err = document.getElementById("descriptionErreurs");
		err.innerHTML = "Veuillez completer tous les champs svp!";
		rendreVisible("descriptionErreurs");
		return false;
	}
	if(!validerString('nom3')) return false;
	if(!validerString('prenom3')) return false;
	if(!validerCourriel("courriel3")) {
		var err = document.getElementById("descriptionErreurs");
		err.innerHTML = "Veuillez fournir un courriel valide svp!";
		rendreVisible("descriptionErreurs");
		return false;
	}
	if(!validerMDP("mdp3") || !validerMDP("cmdp3")) {
		var err = document.getElementById("descriptionErreurs");
		err.innerHTML = "Veuillez fournir un mot de passe valide contenant de 6 a 8 lettres et/ou chiffres!";
		rendreVisible("descriptionErreurs");
		return false;
	}
	if(mdp!==cmdp) {
		var err = document.getElementById("descriptionErreurs");
		err.innerHTML = "Le mot de passe et la confirmation ne coincident pas!";
		rendreVisible("descriptionErreurs");
		return false;
	}
	
	return true;
}


//Cas d'un button
/*
function valider(){
	var formEnreg=document.getElementById('formEnreg');
	var num=document.getElementById('num').value;
	var titre=document.getElementById('titre').value;
	var duree=document.getElementById('duree').value;
	var res=document.getElementById('res').value;
	var numRegExp=new RegExp("^[0-9]{1,4}$");
	if(num!="" && titre!="" && duree!="" && res!="")
		if(numRegExp.test(num))
			formEnreg.submit();
}
*/