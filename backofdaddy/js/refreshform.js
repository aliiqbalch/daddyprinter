$(document).ready(function(){  
$("#submit").click(function(){
var company = $("#company").val();
var name = $("#name").val();
var email = $("#email").val();
var phone = $("#phone").val();
var msg = $("#msg").val();
// Returns successful data submission message when the entered information is stored in database.
$.post("contact-post.php",{ userCompany: company, userName: name, userEmail: email, userPhone:phone, userMsg:msg},
			function(data) {
			alert(data);
			$('#form')[0].reset(); //To reset form fields
			});
    
});
});