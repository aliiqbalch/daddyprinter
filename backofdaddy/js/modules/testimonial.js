	
	// JavaScript Document
	// ADD
	function addTestimonials(){
		window.location.href = 'index.php?view=add';
	}
	// MODIFY Affiliation
	function modifyTes(TestId){
		window.location.href = 'index.php?view=modify&TestId=' + TestId;
	}
	// Delete Affiliation
	function deleteTes(TestId){
		if (confirm('Do You Want Delete this Testimonials?')) {
			window.location.href = 'processtesti.php?action=delete&TestId=' + TestId;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	