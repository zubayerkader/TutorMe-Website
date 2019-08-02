var selectedCourse;
var selectedTutor;
var dateTimeCount = 0;
var dateTimeArray = [];

// function sendHttpRequest(method, url, data)
// {
// 	var response;
// 	var xhr = new XMLHttpRequest();
// 	xhr.open(method, url, true);
// 	//xhr.setRequestHeader("Content-Type", "application/json");
// 	xhr.onreadystatechange = function () 
// 	{
// 	    if (this.readyState == 4 && this.status == 200) 
// 	    {
// 			response = JSON.parse(this.responseText);
// 		}
// 	};
// 	if (method == "GET" && data == null)
// 		xhr.send();
// 	else if (method == "POST" && data != null)
// 		xhr.send(data);

// 	return response;
// 	//console.log(response); //undefined
// }

function sendSearchQuery()
{
	resetVariables();

	var searchQuery = document.getElementById("searchQuery").value;
	var department = document.getElementById("selectDepartment").value;
	var url = "http://localhost:8888/getCourseTutor.php?function=getCourseList&course=" + searchQuery + "&department=" + department;
	//var response = sendHttpRequest("GET", url, null);
	//displayCourseList(sendHttpRequest("GET", url, null));

	var xhr = new XMLHttpRequest();
	xhr.open("GET", url, true);
	//xhr.setRequestHeader("Content-Type", "application/json");
	xhr.onreadystatechange = function () 
	{
	    if (this.readyState == 4 && this.status == 200) 
	    {
			displayCourseList(this.responseText);
		}
	};
	xhr.send();
}

function displayCourseList(courseData)
{
	var courseList = JSON.parse(courseData);
	document.getElementById("courseList").innerHTML = "Course List";
	if (courseList.length > 0)
	{
		var table = "<table><tr><th>Course Name</th><th>Course Code</th><th>Select</th></tr>";
		for (var i = 0; i < courseList.length; i++) 
		{
			table += "<tr><td>" + courseList[i]["cname"] + "</td><td>" + courseList[i]["ccode"] + "</td><td><button onclick='getTutors(" + JSON.stringify(courseList[i]) + ")'>Select</button></td></tr>";
		};
		table += "</table>";
		document.getElementById("courseListBody").innerHTML = table;
	}
	else
	{
		document.getElementById("courseListBody").innerHTML = "No results found";
	}
}

function getTutors(course)
{
	//console.log(course);
	selectedCourse = course;

	document.getElementById("dateTime").innerHTML = "";
	document.getElementById("dateTimeBody").innerHTML = "";
	document.getElementById("addMore").innerHTML = "";
	document.getElementById("bookAppointmentButton").innerHTML = "";

	var url = "http://localhost:8888/getCourseTutor.php?function=getTutors&cid=" + course["cid"];
	
	var xhr = new XMLHttpRequest();
	xhr.open("GET", url, true);
	//xhr.setRequestHeader("Content-Type", "application/json");
	xhr.onreadystatechange = function () 
	{
	    if (this.readyState == 4 && this.status == 200) 
	    {
			//document.getElementById("demo1").innerHTML = this.responseText;
			displayTutorList(this.responseText);
		}
	};
	xhr.send();
}

function displayTutorList(tutorData)
{
	var tutorList = JSON.parse(tutorData);
	//console.log(tutorList);
	document.getElementById("tutorList").innerHTML = "Tutor List show for " + selectedCourse["cname"];
	if (tutorList.length > 0)
	{
		var table = "<table><tr><th>Tutor Name</th><th>Qualification</th><th>Rating</th><th>Select</th></tr>";
		for (var i = 0; i < tutorList.length; i++) 
		{
			table += "<tr><td>" + tutorList[i]["fname"] + " " + tutorList[i]["lname"] + "</td><td>" + tutorList[i]["qualification"] + "</td><td>" + tutorList[i]["rating"] + "</td><td>" + "<button onclick='bookAppointment(" + JSON.stringify(tutorList[i]) + ")'>Book Appointment</button>" + "</td></tr>";
		};
		table += "</table>";
		document.getElementById("tutorListBody").innerHTML = table;
	}
	else
	{
		document.getElementById("tutorListBody").innerHTML = "No results found";
	}
}

