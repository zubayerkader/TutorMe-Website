function cancelAppointment(sid, tid, cid)
{
	//document.getElementById("appointments").innerHTML = sid + tid + cid;
	var url = "http://localhost:8888/studentDashboardUtility.php?function=cancelAppointment&sid=" + sid + "&tid=" + tid + "&cid=" + cid;
	
	var xhr = new XMLHttpRequest();
	xhr.open("GET", url, true);
	xhr.onreadystatechange = function () 
	{
	    if (this.readyState == 4 && this.status == 200) 
	    {
			window.location.href = window.location.href;
		}
	};
	xhr.send();
}

function cancelRequest(sid, tid, cid)
{
	var url = "http://localhost:8888/studentDashboardUtility.php?function=cancelRequest&sid=" + sid + "&tid=" + tid + "&cid=" + cid;
	
	var xhr = new XMLHttpRequest();
	xhr.open("GET", url, true);
	xhr.onreadystatechange = function () 
	{		
	    if (this.readyState == 4 && this.status == 200) 
	    {
	    	window.location.href = window.location.href;
			//window.location.reload(true);
		}
	};
	xhr.send();
}