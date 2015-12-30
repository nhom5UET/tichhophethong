//javascript document for pthSearch.jsp

function validateForm (pSearch)
{
	var validChars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~-!@#$%^&*()_+|}{\"><.?/;:";
	var spaceChar = " ";
	var validDigs="0123456789";

	if (document.pSearch.pid.value == "" || document.pSearch.pid.value == 0)
	{
		alert ("Error: Invalid Patient ID, Please enter valid value");
		document.pSearch.pid.focus();
		return false;
	}
	
	for (var i=0;i<document.pSearch.pid.value.length;i++)
	{
		temp=document.pSearch.pid.value.substring(i,i+1)


		if (validDigs.indexOf(temp)==-1  && document.pSearch.pid.value.substring(0,1) ==spaceChar)
   		{
			alert ("Error: Invalid Patient ID, Please enter valid value");
			document.pSearch.pid.focus();
			return false;
		}
		else if (validChars.indexOf(temp)>=0)
		{
    		alert ("Error: Invalid Patient ID, Please enter valid value");
			document.pSearch.pid.focus();
    		return false;
   		}
		
		else if (temp == spaceChar)
		{
    		alert ("Error: Invalid Patient ID, Please enter valid value");
			document.pSearch.pid.focus();
    		return false;
   		}
 	}
}