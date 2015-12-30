// JavaScript Document for Edit.jsp

function validateForm(PtUpdate)
{
var validChars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"
var spaceChar = " "
var validDigs="0123456789~-!@#$%^&*()_+|}{\"><.?/;:"

if(document.forms.PtUpdate.firstName.value=="")
{
alert("Error: Invalid first name, Please enter again");
document.forms.PtUpdate.firstName.focus();
return false;
}

for (var i=0;i<document.forms.PtUpdate.firstName.value.length;i++)
{
  temp=document.forms.PtUpdate.firstName.value.substring(i,i+1)
   if (validChars.indexOf(temp)==-1)
   {
	alert("Error: Invalid first name, Please enter again");
	document.forms.PtUpdate.firstName.focus();
    return false
   }
 }

//checks on Last Name

if(document.forms.PtUpdate.lastName.value=="")
{
	alert("Error: Invalid last name, Please enter again");
document.forms.PtUpdate.lastName.focus();
return false;
}

for (var i=0;i<document.forms.PtUpdate.lastName.value.length;i++)
{
  temp=document.forms.PtUpdate.lastName.value.substring(i,i+1)
   if (validChars.indexOf(temp)==-1)
   {
	alert("Error: Invalid last name, Please enter again");
    return false
   }
 }
 
//checks om Father/Husband Name

if(document.forms.PtUpdate.fatherName.value=="")
{
	alert("Error: Invalid father/husband name, Please enter again");
document.forms.PtUpdate.fatherName.focus();
return false;
}

for (var i=0;i<document.forms.PtUpdate.fatherName.value.length;i++)
{
  temp=document.forms.PtUpdate.fatherName.value.substring(i,i+1)

  if (validChars.indexOf(temp)==-1  && document.forms.PtUpdate.fatherName.value.substring(0,1) ==spaceChar)
   {
	alert("Error: Invalid first/husband name, Please enter again");
	document.forms.PtUpdate.fatherName.focus();
    return false
   }
   else if (validDigs.indexOf(temp)>=0)
   {
	alert("Error: Invalid first/husband name, Please enter again");
	document.forms.PtUpdate.fatherName.focus();
    return false
   }
   
 }
 
 if (document.forms.PtUpdate.fatherName.length==0)
 {
	alert("Error: Invalid first/husband name, Please enter again");
	 return false;
} 
//checks on Address1

if(document.forms.PtUpdate.streetAddress.value=="")
{
	alert("Error: Invalid street address, Please enter again");
document.forms.PtUpdate.streetAddress.focus();
return false;
}

//checks on Address 2

if(document.forms.PtUpdate.town.value=="")
{
	alert("Error: Invalid town name, Please enter again");
document.forms.PtUpdate.town.focus();
return false;
}

//checks on dob

if(document.forms.PtUpdate.dob.value=="")
{
	alert("Error: Invalid date of birth, Please enter again");
document.forms.PtUpdate.dob.focus();
return false;
}
if (document.forms.PtUpdate.fatherName.length==0)
{
	alert("Error: Invalid father/husband name, Please enter again");
	return false;
}

}