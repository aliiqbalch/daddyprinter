// JavaScript Document
function sendContact()
		{
		
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			}
		  }

			var company		=	document.getElementById('userCompany').value;
			var name	 	= 	document.getElementById('userName').value;
			var email	 	= 	document.getElementById('userEmail').value;
			var phone 		= 	document.getElementById('userPhone').value;
			var message 	= 	document.getElementById('userMsg').value;
			
			var str 		= 	"?action=message&company=" + company + "&name=" + name + "&email=" + email + "&phone=" + phone + "&message=" + message;  
  
xmlhttp.open("GET","contact-post.php"+ str,true);
xmlhttp.send();

		}

/*///////////////////////////////////////////////////////////////////////*/

