// JavaScript document for PidEdit.jsp

function validateForm (pidOldTreat)
{
	var validChars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~-!@#$%^&*()_+|}{\"><.?/;:";
	var spaceChar = " ";
	var validDigs="0123456789";

	if (document.pidOldTreat.pid.value == "" || document.pidOldTreat.pid.value == 0)
	{
		alert ("Error: Invalid Patient ID, Please enter valid value");
		document.pidOldTreat.pid.focus();
		return false;
	}
	
	for (var i=0;i<document.pidOldTreat.pid.value.length;i++)
	{
		temp=document.pidOldTreat.pid.value.substring(i,i+1)


		if (validDigs.indexOf(temp)==-1  && document.pidOldTreat.pid.value.substring(0,1) ==spaceChar)
   		{
			alert ("Error: Invalid Patient ID, Please enter valid value");
			document.pidOldTreat.pid.focus();
			return false;
		}
		else if (validChars.indexOf(temp)>=0)
		{
    		alert ("Error: Invalid Patient ID, Please enter valid value");
			document.pidOldTreat.pid.focus();
    		return false;
   		}
		
		else if (temp == spaceChar)
		{
    		alert ("Error: Invalid Patient ID, Please enter valid value");
			document.pidOldTreat.pid.focus();
    		return false;
   		}
 	}
}