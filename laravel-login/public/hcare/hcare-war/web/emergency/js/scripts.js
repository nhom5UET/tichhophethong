// JavaScript Document
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