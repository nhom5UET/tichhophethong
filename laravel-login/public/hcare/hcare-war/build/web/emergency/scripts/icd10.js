// JavaScript Document

var  selectedItem
var selectedText
var selectedValue
var dsSetLength
var wrkSetLength 

function addSelectedItemsToParent() 
{
self.opener.addToParentList(window.document.forms[0].workingSet); //forms[0]
window.close();
}

//adding in DiseaseSet/ workingSet-----------------------------------------------------

function moveOver()  
{

selectedItem = document.icd10.diseaseMatched.selectedIndex;
selectedText = document.icd10.diseaseMatched.options[selectedItem].text;
selectedValue = document.icd10.diseaseMatched.options[selectedItem].value;

dsSetLength= document.icd10.diseaseSet.length;
wrkSetLength = document.icd10.workingSet.length;

var i;
var isNew = true;
var isNewWrk = true;

if (dsSetLength != 0) 
{
for (i = 0; i < dsSetLength; i++)
 {
	thisitem = document.icd10.diseaseSet.options[i].text;
	if (thisitem == selectedText) 
	{
		isNew = false;
		break;
    }
 }
} 
////////////////////////////////////////////// 

 for (i = 0; i < wrkSetLength; i++)
 {
	thisitem = document.icd10.workingSet.options[i].text;
	if (thisitem == selectedText) 
	{
		isNewWrk = false;
		break;
    }
 }

 

if (isNew && isNewWrk) 
{
newoption = new Option(selectedText, selectedValue, false, false);
document.icd10.diseaseSet.options[dsSetLength] = newoption;
fillWorkingSet();

}//end if
document.icd10.diseaseMatched.selectedIndex=-1;
document.icd10.diseaseSet.selectedIndex=-1;
document.icd10.workingSet.selectedIndex=-1;

}//end funct

function fillWorkingSet ()
{
wrkSetLength = document.icd10.workingSet.length;
//newWrkSetLength = dsSetLength+wrkSetLength;
var bool = true;
for (i = 0 ; i < wrkSetLength; i++)
{
	if (selectedText==document.icd10.workingSet.options[i].text)
	{
	bool = false;
	break;
	}
}

if (bool)
{
newoption = new Option(selectedText, selectedValue, false, false);
document.icd10.workingSet.options[wrkSetLength] = newoption;
}
}

// deletting from diseaseSet -------------------------------------------------------------------------------

function removeMe()
{
var boxLength = document.icd10.diseaseSet.length;
arrSelected = new Array();
var count = 0;
for (i = 0; i < boxLength; i++)
{
	if (document.icd10.diseaseSet.options[i].selected) 
	{
	arrSelected[count] = document.icd10.diseaseSet.options[i].value;
	}
	count++;
}

var x;
/*
for (i = 0; i < boxLength; i++)
{
	for (x = 0; x < arrSelected.length; x++)
	{
		if (document.icd10.diseaseSet.options[i].value == arrSelected[x]) 
		{
			document.icd10.diseaseSet.options[i] = null;
			deletFromWorkingSet (i);
			//alert (i);
   		}
	}
	boxLength = document.icd10.diseaseSet.length;
}*/
for (i = 0; i < boxLength; i++) 
{
	for (x = 0; x < arrSelected.length; x++) 
	{
		if (document.icd10.diseaseSet.options[i].value == arrSelected[x]) //its means , it was selected item, so it should be removed
		{
			document.icd10.diseaseSet.options[i] = null;
			for (var c = 0 ; c < document.icd10.workingSet.length ; c++)
			{	if (document.icd10.workingSet.options[c].value == arrSelected[x])
				{
					
					document.icd10.workingSet.options[c] = null;
				} 
			}
   		}
	}
	boxLength = document.icd10.diseaseSet.length;
}
}//end function 
/*
function deletFromWorkingSet (i)
{
	wrkSetLength=document.icd10.workingSet.length;
	index = wrkSetLength+i;
	document.icd10.workingSet.options[index] = null;
	}
*/
////////////////////////////////////////////////////////////////////////////////////

function abc ()
{
for (var i = 0 ; i < document.forms.icd10.workingSet.length ; i ++)
{
	document.forms.icd10.workingSet.options[i].selected = true;
	}
//alert ("sdfsdsdsdsdsdsdsdsdddddddddddddddddddddsdsdsd");
}

////////////////////////////////////////////////////////////////////////////////////

function isDiseaseNull (){
	if (document.forms.icd10.textfield.value.length==0 && document.forms.icd10.diseaseMatched.length==0){
		alert ("Please enter Disease name to search");
		document.forms.icd10.textfield.focus();
		//	return false;
	}
	
	else if (document.forms.icd10.textfield.value.length>0 && document.forms.icd10.textfield.value.substring(0,1)==" "){
		alert ("Invalid Disease, try agin!");
		document.forms.icd10.textfield.focus();
		//return false;
	}		
}

////////////////////////////////////////////////////////////////////////////////////
function isDiseaseSetNull (icd10)
{	
	if (document.forms.icd10.diseaseSet.length == 0)
	{
		alert ("Your new Disease Set contains no any disease\nPlease select desired disease from matched Diseases");
		return false;
	}
	else
	{
		for (var i = 0 ; i < document.forms.icd10.diseaseSet.length ; i ++)
		{
		document.forms.icd10.diseaseSet.options[i].selected = true;
		}
		return true;
	}
}