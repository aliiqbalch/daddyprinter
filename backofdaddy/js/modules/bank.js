	
	// JavaScript Document Bank
	// ADD bank detail
	function addbank(){
		window.location.href = 'index.php?view=add';
	}
	// MODIFY bank
	function modifybank(BankId){
		window.location.href = 'index.php?view=modify&BankId=' + BankId;
	}
	
	// view acount detail page
	function accountdetail(BankId){
		window.location.href = 'index.php?view=accdetail&BankId=' + BankId;
	}
	// Add bank recept
	function addbankrecept(BankId){
		window.location.href = 'index.php?view=addrecept&BankId=' + BankId;
	}
	
	// Delete Category
	function deletecategory(CategoryId){
		if (confirm('Do You Want Delete this Category?')) {
		window.location.href = 'processcategory.php?action=delete&CategoryId=' + CategoryId;
		}
	}
	
	