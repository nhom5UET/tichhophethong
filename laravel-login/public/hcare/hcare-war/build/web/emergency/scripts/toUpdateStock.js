// JavaScript document for toUpdateStock.jsp

function validateForm (toUpdateStock)
{
	var validChars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~-!@#$%^&*()_+|}{\"><.?/;:";
	var spaceChar = " ";
	var validDigs="0123456789";

	if (document.forms.toUpdateStock.empId.value == "" || document.toUpdateStock.empId.value == 0)
	{
		alert ("Error: Invalid Employee ID, Please enter valid value");
		document.forms.toUpdateStock.empId.focus();
		return false;
	}
	
	for (var i=0;i<document.forms.toUpdateStock.empId.value.length;i++)
	{
		temp=document.forms.toUpdateStock.empId.value.substring(i,i+1)


		if (validDigs.indexOf(temp)==-1  && document.forms.toUpdateStock.empId.value.substring(0,1) ==spaceChar)
   		{
			alert ("Error: Invalid Employee ID, Please enter valid value");
			document.forms.toUpdateStock.empId.focus();
			return false;
		}
		else if (validChars.indexOf(temp)>=0)
		{
    		alert ("Error: Invalid Employee ID, Please enter valid value");
			document.forms.toUpdateStock.empId.focus();
    		return false;
   		}
		
		else if (temp == spaceChar)
		{
    		alert ("Error: Invalid Employee ID, Please enter valid value");
			document.forms.toUpdateStock.empId.focus();
    		return false;
   		}
 	}
}