
<?php
	require_once '../library/config.php';
	require_once '../library/functions.php';
	checkUser();
	$action = isset($_GET['action']) ? $_GET['action'] : '';

	switch ($action) {
		case 'delete' :
			deleteFeedback($dbConn);
			break;
		case 'replyemail' :
			replyemail($dbConn);
			break;
			
		default :
			redirect('index.php');
	}
	
	//Reply Feedback
	function replyemail($dbConn) {
		$txtEmailid = mysqli_real_escape_string($dbConn, $_POST['txtEmailid']);
		$txtEmailFrom = "adnanghouri97@gmail.com";
		$txtmessage = mysqli_real_escape_string($dbConn, $_POST['txtmessage']);
		
		$strTo = $txtEmailid;
		
		$strSubject = "Travelites: ". $txtEmailid  ;
		$strHeader .= "MIME-Version: 1.0";
		$strHeader = "Content-type: text/html; charset=windows-874\n"; // or UTF-8 //
		
		$strHeader .= "From: " . "Travelites" . "<" . $txtEmailFrom . ">\n";
		$strMessage = "<table width='700' border='1' align='center' cellpadding='5' cellspacing='0' bordercolor='#CCCCCC' style='border-collapse:collapse; font-family:Arial, Helvetica, sans-serif; font-size:14px'>
		<tr>
			<td colspan='2' bgcolor='#999999' align='left'><strong>Form Travelites:</strong></td>
		</tr>
		<tr>
			<td width='250'><strong>Message:</strong></td>
			<td width='450'>" . $txtmessage . "</td>
		</tr>
		 <tr>
			 <td><strong>Email:</strong></td>
			 <td>" . $txtEmailFrom . "</td>
		 </tr>
		
		</table>";

		$flgSend = mail($strTo,$strSubject,$strMessage,$strHeader);  // @ = No Show Error //   
		if($flgSend){
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Message Send Successfully.";
			redirect("index.php");
		}else{
			$_SESSION['count'] = 0;
			$_SESSION['data'] = "success";
			$_SESSION['errorMessage'] = "Message Sending Failed due to some reasion.";
			redirect("index.php");
		}
	}
	
	//DELETE Feedback
	function deleteFeedback($dbConn) {
		if(isset($_GET['FeedbackId']) && ($_GET['FeedbackId'])>0 ){
			$FeedbackId = $_GET['FeedbackId'];
		}else{
			redirect("index.php");
			exit();
		}
		$sql    =	"DELETE FROM tbl_contact WHERE con_id = $FeedbackId";		
		$result = 	 dbQuery($dbConn, $sql);
		$_SESSION['data'] = "danger";
		$_SESSION['errorMessage'] = "Message delete successfully.";
		redirect("index.php");
	}
	
	

?>