function checkInput(event) {
	var a=document.getElementById("Blog")
	if (a.value.length > 150){ 
		a.value = a.value.substring(0, 150); 
		document.getElementById("notice").innerHTML = 'The input is over limit.'
	}
	else{
		document.getElementById("notice").innerHTML = 'Remain' + (150 - a.value.length) + 'words.';
	}
}