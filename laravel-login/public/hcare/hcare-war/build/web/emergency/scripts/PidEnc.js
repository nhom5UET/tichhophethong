// JavaScript document for PidEnc.jsp

function validateForm (pidEnc)
{
	var validChars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~-!@#$%^&*()_+|}{\"><.?/;:";
	var spaceChar = " ";
	var validDigs="0123456789";

	if (document.pidEnc.pid.value == "" || document.pidEnc.pid.value == 0)
	{
		alert ("Error: Invalid Patient ID, Please enter valid value");
		document.pidEnc.pid.focus();
		return false;
	}
	
	for (var i=0;i<document.forms.pidEnc.pid.value.length;i++)
	{
		temp=document.forms.pidEnc.pid.value.substring(i,i+1)


		if (validDigs.indexOf(temp)==-1  && document.forms.pidEnc.pid.value.substring(0,1) ==spaceChar)
   		{
			alert ("Error: Invalid Patient ID, Please enter valid value");
			document.forms.pidEnc.pid.focus();
			return false;
		}
		else if (validChars.indexOf(temp)>=0)
		{
    		alert ("Error: Invalid Patient ID, Please enter valid value");
			document.forms.pidEnc.pid.focus();
    		return false;
   		}
		
		else if (temp == spaceChar)
		{
    		alert ("Error: Invalid Patient ID, Please enter valid value");
			document.forms.pidEnc.pid.focus();
    		return false;
   		}
 	}
}