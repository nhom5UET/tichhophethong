// JavaScript Document pthTestDomainAdd.jsp
function validateForm(newTest)
{
	//var str = document.forms.newTest.tname.value
	var validChars=".ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	var spaceChar = " ";
	var validDigs="0123456789.";
	var spChars = "~-!@#$%^&*()_+|}{\"><?/;:`"
	var validDot = "."
	var bool = true;
	var i = 0;
	var temp; var temp2;
	var = document.newTest.cname;

	if (document.newTest.tname.value==""  && document.forms.newTest.tname.value.length==0)
	{
		alert ("Error: Test name is invalid, Please enter again!");
		document.forms.newTest.tname.focus();
		return false;
	}

	for (var i=0;i<document.newTest.tname.value.length;i++)
	{
		temp=document.newTest.tname.value.substring(i,i+1)

		if (validChars.indexOf(temp)==-1  && document.newTest.tname.value.substring(0,1) ==spaceChar)
   		{
			alert ("Error: Test name is invalid, Please enter again!");
			document.newTest.tname.focus();
			return false;
		}
		else if (validDigs.indexOf(temp)>=0)
		{
    		alert ("Error: Digits are not allowed in test name, Please enter again!");
			document.newTest.tname.focus();
    		return false;
   		}
		else if (spChars.indexOf(temp)>=0)
		{
    		alert ("Error: Special Characters are not allowed in test name, Please enter again!");
			document.newTest.tname.focus();
    		return false;
   		}
 	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	if(document.newTest.tcost.value=="")
	{
		alert ("Error: cost can not be left blank, Please enter!");
		document.newTest.tcost.focus();
		return false;
	}

	for (var c=0;c<document.newTest.tcost.value.length;c++)
	{
 	 temp2=document.newTest.tcost.value.substring(c,c+1)

 	  if (validDigs.indexOf(temp2)==-1)
 	  {
 	  	alert ("Error: Invalid cost, Please enter again!");
		document.newTest.tcost.focus();
  	 	return false
	   }
  	 else if (spChars.indexOf(temp2)>=0)
		{
   			alert ("Error: Special Characters are not allowed in cost, Please enter again!");
			document.newTest.tcost.focus();
    		return false;
   		}
 	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	for (v = 0 ; v < cName.length ; v ++)
	{
		alert (cName[v].value);
	}
}