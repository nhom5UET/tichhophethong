// JavaScript document for minBpEdit.jsp

function validateForm (TPRBInput)
{
	var validChars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~-!@#$%^&*()_+|}{\"><?;:";
	var spaceChar = " ";
	var validDigs="0123456789./";

	if (document.forms.TPRBInput.minBp.value == "" || document.TPRBInput.minBp.value == 0)
	{
		alert ("Error: Invalid blood preasure, Please enter valid value");
		document.forms.TPRBInput.minBp.focus();
		return false;
	}

if (document.forms.TPRBInput.minBp.value <30 || document.TPRBInput.minBp.value>180)
	{
		alert ("Error: Invalid min BP value");
		document.forms.TPRBInput.minBp.focus();
		return false;
	}


if (document.forms.TPRBInput.maxBp.value <30 || document.TPRBInput.maxBp.value>180)
	{
		alert ("Error: Invalid max BP value");
		document.forms.TPRBInput.minBp.focus();
		return false;
	}
	
	for (var i=0;i<document.forms.TPRBInput.minBp.value.length;i++)
	{
		temp=document.forms.TPRBInput.minBp.value.substring(i,i+1)


		if (validDigs.indexOf(temp)==-1  && document.forms.TPRBInput.minBp.value.substring(0,1) ==spaceChar)
   		{
			alert ("Error: Invalid blood preasure, Please enter valid value");
			document.forms.TPRBInput.minBp.focus();
			return false;
		}
		else if (validChars.indexOf(temp)>=0)
		{
    		alert ("Error: Invalid blood preasure, Please enter valid value");
			document.forms.TPRBInput.minBp.focus();
    		return false;
   		}
		
		else if (temp == spaceChar)
		{
    		alert ("Error: Invalid blood preasure, Please enter valid value");
			document.forms.TPRBInput.minBp.focus();
    		return false;
   		}
 	}
/////////////
if (document.forms.TPRBInput.maxBp.value == "" || document.TPRBInput.maxBp.value == 0)
	{
		alert ("Error: Invalid blood preasure, Please enter valid value");
		document.forms.TPRBInput.maxBp.focus();
		return false;
	}
	
	for (var i=0;i<document.forms.TPRBInput.maxBp.value.length;i++)
	{
		temp=document.forms.TPRBInput.maxBp.value.substring(i,i+1)


		if (validDigs.indexOf(temp)==-1  && document.forms.TPRBInput.maxBp.value.substring(0,1) ==spaceChar)
   		{
			alert ("Error: Invalid blood preasure, Please enter valid value");
			document.forms.TPRBInput.maxBp.focus();
			return false;
		}
		else if (validChars.indexOf(temp)>=0)
		{
    		alert ("Error: Invalid blood preasure, Please enter valid value");
			document.forms.TPRBInput.maxBp.focus();
    		return false;
   		}
		
		else if (temp == spaceChar)
		{
    		alert ("Error: Invalid blood preasure, Please enter valid value");
			document.forms.TPRBInput.maxBp.focus();
    		return false;
   		}
 	}

if (document.forms.TPRBInput.minBp.value>document.TPRBInput.maxBp.value)
	{
		alert ("Error: Min BP value should be less than max BP value");
		document.forms.TPRBInput.minBp.focus();
		return false;
	}


///////////
	if (document.forms.TPRBInput.pulse.value == "" || document.TPRBInput.pulse.value == 0)
	{
		alert ("Error: Invalid pulse, Please enter valid value");
		document.forms.TPRBInput.pulse.focus();
		return false;
	}

if (document.forms.TPRBInput.pulse.value <30 || document.TPRBInput.pulse.value>150)
	{
		alert ("Error: Invalid pulse rate");
		document.forms.TPRBInput.pulse.focus();
		return false;
	}
	
	for (var i=0;i<document.forms.TPRBInput.pulse.value.length;i++)
	{
		temp=document.forms.TPRBInput.pulse.value.substring(i,i+1)


		if (validDigs.indexOf(temp)==-1  && document.forms.TPRBInput.pulse.value.substring(0,1) ==spaceChar)
   		{
			alert ("Error: Invalid pulse, Please enter valid value");
			document.forms.TPRBInput.pulse.focus();
			return false;
		}
		else if (validChars.indexOf(temp)>=0)
		{
    		alert ("Error: Invalid pulse, Please enter valid value");
			document.forms.TPRBInput.pulse.focus();
    		return false;
   		}
		
		else if (temp == spaceChar)
		{
    		alert ("Error: Invalid pulse, Please enter valid value");
			document.forms.TPRBInput.pulse.focus();
    		return false;
   		}
 	}



if (document.forms.TPRBInput.temp.value == "" || document.TPRBInput.temp.value == 0)
	{
		alert ("Error: Invalid temprature, Please enter valid value");
		document.forms.TPRBInput.temp.focus();
		return false;
	}

if (document.forms.TPRBInput.temp.value <90 || document.TPRBInput.pulse.value>110)
	{
		alert ("Error: Invalid temperature value entered");
		document.forms.TPRBInput.temp.focus();
		return false;
	}
	
	for (var i=0;i<document.forms.TPRBInput.temp.value.length;i++)
	{
		temp=document.forms.TPRBInput.temp.value.substring(i,i+1)


		if (validDigs.indexOf(temp)==-1  && document.forms.TPRBInput.temp.value.substring(0,1) ==spaceChar)
   		{
			alert ("Error: Invalid temprature, Please enter valid value");
			document.forms.TPRBInput.temp.focus();
			return false;
		}
		else if (validChars.indexOf(temp)>=0)
		{
    		alert ("Error: Invalid temprature, Please enter valid value");
			document.forms.TPRBInput.temp.focus();
    		return false;
   		}
		
		else if (temp == spaceChar)
		{
    		alert ("Error: Invalid temprature, Please enter valid value");
			document.forms.TPRBInput.temp.focus();
    		return false;
   		}
 	}

if (document.forms.TPRBInput.rRate.value == "" || document.TPRBInput.rRate.value == 0)
	{
		alert ("Error: Invalid heart rate, Please enter valid value");
		document.forms.TPRBInput.rRate.focus();
		return false;
	}

if (document.forms.TPRBInput.rRate.value <30 || document.TPRBInput.rRate.value>150)
	{
		alert ("Error: Invalid respiration rate");
		document.forms.TPRBInput.rRate.focus();
		return false;
	}
	
	for (var i=0;i<document.forms.TPRBInput.rRate.value.length;i++)
	{
		rRate=document.forms.TPRBInput.rRate.value.substring(i,i+1)


		if (validDigs.indexOf(rRate)==-1  && document.forms.TPRBInput.rRate.value.substring(0,1) ==spaceChar)
   		{
			alert ("Error: Invalid heart rate, Please enter valid value");
			document.forms.TPRBInput.rRate.focus();
			return false;
		}
		else if (validChars.indexOf(rRate)>=0)
		{
    		alert ("Error: Invalid heart rate, Please enter valid value");
			document.forms.TPRBInput.rRate.focus();
    		return false;
   		}
		
		else if (rRate == spaceChar)
		{
    		alert ("Error: Invalid heart rate, Please enter valid value");
			document.forms.TPRBInput.rRate.focus();
    		return false;
   		}
 	}






}
function temp ()
{
alert ("fdsfdfds");
}