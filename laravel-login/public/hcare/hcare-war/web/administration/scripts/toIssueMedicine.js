// JavaScript document for toIssueMedicine.jsp

function validateForm (toIssueMeds)
{
	var validChars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~-!@#$%^&*()_+|}{\"><.?/;:";
	var spaceChar = " ";
	var validDigs="0123456789";

	if (document.toIssueMeds.pid.value == "" || document.toIssueMeds.pid.value == 0)
	{
		alert ("Error: Invalid Patient ID, Please enter valid value");
		document.toIssueMeds.pid.focus();
		return false;
	}
	
	for (var i=0;i<document.forms.toIssueMeds.pid.value.length;i++)
	{
		temp=document.forms.toIssueMeds.pid.value.substring(i,i+1)


		if (validDigs.indexOf(temp)==-1  && document.forms.toIssueMeds.pid.value.substring(0,1) ==spaceChar)
   		{
			alert ("Error: Invalid Patient ID, Please enter valid value");
			document.forms.toIssueMeds.pid.focus();
			return false;
		}
		else if (validChars.indexOf(temp)>=0)
		{
    		alert ("Error: Invalid Patient ID, Please enter valid value");
			document.forms.toIssueMeds.pid.focus();
    		return false;
   		}
		
		else if (temp == spaceChar)
		{
    		alert ("Error: Invalid Patient ID, Please enter valid value");
			document.forms.toIssueMeds.pid.focus();
    		return false;
   		}
 	}
}