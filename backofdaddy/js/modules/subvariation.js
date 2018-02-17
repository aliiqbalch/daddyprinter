	
	// JavaScript Document
	// ADD Sub variation
	function addSubVar(){
		window.location.href = 'index.php?view=add';
	}
	
	// Delete Sub variation
	function deleteSubVar(SVId){
		if (confirm('Do You Want Delete this Sub variation?')) {
		window.location.href = 'processvarsub.php?action=delete&SVId=' + SVId;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	