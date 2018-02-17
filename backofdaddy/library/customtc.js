 $(document).ready(function(){
	// hide spend hours text field on doccument load
	$('#spend_hours').hide(); 
			 
});
function showHideSpendHours(e){
	if(e.value=='S'){
		$('#spend_hours').show();
	}
	else{
		$('#spend_hours').hide(); 
	}
}
