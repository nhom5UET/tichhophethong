// JavaScript Document for accesssControl.jsp
function addToAssignedPrev()  
{
	var boxLength = document.access.assigned.length;//length of assigned
	///var Newlength = document.access.New.length;//length of newly added icd



	var selectedItem = document.access.available.selectedIndex;
	var selectedText = document.access.available.options[selectedItem].text;
	var selectedValue = document.access.available.options[selectedItem].value;
	var i;
	var isNew = true;
	
	if (boxLength != 0) 
	{
		for (i = 0; i < boxLength; i++) 
		{
			thisitem = document.access.assigned.options[i].text;
			if (thisitem == selectedText) 
			{
				isNew = false;
				break;
			}
   		}
	} 

	if (isNew) 
	{
		newoption = new Option(selectedText, selectedValue, false, false);
		document.access.assigned.options[boxLength] = newoption;
	}
	document.access.available.selectedIndex=-1;
}
/////////////////////////////////
function removeSelected() 
{
	var boxLength = document.access.assigned.length;
	arrSelected = new Array();
	var count = 0;
	for (i = 0; i < boxLength; i++) 
	{
		if (document.access.assigned.options[i].selected) 
		{
			arrSelected[count] = document.access.assigned.options[i].value;
		}
		count++;
	}
	var x;
	for (i = 0; i < boxLength; i++) 
	{
		for (x = 0; x < arrSelected.length; x++) 
		{
			if (document.access.assigned.options[i].value == arrSelected[x]) 
			{
				document.access.assigned.options[i] = null;
   			}
		}
		boxLength = document.access.assigned.length;
   	}
}
///////////////////////

function selectAllAssigned() 
{
	var sourceList = document.access.assigned;
	var str ;
	for(var i = 0; i < sourceList.options.length; i++) 
	{
		if (sourceList.options[i] != null)
			sourceList.options[i].selected = true;
	}
}

