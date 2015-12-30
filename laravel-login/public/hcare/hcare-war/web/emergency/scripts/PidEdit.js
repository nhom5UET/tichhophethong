// JavaScript document for PidEdit.jsp

function validateForm (updatePt)
{
	var validChars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~-!@#$%^&*()_+|}{\"><.?/;:";
	var spaceChar = " ";
	var validDigs="0123456789";

	if (document.forms.updatePt.pid.value == "" || document.updatePt.pid.value == 0)
	{
		alert ("Error: Invalid Patient ID, Please enter valid value");
		document.forms.updatePt.pid.focus();
		return false;
	}
	
	for (var i=0;i<document.forms.updatePt.pid.value.length;i++)
	{
		temp=document.forms.updatePt.pid.value.substring(i,i+1)


		if (validDigs.indexOf(temp)==-1  && document.forms.updatePt.pid.value.substring(0,1) ==spaceChar)
   		{
			alert ("Error: Invalid Patient ID, Please enter valid value");
			document.forms.updatePt.pid.focus();
			return false;
		}
		else if (validChars.indexOf(temp)>=0)
		{
    		alert ("Error: Invalid Patient ID, Please enter valid value");
			document.forms.updatePt.pid.focus();
    		return false;
   		}
		
		else if (temp == spaceChar)
		{
    		alert ("Error: Invalid Patient ID, Please enter valid value");
			document.forms.updatePt.pid.focus();
    		return false;
   		}
 	}
}