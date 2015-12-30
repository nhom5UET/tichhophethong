// JavaScript Document for updatePharmStock.jsp

var selectedItem ;
var selectedText ;
var selectedValue ;

function selectMeds ()
{
	selectedItem = document.pharmacyUpdate.availableStock.selectedIndex;
	selectedText = document.pharmacyUpdate.availableStock.options[selectedItem].text;
	selectedValue = document.pharmacyUpdate.availableStock.options[selectedItem].value;

	document.pharmacyUpdate.mName.value = selectedText;
	document.pharmacyUpdate.avlQty.value = document.getElementById(selectedValue).value; 
	document.pharmacyUpdate.mCode.value = selectedValue;
}

function validateForm (pharmacyUpdate)
{
	var validChars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~-!@#$%^&*()_+|}{\"><.?/;:";
	var spaceChar = " ";
	var validDigs="0123456789";

	if (document.pharmacyUpdate.availableStock.length ==0)
	{
		alert ("Error: Medicine stock is empty");
		return false;
	}
	
	if (document.forms.pharmacyUpdate.mName.value =="")
	{
		alert ("Error: No medicine is selected to update\nPlease select medicine from above stock");
		return false;
	}
	
	if (document.pharmacyUpdate.updQty.value == "" || document.pharmacyUpdate.updQty.value == 0)
	{
		alert ("Error: Invalid Update Quantity, Please enter valid value");
		document.pharmacyUpdate.updQty.focus();
		return false;
	}
	
	for (var i=0;i<document.forms.pharmacyUpdate.updQty.value.length;i++)
	{
		temp=document.forms.pharmacyUpdate.updQty.value.substring(i,i+1)


		if (validDigs.indexOf(temp)==-1  && document.forms.pharmacyUpdate.updQty.value.substring(0,1) ==spaceChar)
   		{
			alert ("Error: Invalid Update Quantity, Please enter valid value");
			document.forms.pharmacyUpdate.updQty.focus();
			return false;
		}
		else if (validChars.indexOf(temp)>=0)
		{
    		alert ("Error: Invalid Update Quantity, Please enter valid value");
			document.forms.pharmacyUpdate.updQty.focus();
    		return false;
   		}
		
		else if (temp == spaceChar)
		{
    		alert ("Error: Invalid Update Quantity, Please enter valid value");
			document.forms.pharmacyUpdate.updQty.focus();
    		return false;
   		}
 	}
}