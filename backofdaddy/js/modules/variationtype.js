	
	// JavaScript Document
	// ADD Variation Type
	function addVarType(){
		window.location.href = 'index.php?view=add';
	}
	// MODIFY Variation Type
	function modifyVarType(VarType){
		window.location.href = 'index.php?view=modify&VarType=' + VarType;
	}
	// Delete Variation Type
	function deleteVarType(VarType){
		if (confirm('Do You Want Delete this Variation Type?')) {
		window.location.href = 'processvartype.php?action=delete&VarType=' + VarType;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	