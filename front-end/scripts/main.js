function studentSignUp()
{
	/*
		take info from html form
		put it in DB
		load sign in page
	*/

	var fname = document.getElementbyID("fname").value;

	var lname = document.getElementbyID("lname").value;

	var email = document.getElementbyID("email").value;

	var pass = document.getElementbyID("pass").value;

	var cellphone = document.getElementbyID("cellphone").value;

	var gender;
	var radios = document.getElementsByName('genderS');
	for (var i = 0, length = radios.length; i < length; i++) 
	{
    	if (radios[i].checked) 
    	{
        	// do whatever you want with the checked radio
        	gender = radios[i].value;
        	// only one radio can be logically checked, don't check the rest
        	break;
    	}
	}

	var selectMajor = document.getElementbyID("selectMajor");
	var major = selectedMajor.options[selectedMajor.selectedIndex].value;

	var selectSchool = document.getElementbyID("selectSchool");
	var school = selectSchool.options[selectSchool.selectedIndex].value;

	/*var queryString = "insertSignUp.php?fname=" + fname +
									"&lname=" + lname +
									"&email=" + email +
									"&pass=" + pass +
									"&cellphone=" + cellphone +
									"&major=" + major +
									"&school=" + school;*/

	var xmlhttp = new XMLHttpRequest();
	var url = "url";
	xmlhttp.open("POST", url, true);
	xhr.setRequestHeader("Content-Type", "application/json");
	xhr.onreadystatechange = function () 
	{
	    if (xhr.readyState === 4 && xhr.status === 200) 
	    {
	        var json = JSON.parse(xhr.responseText);
	        console.log(json.email + ", " + json.password);
	    }
	};
	var obj = {
		"fname": ""
	};
	var data = JSON.stringify(obj);
	xhr.send(data);

	
	
	
	
}

function studentSignIn(){
	alert("abcd");
}

function tutorSignIn(){}

function tutorSignUp(){}