function bookAppointment(tutor)
{
	//console.log(tutor);
	//console.log(course);

	selectedTutor = tutor;
	document.getElementById("dateTime").innerHTML = "Provide Date-Time-Location for: <br> " + tutor["fname"] + " "+ tutor["lname"];
	dateTimeCount = 0;
	addDateTimeFields();
	document.getElementById("addMore").innerHTML = '<a href="javascript: addDateTimeFields()">Add More</a><br><br>';
	document.getElementById("bookAppointmentButton").innerHTML = '<button onclick="sendNotification()">Send Request to Tutor</button><br>';
	document.getElementById("tutorList").innerHTML = "";
	document.getElementById("tutorListBody").innerHTML = "";

}

function sendNotification()
{
	//console.log(selectedTutor);
	//console.log(selectedCourse);
	getDateTime();
	var obj = {
		SelectedCourse: selectedCourse,
		SelectedTutor: selectedTutor,
		Time: dateTimeArray
	};
	var data = JSON.stringify(obj);

	// for (var i = 0; i < dateTimeArray.length; i++) {
	// 	console.log(dateTimeArray[i]);
	// };

	//console.log(obj);

	var xhr = new XMLHttpRequest();
	xhr.open("POST", "http://localhost:8888/sendNotification.php", true);
	xhr.setRequestHeader("Content-Type", "application/json");
	xhr.onreadystatechange = function () 
	{
	    if (this.readyState == 4 && this.status == 200) 
	    {
			resetVariables();
			document.getElementById("success").innerHTML = "Request sent. <br>Please check Dashboard to check if request has been accepted by Tutor. <br>";
			console.log(this.responseText);
		}
	};
	xhr.send(data);

}

function getDateTime() //gets date time and location
{
	for (var i = 0; i < dateTimeCount; i++) 
	{
		var dateHTML = document.getElementById("date-" + (i+1)).value;
		var fromHTML =  document.getElementById("from-" + (i+1)).value;
		var toHTML = document.getElementById("to-" + (i+1)).value;
		var HRS = Math.abs((fromHTML[0]+fromHTML[1]) - (toHTML[0]+toHTML[1]));
		var MINS = Math.abs((fromHTML[3]+fromHTML[4]) - (toHTML[3]+toHTML[4]));
		var locationHTML = document.getElementById("location-" + (i+1)).value;
		var dateTime = {date: dateHTML, from: fromHTML, to: toHTML, hrs: HRS, mins: MINS, location: locationHTML};
		dateTimeArray.push(dateTime);
	};
}

function addDateTimeFields()
{
	dateTimeCount++;
	var adddateTime = '<label for="date">Date: </label><input type="date" id="date-' + dateTimeCount + '"><label for="from">From: </label><input type="time" id="from-' + dateTimeCount + '"><label for="to">To: </label><input type="time" id="to-' + dateTimeCount + '"><label for="location">Location: </label><input type="text" id="location-' + dateTimeCount + '"> <br><br>'
	document.getElementById("dateTimeBody").innerHTML += adddateTime; 
}

function resetVariables()
{
	document.getElementById("courseList").innerHTML = "";
	document.getElementById("courseListBody").innerHTML = "";
	document.getElementById("tutorList").innerHTML = "";
	document.getElementById("tutorListBody").innerHTML = "";
	document.getElementById("dateTime").innerHTML = "";
	document.getElementById("dateTimeBody").innerHTML = "";
	document.getElementById("addMore").innerHTML = "";
	document.getElementById("bookAppointmentButton").innerHTML = "";
	document.getElementById("success").innerHTML = "";
	selectedTutor = null;
	selectedCourse = null;
	dateTimeCount = 0;
	dateTimeArray = [];
}




