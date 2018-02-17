

	// JavaScript Document
	
	// Delete
	function OrderDel(QoId){
		if (confirm('Do You Want Delete this Quotation?')) {
			window.location.href = 'processquote.php?action=delete&QoId=' + QoId;
		}
	}
	


