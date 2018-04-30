// Autofresh Ajax code 

function AutoRefresh(t) {
	   setTimeout("location.reload(true);", t);
	}

function blogLike(blogID){
	var blogLikeRequest = new XMLHttpRequest();
	var error=blogID+"B1";
	var num=blogID+"Ba";
	blogLikeRequest.onreadystatechange = function() {
        if (blogLikeRequest.readyState == 4 && blogLikeRequest.status == 200) {
           	var results = blogLikeRequest.responseText;
           	if(results==0){
				document.getElementById(error).innerHTML="You have left your feeling already";
               	}
           	else{
           		document.getElementById(num).innerHTML= results;
               	}	           
        }
	}
    blogLikeRequest.open("POST", "like.php", true);
    blogLikeRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    blogLikeRequest.send("blogID="+ blogID);
}

function repostLike(repostID){
	var repostLikeRequest = new XMLHttpRequest();
	var error=repostID+"R1";
	var num=repostID+"Ra";
	repostLikeRequest.onreadystatechange = function() {
        if (repostLikeRequest.readyState == 4 && repostLikeRequest.status == 200) {
           	var results = repostLikeRequest.responseText; 
           	if(results==0){
				document.getElementById(error).innerHTML="You have left your feeling already";
               	}	  
           	else{
           		document.getElementById(num).innerHTML= results;
               	}		            
        }
	}
    repostLikeRequest.open("POST", "like.php", true);
    repostLikeRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    repostLikeRequest.send("repostID="+ repostID);
}

function blogDislike(blogID){
	var xmlhttp = new XMLHttpRequest();
	var error=blogID+"B2";
	var num=blogID+"Bb";
	xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
           	var results = xmlhttp.responseText;   	
           	if(results==0){
				document.getElementById(error).innerHTML="You have left your feeling already";
               	}
           	else{
           		document.getElementById(num).innerHTML= results;
               	}		 	            
        }
	}
    xmlhttp.open("POST", "dislike.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("blogID="+ blogID);
}

function repostDislike(repostID){
	var xmlhttp = new XMLHttpRequest();
	var error=repostID+"R2";
	var num=repostID+"Rb";
	xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
           	var results = xmlhttp.responseText;  
           	if(results==0){
				document.getElementById(error).innerHTML="You have left your feeling already";
               	}
           	else{
           		document.getElementById(num).innerHTML= results;
               	}	 		            
        }
	}
    xmlhttp.open("POST", "dislike.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("repostID="+ repostID);
}

function getAll(){
	var step1 = new XMLHttpRequest();
	var output="";
	step1.onreadystatechange = function() {
        if (step1.readyState == 4 && step1.status == 200) {
            output+="<p>Post are showing as follow:</p>";
            var result1 = JSON.parse(step1.responseText); 
            console.log(result1.length) 
            if (result1.length>0){
            	for (var i = 0; i < result1.length; i++) 
                {
                    var json_result = result1[i];
                    output+=json_result;
                }
            }       
        }
	}
    step1.open("POST", "getP.php", true);
    step1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    step1.send();


    var step2 = new XMLHttpRequest();
    step2.onreadystatechange = function() {
        if (step2.readyState == 4 && step2.status == 200) {
        	output +="<p>Repost are showing as follow:</p>";
            var result2 = JSON.parse(step2.responseText); 
            console.log(result2.length) 
            if (result2.length>0){
            	for (var i = 0; i < result2.length; i++) 
                {
                    var json_result = result2[i];
                    output+=json_result;
                }
            }       
        }
        document.getElementById("atk").innerHTML = output;
    }
    step2.open("POST", "getR.php", true);
    step2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    step2.send();
}
