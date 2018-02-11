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
	var numRegExp1=new RegExp("^[0-9]{1,4}$"); //categ, prix, duree
	var numRegExp2=new RegExp("^[a-zA-Z0-9]{2,30}$"); //res, titre
	if(titre!="" && duree!="" && res!="" && categ!="" && prix!="") {
		if(numRegExp1.test(categ) && numRegExp1.test(prix) && numRegExp1.test(duree) && numRegExp2.test(res) && numRegExp2.test(titre)) {
			return true; 
		}
		else {
			var err = document.getElementById("descriptionErreurs");
			err.innerHTML = "Veuillez utiliser des 1 a 4 chiffres pour la categorie, le prix et la duree et de 2 a 30 lettres pour le realisateur et le titre!";
			rendreVisible("descriptionErreurs");
		}
	} else {
		var err = document.getElementById("descriptionErreurs");
			err.innerHTML = "Il faut completer tous les champs!";
			rendreVisible("descriptionErreurs");
	}
	return false;
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