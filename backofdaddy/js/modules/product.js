	
	// JavaScript Document
	// ADD Product
	function addPro(){
		window.location.href = 'index.php?view=add';
	}
	// MODIFY Category
	function modifyPro(ProId){
		window.location.href = 'index.php?view=modify&PI=' + ProId;
	}
	// Delete Product
	function deletePro(ProId){
		if (confirm('Do You Want Delete this Product Infomation?')) {
		window.location.href = 'processpro.php?action=delete&ProId=' + ProId;
		}
	}
	// View Product
	function viewpro(ProId){
		window.location.href = 'index.php?view=detail&PI=' + ProId;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	