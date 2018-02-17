	
	// JavaScript Document
	// ADD Category
	function addModule(){
		window.location.href = 'index.php?view=add';
	}
	// MODIFY Category
	function modifyMod(ModId){
		window.location.href = 'index.php?view=modify&ModId=' + ModId;
	}
	// Delete Category
	function deleteMod(ModId){
		if (confirm('Do You Want Delete this Module?')) {
		window.location.href = 'processmod.php?action=delete&ModId=' + ModId;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	