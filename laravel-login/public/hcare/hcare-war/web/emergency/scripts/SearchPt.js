// JavaScript Document for SearchPt.jsp

function validateForm(SearchPt)
{
var validChars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"
var spaceChar = " "
var validDigs="0123456789~-!@#$%^&*()_+|}{\"><.?/;:"

if(document.forms.SearchPt.firstName.value=="")
{
alert("Error: Invalid first name, Please enter again");
document.forms.SearchPt.firstName.focus();
return false;
}

for (var i=0;i<document.forms.SearchPt.firstName.value.length;i++)
{
  temp=document.forms.SearchPt.firstName.value.substring(i,i+1)
   if (validChars.indexOf(temp)==-1)
   {
	alert("Error: Invalid first name, Please enter again");
	document.forms.SearchPt.firstName.focus();
    return false
   }
 }

//checks on Last Name

if(document.forms.SearchPt.lastName.value=="")
{
	alert("Error: Invalid last name, Please enter again");
document.forms.SearchPt.lastName.focus();
return false;
}

for (var i=0;i<document.forms.SearchPt.lastName.value.length;i++)
{
  temp=document.forms.SearchPt.lastName.value.substring(i,i+1)
   if (validChars.indexOf(temp)==-1)
   {
	alert("Error: Invalid last name, Please enter again");
    return false
   }
 }
 
//checks om Father/Husband Name

if(document.forms.SearchPt.fatherName.value=="")
{
	alert("Error: Invalid father/husband name, Please enter again");
document.forms.SearchPt.fatherName.focus();
return false;
}

for (var i=0;i<document.forms.SearchPt.fatherName.value.length;i++)
{
  temp=document.forms.SearchPt.fatherName.value.substring(i,i+1)

  if (validChars.indexOf(temp)==-1  && document.forms.SearchPt.fatherName.value.substring(0,1) ==spaceChar)
   {
	alert("Error: Invalid first/husband name, Please enter again");
	document.forms.SearchPt.fatherName.focus();
    return false
   }
   else if (validDigs.indexOf(temp)>=0)
   {
	alert("Error: Invalid first/husband name, Please enter again");
	document.forms.SearchPt.fatherName.focus();
    return false
   }
   
 }
 
 if (document.forms.SearchPt.fatherName.length==0)
 {
	alert("Error: Invalid first/husband name, Please enter again");
	 return false;
} 
//checks on Address1

if(document.forms.SearchPt.streetAddress.value=="")
{
	alert("Error: Invalid street address, Please enter again");
document.forms.SearchPt.streetAddress.focus();
return false;
}

//checks on Address 2

if(document.forms.SearchPt.town.value=="")
{
	alert("Error: Invalid town name, Please enter again");
document.forms.SearchPt.town.focus();
return false;
}

//checks on dob

if(document.forms.SearchPt.dob.value=="")
{
	alert("Error: Invalid date of birth, Please enter again");
document.forms.SearchPt.dob.focus();
return false;
}
if (document.forms.SearchPt.fatherName.length==0)
{
	alert("Error: Invalid father/husband name, Please enter again");
	return false;
}

}