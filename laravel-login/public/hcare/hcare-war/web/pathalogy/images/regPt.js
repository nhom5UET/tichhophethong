// JavaScript Document
//Author: Tahir
//Dated: 1/10/2005 9:11 am
//---------------------------

//checks on Last Name

function validateForm(newPatient)
{
var validChars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"
var spaceChar = " "
var validDigs="0123456789"

if(document.forms.newPatient.firstName.value=="")
{
alert("Please enter first name");
document.forms.newPatient.firstName.focus();
return false;
}

for (var i=0;i<document.forms.newPatient.firstName.value.length;i++)
{
  temp=document.forms.newPatient.firstName.value.substring(i,i+1)
   if (validChars.indexOf(temp)==-1)
   {
    alert("Invalid First name, try again!")
    return false
   }
 }


//checks on Last Name

if(document.forms.newPatient.lastName.value=="")
{
alert("Please enter last name");
document.forms.newPatient.lastName.focus();
return false;
}

for (var i=0;i<document.forms.newPatient.lastName.value.length;i++)
{
  temp=document.forms.newPatient.lastName.value.substring(i,i+1)
   if (validChars.indexOf(temp)==-1)
   {
    alert("Invalid Last name, try again!")
    return false
   }
 }
 
//checks om Father/Husband Name

if(document.forms.newPatient.fatherHusbandName.value=="")
{
alert("Please enter father/husband name");
document.forms.newPatient.fatherHusbandName.focus();
return false;
}

for (var i=0;i<document.forms.newPatient.fatherHusbandName.value.length;i++)
{
  temp=document.forms.newPatient.fatherHusbandName.value.substring(i,i+1)

  if (validChars.indexOf(temp)==-1  && document.forms.newPatient.fatherHusbandName.value.substring(0,1) ==spaceChar)
   {
    alert("Invalid father/husband name, try again!")
	document.forms.newPatient.fatherHusbandName.focus();
    return false
   }
   else if (validDigs.indexOf(temp)>=0)
   {
    alert("Invalid father/husband name, try again!")
	document.forms.newPatient.fatherHusbandName.focus();
    return false
   }
   
 }
 
 if (document.forms.newPatient.fatherHusbandName.length==0)
 {
	 alert ("sdsdsdsddddddddddddddddd");
	 return false;
} 
//checks on Address1

if(document.forms.newPatient.streetAddress.value=="")
{
alert("Please enter Address Information in Address 1");
document.forms.newPatient.streetAddress.focus();
return false;
}

//checks on Address 2

if(document.forms.newPatient.town.value=="")
{
alert("Please enter Address Information in Address 2");
document.forms.newPatient.town.focus();
return false;
}

//checks on DateofBirth

if(document.forms.newPatient.dateOfBirth.value=="")
{
alert("Please Date of Birth");
document.forms.newPatient.dateOfBirth.focus();
return false;
}
if (document.forms.newPatient.fatherHusbandName.length==0)
{
	alert ("Please enter father/husband name");
	return false;
}

}

