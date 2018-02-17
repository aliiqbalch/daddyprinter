// JavaScript Document
function addStudent()
{
//if (str=="")
  //{
 // document.getElementById("txtHint").innerHTML="";
 // return;
 // }
 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }

	var classId				=		document.getElementById('hidClassId').value;
	var studentRollNo 		= 		document.getElementById('txtRollNo').value;
	var studentName 		= 		document.getElementById('txtStudentName').value;
	var fatherName 			= 		document.getElementById('txtFatherName').value;
	var regNo	 			= 		document.getElementById('txtRegNo').value;
		
	var str 		= 	"?action=add&classid=" + classId + "&srollno=" + studentRollNo + "&sname=" + studentName + "&fname=" + fatherName + "&regno=" + regNo;
	//alert(str);
  
xmlhttp.open("GET","processStudents.php"+str,true);
xmlhttp.send();
}


////////////// For Delete ///////////////////////

function deleteRecord(id, classId)
{

	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
		}
	  }

	
	var str 		= 	"?action=delete&studentId=" + id + "&classid=" + classId;
	//alert(str);
  
xmlhttp.open("GET","processStudents.php"+str,true);
xmlhttp.send();
}


////////////// Get Student Name ///////////////////////

function getStudentName(id)
{

	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("studentName").innerHTML=xmlhttp.responseText;
		}
	  }

	
	var str 		= 	"?action=getName&studentId=" + id;
	//alert(str);
  
xmlhttp.open("GET","processResult.php"+str,true);
xmlhttp.send();
}


//////////////////////////////////// Add Marks ///////////////////

function addMarks()
{
 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }

	var resultInfo			=		document.getElementById('hidResultInfo').value;
	var studentCode			=		document.getElementById('cboStudentCode').value;
	var midMarks	 		= 		document.getElementById('txtMidMarks').value;
	var finalMarks 			= 		document.getElementById('txtFinalMarks').value;
	var sessionalMarks 		= 		document.getElementById('txtSessionalMarks').value;
		
	var str 		= 	"?action=add&resultInfo=" + resultInfo + "&studentCode=" + studentCode + "&midMarks=" + midMarks + "&finalMarks=" + finalMarks + "&sessionalMarks=" + sessionalMarks;
	//alert(str);
  
xmlhttp.open("GET","processMarks.php"+str,true);
xmlhttp.send();
}

//////////////////////////////////// Update Marks ///////////////////

function updateMarks(marksId, studentId)
{
 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }

	var actionCode			=		document.getElementById('actionCode' + studentId).value;
	var midMarks	 		= 		document.getElementById('txtMidMarks' + studentId).value;
	var finalMarks 			= 		document.getElementById('txtFinalMarks' + studentId).value;
	var sessionalMarks 		= 		document.getElementById('txtSessionalMarks' + studentId).value;
		
	var str 		= 	"?action=update&actionCode=" + actionCode + "&resultCode=" + marksId + "&studentCode="+ studentId +"&midMarks=" + midMarks + "&finalMarks=" + finalMarks + "&sessionalMarks=" + sessionalMarks;
	//alert(str);
  
xmlhttp.open("GET","processUpdateMarks.php"+str,true);
xmlhttp.send();
}


//////////////////////////////////// Load Programs ///////////////////

function getProgramInfo()
{
 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("info").innerHTML=xmlhttp.responseText;
    }
  }

	var programId	=	document.getElementById('cboProgram').value;
		
	var str 		= 	"?programId=" + programId;
	//alert(str);
  
xmlhttp.open("GET","loadProgramInfo.php"+str,true);
xmlhttp.send();
}

//////////////////////////////////// Add Course to Semester //////////////////////////////
function addSemesterCourse()
{
 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }

	var programId			=		document.getElementById('hidProgramId').value;
	var semesterId	 		= 		document.getElementById('hidSemesterId').value;
	var courseId	 		= 		document.getElementById('cboCourse').value;
		
	var str 		= 	"?action=addCourse&programId=" + programId + "&semesterId=" + semesterId + "&courseId=" + courseId;
	//alert(str);
  
xmlhttp.open("GET","processCourses.php"+str,true);
xmlhttp.send();
}

//////////////////////////////////// Delete Course to Semester //////////////////////////////
function deleteSemesterCourse(scId)
{
 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
	
	var programId			=		document.getElementById('hidProgramId').value;
	var semesterId	 		= 		document.getElementById('hidSemesterId').value;
		
	var str 		= 	"?action=delete&scId=" + scId + "&programId=" + programId + "&semesterId=" + semesterId;
	//alert(str);
  
xmlhttp.open("GET","processCourses.php"+str,true);
xmlhttp.send();
}

/////////////////////////////////////////////// Update Course ////////////////////////////

function updatCourse(courseid)
{
 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  
	var scId				=		document.getElementById('scId' + courseid).value;
	var courseId	 		= 		document.getElementById('cboCourse' + courseid).value;
	
	var programId			=		document.getElementById('hidProgramId').value;
	var semesterId	 		= 		document.getElementById('hidSemesterId').value;
		
	var str 		= 	"?action=update&courseId=" + courseId + "&scId=" + scId + "&programId=" + programId + "&semesterId=" + semesterId;
  
xmlhttp.open("GET","processCourses.php"+str,true);
xmlhttp.send();
}


//////////////////////////////////// Add Time Table /////////////////////////
function addTimetable() {
 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("showTimetable").innerHTML=xmlhttp.responseText;
    }
  }
  
 // alert(document.getElementById('ttInfoId').value);

	var ttInfoId			=		document.getElementById('hidTTInfoId').value;
	var courseId			=		document.getElementById('cboCourse').value;
	var facultyId	 		= 		document.getElementById('cboFaculty').value;
	var weekDays 			= 		document.getElementById('cboWeekDays').value;
	var ttTime		 		= 		document.getElementById('txtTime').value;
	
		
	var str 		= 	"?action=addTT&ttInfoId=" + ttInfoId + "&courseId=" + courseId + "&facultyId=" + facultyId + "&weekDays=" + weekDays + "&ttTime=" + ttTime;
	//alert(str);
  
xmlhttp.open("GET","manageTimetable.php"+str,true);
xmlhttp.send();
}

/*********** Delete Timetable Record ****************/
function deleteTimetableRec(id, ttInfoId)
{

	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("showTimetable").innerHTML=xmlhttp.responseText;
		}
	  }

		
	
	var str 		= 	"?action=delete&ttId=" + id + "&ttInfoId=" + ttInfoId;
	//alert(str);
  
xmlhttp.open("GET","manageTimetable.php"+str,true);
xmlhttp.send();
}
