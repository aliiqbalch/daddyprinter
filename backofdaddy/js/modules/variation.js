	
	// JavaScript Document
	// ADD variation
	function addVar(){
		window.location.href = 'index.php?view=add';
	}
	// MODIFY variation
	function modifyVar(VarId){
		window.location.href = 'index.php?view=modify&VarId=' + VarId;
	}
	// Delete variation
	function deleteVar(VarId){
		if (confirm('Do You Want Delete this variation?')) {
		window.location.href = 'processvar.php?action=delete&VarId=' + VarId;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	