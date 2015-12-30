// JavaScript document for PidEdit.jsp

function validateForm (pidTPRB)
{
	var validChars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~-!@#$%^&*()_+|}{\"><.?/;:";
	var spaceChar = " ";
	var validDigs="0123456789";

	if (document.forms.pidTPRB.pid.value == "" || document.pidTPRB.pid.value == 0)
	{
		alert ("Error: Invalid Patient ID, Please enter valid value");
		document.forms.pidTPRB.pid.focus();
		return false;
	}
	
	for (var i=0;i<document.forms.pidTPRB.pid.value.length;i++)
	{
		temp=document.forms.pidTPRB.pid.value.substring(i,i+1)


		if (validDigs.indexOf(temp)==-1  && document.forms.pidTPRB.pid.value.substring(0,1) ==spaceChar)
   		{
			alert ("Error: Invalid Patient ID, Please enter valid value");
			document.forms.pidTPRB.pid.focus();
			return false;
		}
		else if (validChars.indexOf(temp)>=0)
		{
    		alert ("Error: Invalid Patient ID, Please enter valid value");
			document.forms.pidTPRB.pid.focus();
    		return false;
   		}
		
		else if (temp == spaceChar)
		{
    		alert ("Error: Invalid Patient ID, Please enter valid value");
			document.forms.pidTPRB.pid.focus();
    		return false;
   		}
 	}
}