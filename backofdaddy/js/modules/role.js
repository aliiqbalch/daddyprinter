	
	// JavaScript Document
	// ADD Role
	function addRole(){
		window.location.href = 'index.php?view=add';
	}
	// MODIFY Role
	function modifyRole(DesId){
		window.location.href = 'index.php?view=modify&DesId=' + DesId;
	}
	// Delete Role
	function deleteROle(DesId){
		if (confirm('Do You Want Delete this Role?')) {
			window.location.href = 'processrol.php?action=delete&DesId=' + DesId;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	