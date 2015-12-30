// javascript doc for pthTestSampleReject.jsp
function validateForm (sReject)
{
	if (document.sReject.description.value == "")
	{
		alert ("Error: The description for the rejection of sample is necessary\nPlease try agian!");
		document.sReject.description.focus (); 
		return false ;
	}
}
