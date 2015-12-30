// JavaScript Document for Edit.jsp

function validateForm(RegPatient)
{
var validChars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"
var spaceChar = " "
var validDigs="0123456789~-!@#$%^&*()_+|}{\"><.?/;:"

if(document.forms.RegPatient.firstName.value=="")
{
alert("Error: Invalid first name, Please enter again");
document.forms.RegPatient.firstName.focus();
return false;
}

for (var i=0;i<document.forms.RegPatient.firstName.value.length;i++)
{
  temp=document.forms.RegPatient.firstName.value.substring(i,i+1)
   if (validChars.indexOf(temp)==-1)
   {
	alert("Error: Invalid first name, Please enter again");
	document.forms.RegPatient.firstName.focus();
    return false
   }
 }

//checks on Last Name

if(document.forms.RegPatient.lastName.value=="")
{
	alert("Error: Invalid last name, Please enter again");
document.forms.RegPatient.lastName.focus();
return false;
}

for (var i=0;i<document.forms.RegPatient.lastName.value.length;i++)
{
  temp=document.forms.RegPatient.lastName.value.substring(i,i+1)
   if (validChars.indexOf(temp)==-1)
   {
	alert("Error: Invalid last name, Please enter again");
    return false
   }
 }
 
//checks om Father/Husband Name

if(document.forms.RegPatient.fatherName.value=="")
{
	alert("Error: Invalid father/husband name, Please enter again");
document.forms.RegPatient.fatherName.focus();
return false;
}

for (var i=0;i<document.forms.RegPatient.fatherName.value.length;i++)
{
  temp=document.forms.RegPatient.fatherName.value.substring(i,i+1)

  if (validChars.indexOf(temp)==-1  && document.forms.RegPatient.fatherName.value.substring(0,1) ==spaceChar)
   {
	alert("Error: Invalid first/husband name, Please enter again");
	document.forms.RegPatient.fatherName.focus();
    return false
   }
   else if (validDigs.indexOf(temp)>=0)
   {
	alert("Error: Invalid first/husband name, Please enter again");
	document.forms.RegPatient.fatherName.focus();
    return false
   }
   
 }
 
 if (document.forms.RegPatient.fatherName.length==0)
 {
	alert("Error: Invalid first/husband name, Please enter again");
	 return false;
} 
//checks on Address1

if(document.forms.RegPatient.streetAddress.value=="")
{
	alert("Error: Invalid street address, Please enter again");
document.forms.RegPatient.streetAddress.focus();
return false;
}

//checks on Address 2

if(document.forms.RegPatient.town.value=="")
{
	alert("Error: Invalid town name, Please enter again");
document.forms.RegPatient.town.focus();
return false;
}

//checks on dob

if(document.forms.RegPatient.dob.value=="")
{
	alert("Error: Invalid date of birth, Please enter again");
document.forms.RegPatient.dob.focus();
return false;
}
if (document.forms.RegPatient.fatherName.length==0)
{
	alert("Error: Invalid father/husband name, Please enter again");
	return false;
}
// checks on picture

//if (document.RegPatient.picture.value == "")/
//{
//	alert("Error: Youe must select picture of the patient, Please try again");
	//return false;
//}
}