function LoginValidate(event){
    var a = document.getElementById("i1").value;
    var c = document.getElementById("i2").value;
	var validate = true;
	
    var email_v = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/; 
	var pswd_v = /^(\S*)?\d+(\S*)?$/;
	
	document.getElementById("email_msg").innerHTML="";
	document.getElementById("pswd_msg").innerHTML="";
	
	if(a == null || a=="" || Uname_v.test(a)==false){
		document.getElementById("email_msg").innerHTML="Username empty or wrong format. example: username@somewhere.sth";
		validate = false;
	}
	
	if(c == null || c=="" || c.length!=8||Pswd_v.test(c)==false){
		document.getElementById("pswd_msg").innerHTML="Please enter the password correctly(8 characters long, at least one non-letter)";
		validate = false;
	}
	
    if(validate==false){
        event.preventDefault();
    }
    
}