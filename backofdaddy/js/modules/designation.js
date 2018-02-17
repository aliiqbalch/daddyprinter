	
	// JavaScript Document
	// ADD Category
	function addDesig(){
		window.location.href = 'index.php?view=add';
	}
	// MODIFY Category
	function modifyDesig(DesigId){
		window.location.href = 'index.php?view=modify&DesigId=' + DesigId;
	}
	// Delete Category
	function deleteDesig(DesigId){
		if (confirm('Do You Want Delete this Designation?')) {
		window.location.href = 'processdesig.php?action=delete&DesigId=' + DesigId;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	