	
	// JavaScript Document
	// ADD Category
	function addCategory(){
		window.location.href = 'index.php?view=add';
	}
	// MODIFY Category
	function modifyCat(CatId){
		window.location.href = 'index.php?view=modify&CatId=' + CatId;
	}
	// Delete Category
	function deleteCat(CatId){
		if (confirm('Do You Want Delete this Category?')) {
		window.location.href = 'processcat.php?action=delete&CatId=' + CatId;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	