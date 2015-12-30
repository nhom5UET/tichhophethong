// JavaScript Document for pthTestDomainEdit.jsp

function validateForm (testEdit)
{
	var validChars=".ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	var spaceChar = " ";
	var validDigs="0123456789.";
	var spChars = "~-!@#$%^&*()_+|}{\"><?/;:`"
	var cName = document.testEdit.cname;

	var minValue = document.testEdit.minvalue;
	var maxValue = document.testEdit.maxvalue;
	
	var temp ; var temp2 ; var temp3 ; var temp1;

	if (document.testEdit.tname.value == "" )
	{
		alert ("Error: Test name is invalid, Please enter again!");
		document.testEdit.tname.focus();
		return false;
	}
	for (var i=0;i<document.testEdit.tname.value.length;i++)
	{
		temp=document.testEdit.tname.value.substring(i,i+1)

		if (validChars.indexOf(temp)==-1  && document.testEdit.tname.value.substring(0,1) ==spaceChar)
   		{
			alert ("Error: Test name is invalid, Please enter again!");
			document.testEdit.tname.focus();
			return false;
		}
		else if (validDigs.indexOf(temp)>=0)
		{
    		alert ("Error: Digits are not allowed in test name, Please enter again!");
			document.testEdit.tname.focus();
    		return false;
   		}
		else if (spChars.indexOf(temp)>=0)
		{
    		alert ("Error: Special Characters are not allowed in test name, Please enter again!");
			document.testEdit.tname.focus();
    		return false;
   		}
 	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	for (var c = 0 ; c < cName.length ; c++)
	{
		if (cName[c].value == "" )
		{
			alert ("Error: Test name is invalid, Please enter again!");
			cName[c].focus();
			return false;
		}
		for (var t=0;t<cName[c].length;t++)
		{
			temp1=cName[c].value.substring(i,i+1)

			if (validChars.indexOf(temp1)==-1  && cName[c].value.substring(0,1) ==spaceChar)
   			{
				alert ("Error: Test name is invalid, Please enter again!");
				cName[c].focus();
				return false;
			}
			else if (validDigs.indexOf(temp1)>=0)
			{
    			alert ("Error: Digits are not allowed in test name, Please enter again!");
				alert(cName[c].value);
				cName[c].focus();
    			return false;
   			}
			else if (spChars.indexOf(temp1)>=0)
			{
    			alert ("Error: Special Characters are not allowed in test name, Please enter again!");
				cName[c].focus();
    			return false;
   			}
		}
	}	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*
	for (s = 0 ; s < minValue.length ; s ++ )
	{
		alert (minValue[s].value
	}*/
}
