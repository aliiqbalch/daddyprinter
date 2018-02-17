

	// JavaScript Document
	// ADD	
	function addClient(){
		window.location.href = 'index.php?view=add';
	}
	// DETAIL
	function detailclient(CliId){
		window.location.href = 'index.php?view=detail&CliId=' + CliId;
	}
	// UPDATE
	function clientUpdate(CliId){
		window.location.href = 'index.php?view=modify&CliId=' + CliId;
	}
	
	// Delete
	function deleteClient(CliId){
		if (confirm('Do You Want Delete this Client?')) {
			window.location.href = 'processClient.php?action=delete&CliId=' + CliId;
		}
	}


