// JavaScript document for toIssueMedicine.jsp

function validateForm (toIssueBalanceMeds)
{
	var validChars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~-!@#$%^&*()_+|}{\"><.?/;:";
	var spaceChar = " ";
	var validDigs="0123456789";

	if (document.toIssueBalanceMeds.pid.value == "" || document.toIssueBalanceMeds.pid.value == 0)
	{
		alert ("Error: Invalid Patient ID, Please enter valid value");
		document.forms.toIssueBalanceMeds.pid.focus();
		return false;
	}
	
	for (var i=0;i<document.forms.toIssueBalanceMeds.pid.value.length;i++)
	{
		temp=document.forms.toIssueBalanceMeds.pid.value.substring(i,i+1)


		if (validDigs.indexOf(temp)==-1  && document.forms.toIssueBalanceMeds.pid.value.substring(0,1) ==spaceChar)
   		{
			alert ("Error: Invalid Patient ID, Please enter valid value");
			document.forms.toIssueBalanceMeds.pid.focus();
			return false;
		}
		else if (validChars.indexOf(temp)>=0)
		{
    		alert ("Error: Invalid Patient ID, Please enter valid value");
			document.forms.toIssueBalanceMeds.pid.focus();
    		return false;
   		}
		
		else if (temp == spaceChar)
		{
    		alert ("Error: Invalid Patient ID, Please enter valid value");
			document.forms.toIssueBalanceMeds.pid.focus();
    		return false;
   		}
 	}
}