
	function isalphanum(ele)
	{
		var r=/\W$/i;
		if(r.test(ele.value))
		 {
			 //alert("This Field allows Only Alpha Numeric characters.");
			  document.getElementById("demo").innerHTML ="<img src='../images/info.png' width='15' height='15' alt='info' />&nbsp;                                         Only Alpha Numeric Characters."
			  
			  
			 ele.value="";
			 ele.focus();
		 }
	}
	
	function isalpha(ele)
	{
		var r=/[^a-zA-Z ]+/i;
		if(r.test(ele.value))
		 {
			 var d = ele.parentElement;
			 //var d = document.getElementById("div1");
			 ///alert(d);
			 d.className = d.className.replace(/\bhas-error\b/,''); //+ " has-error";
			 d.className = d.className + " has-error";
			 //alert(d.className);
			 //alert("This Field allows Only Alphabets.");
			 //document.getElementById("demo").innerHTML ="<img src='../images/info.png' width='15' height='15' alt='info' />&nbsp;				                                          Only Alphabets"
			 //ele.value="";
			 //ele.focus();
		 }
		 else{
			 var d = ele.parentElement;
			 //var d = document.getElementById("div1");
			 //alert(d);
			 d.className = d.className.replace(/\bhas-error\b/,''); //+ " has-error";
			 //document.getElementById("MyID").className.replace(/\bMyClass\b/,'');
			 //document.getElementById("demo").innerHTML =""
		 }
	}
	
	
	function isnum(ele)
	{
		var r=/^[0-9]+$/; // /\D$/i;
		//alert(ele.value);
		if(r.test(ele.value))
		 {
			 var d = ele.parentElement;
			 //var d = document.getElementById("div1");
			 //alert(d);
			 d.className = d.className.replace(/\bhas-error\b/,''); //+ " has-error";
			 //document.getElementById("MyID").className.replace(/\bMyClass\b/,'');
			 //document.getElementById("demo").innerHTML =""
			 
		 }
		 else{
			 //alert(ele.value);
			 var d = ele.parentElement;
			 //var d = document.getElementById("div1");
			 ///alert(d);
			 d.className = d.className.replace(/\bhas-error\b/,''); //+ " has-error";
			 d.className = d.className + " has-error";
			 //alert(d.className);
			 //alert("This Field allows Only Alphabets.");
			 //document.getElementById("demo").innerHTML ="<img src='../images/info.png' width='15' height='15' alt='info' />&nbsp;				                                          Only Alphabets"
			 //ele.value="";
			 //ele.focus();
		 }
	}
	
	function isnum_length(ele,max_length)
	{
		var r = new RegExp('/^[0-9]{1,'+max_length+'}$/}', 'gi');
		//var r=/^[0-9]{1,max_length}$/; // /\D$/i;
		//alert(ele.value);
		if(r.test(ele.value))
		 {
			 var d = ele.parentElement;
			 //var d = document.getElementById("div1");
			 //alert(d);
			 d.className = d.className.replace(/\bhas-error\b/,''); //+ " has-error";
			 //document.getElementById("MyID").className.replace(/\bMyClass\b/,'');
			 //document.getElementById("demo").innerHTML =""
			 
		 }
		 else{
			 //alert(ele.value);
			 var d = ele.parentElement;
			 //var d = document.getElementById("div1");
			 ///alert(d);
			 d.className = d.className.replace(/\bhas-error\b/,''); //+ " has-error";
			 d.className = d.className + " has-error";
			 //alert(d.className);
			 //alert("This Field allows Only Alphabets.");
			 //document.getElementById("demo").innerHTML ="<img src='../images/info.png' width='15' height='15' alt='info' />&nbsp;				                                          Only Alphabets"
			 //ele.value="";
			 //ele.focus();
		 }
	}
	
	function ValidateEmail(ele)
	{
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/; 
		if(mailformat.test(ele.value))
		 {
			 var d = ele.parentElement;
			 //var d = document.getElementById("div1");
			 ///alert(d);
			 d.className = d.className.replace(/\bhas-error\b/,''); //+ " has-error";
			 //alert(d.className);
			 //alert("This Field allows Only Alphabets.");
			 //document.getElementById("demo").innerHTML ="<img src='../images/info.png' width='15' height='15' alt='info' />&nbsp;				                                          Only Alphabets"
			 //ele.value="";
			 //ele.focus();
		 }
		 else{
			 var d = ele.parentElement;
			 //var d = document.getElementById("div1");
			 //alert(d);
			 d.className = d.className.replace(/\bhas-error\b/,''); //+ " has-error";
			 d.className = d.className + " has-error";
			 //d.className = d.className.replace(/\bhas-error\b/,''); //+ " has-error";
			 //document.getElementById("MyID").className.replace(/\bMyClass\b/,'');
			 //document.getElementById("demo").innerHTML =""
		 }
	}
	
	/*function isalpham(ele)
	{
		var r=/[^a-zA-Z ]+/i;
		if(r.test(ele.value))
		 {
			 //alert("This Field allows Only Alphabets.");
			 document.getElementById("mn").innerHTML ="<img src='../images/info.png' width='15' height='15' alt='info' />&nbsp;				                                          Only Alphabets"
			 ele.value="";
			 ele.focus();
		 }
		 else{
			 document.getElementById("mn").innerHTML =""
		 }
	}
	function isalphal(ele)
	{
		var r=/[^a-zA-Z ]+/i;
		if(r.test(ele.value))
		 {
			 //alert("This Field allows Only Alphabets.");
			 document.getElementById("ln").innerHTML ="<img src='../images/info.png' width='15' height='15' alt='info' />&nbsp;				                                          Only Alphabets"
			 ele.value="";
			 ele.focus();
		 }
		 else{
			 document.getElementById("ln").innerHTML =""
		 }
	}*/
	/*function isnum(ele)
	{
		var r=/\D$/i;
		if(r.test(ele.value))
		 {
			 alert("This Field allows Only Numerics.");
			 document.getElementById("mbl").innerHTML ="<img src='../images/info.png' width='15' height='15' alt='info' />&nbsp;                                         Only Numerics."
			 ele.value="";
			 ele.focus();
		 }
		 else{
			 document.getElementById("mbl").innerHTML =""
		 }
	}*/
	
	/*function ValidateEmail(inputText)  
	{  
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
		if(inputText.value.match(mailformat))  
			{  
				inputText.focus();  
				return true;  
		}  
		else  
			{  
			//alert("You have entered an invalid email address!"); 
			 document.getElementById("email").innerHTML ="<img src='../images/info.png' width='15' height='15' alt='info' />&nbsp;                                         Invalid Email  Address!." 
			inputText.focus();  
			return false;  
		}  
	} */

	function validateform(mmyform)
	{                    
		myform=document.forms[mmyform];
		
		if(myform.name=="user_info")
		{	
			if( myform.first_name.value==""){
				alert("First Name is Empty.");
				myform.first_name.focus();
				return false;							
			}						
			if( myform.last_name.value==""){
				alert("Last is Empty.");
				myform.last_name.focus();
				return false;
			}
			if( myform.dob.value==""){
				alert("Date of Birth is Empty.");
				myform.dob.focus();
				return false;
			}
			if( myform.mobile_number.value==""){
				alert("Mobile Number is Empty.");
				myform.mobile_number.focus();
				return false;
			}						
			//alert('l');
			if( myform.email_id.value==""){
				alert("Email Id is Empty.");
				myform.email_id.focus();
				return false;
			}						
			if (document.getElementById("cboUser").selectedIndex == 0){
				 alert("Select User Type");
				 return false;
			 }
			if( myform.user_name.value==""){
				alert("Username is Empty.");
				myform.user_name.focus();
				return false;
			}
			if( myform.password.value==""){
				alert("password is Empty.");
				myform.password.focus();
				return false;
			}						
		} 
	}

	