function SignUpForm(event){ 
    var result = true;
    
    var elements = event.currentTarget;
    var a = elements[1].value;
    var b = elements[0].value;
    var c = elements[2].value;
    var d = elements[3].value;
    
    var email_v = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/; 
	var uname_v = /^[a-zA-Z0-9_-]+$/;
	var pswd_v = /^(\S*)?\d+(\S*)?$/;

    document.getElementById("email_msg").innerHTML ="";
	document.getElementById("uname_msg").innerHTML ="";
	document.getElementById("pswd_msg").innerHTML ="";
	document.getElementById("pswdr_msg").innerHTML ="";
 
	if (a==null || a =="" || email_v.test(a) == false){
			
		document.getElementById("email_msg").innerHTML="Email address empty or wrong format. example: username@somewhere.sth";
		result = false;
		}
		
	if (b==null || b=="" ||uname_v.test(b) == false){  
	    document.getElementById("uname_msg").innerHTML="Please enter the correct format for Username. (No leading or trailing spaces)";
	    result = false;
    }

	if(c==null|| c =="" || c.length != 8 || pswd_v.test(c)==false){
		document.getElementById("pswd_msg").innerHTML="Please enter the password correctly(8 characters long, at least one non-letter)";
		result = false;
	}
		
	if(c!=null && c !=""){
		if(d!= c){
			document.getElementById("pswdr_msg").innerHTML="The comfirmed password should be the same as the password above";
			result = false;
		}
	}
		
    if(result==false){
      event.preventDefault();
    }
}