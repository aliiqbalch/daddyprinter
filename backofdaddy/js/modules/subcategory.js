	
	// JavaScript Document
	// ADD Category
	function addSubCat(){
		window.location.href = 'index.php?view=add';
	}
	// MODIFY Category
	function modifySubCat(SCI){
		window.location.href = 'index.php?view=modify&SCI=' + SCI;
	}
	// Delete Category
	function deleteSubCat(SCI){
		if (confirm('Do You Want Delete this Sub Category?')) {
		window.location.href = 'processsubcat.php?action=delete&SCI=' + SCI;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	