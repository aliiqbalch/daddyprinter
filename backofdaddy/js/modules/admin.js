// JavaScript Document
	function checkEmail() {
		var email = document.getElementById('txtEmail');
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!filter.test(email.value)) {
			alert('Please provide a valid email address');
			email.focus;
			return false;
		}
	}
	function addUser(){
		window.location.href = 'index.php?view=add';
	}

	function modifyUser(userId){
		window.location.href = 'index.php?view=modify&userId=' + userId;
	}
	function deleteUser(userId){
		if (confirm('Do You Want Delete this Admin / User?')) {
			window.location.href = 'processAdmin.php?action=delete&userId=' + userId;
		}
	}



