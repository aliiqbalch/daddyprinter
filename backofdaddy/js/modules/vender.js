	
	// JavaScript Document
	// ADD Vender
	function addVender(){
		window.location.href = 'index.php?view=add';
	}
	// MODIFY Vender
	function modifyven(VenId){
		window.location.href = 'index.php?view=modify&VenId=' + VenId;
	}
	// Delete Vender
	function deleteVen(VenId){
		if (confirm('Do You Want Delete this Vender?')) {
			window.location.href = 'processven.php?action=delete&VenId=' + VenId;
		}
	}
	// Detail Vender
	function detailven(VenId){
		window.location.href = 'index.php?view=detail&VenId=' + VenId;
	}
	
	