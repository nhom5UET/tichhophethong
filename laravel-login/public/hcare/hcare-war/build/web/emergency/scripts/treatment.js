function small_window(myurl) 
{
	var newWindow;
	var props = 'scrollBars=no,resizable=no,toolbar=no,menubar=no,location=no,directories=no,width=500,height=250';
	newWindow = window.open(myurl, "Add_from_Src_to_Dest", props);
}
///////////////////////////////////
function normal_window(myurl) 
{
	var newWindow;
	var props = 'scrollBars=no,resizable=no,toolbar=no,menubar=no,location=no,directories=no,width=840,height=500';
	newWindow = window.open(myurl, "Add_from_Src_to_Dest", props);
}
///////////////////////////////////
function addToParentList(sourceList) 
{
	destinationList = window.document.forms[0].diseaseSet;
	for(var count = destinationList.options.length - 1; count >= 0; count--) 
	{
		destinationList.options[count] = null;
	}
	
	for(var i = 0; i < sourceList.options.length; i++) 
	{
		if (sourceList.options[i] != null)
		destinationList.options[i] = new Option(sourceList.options[i].text, sourceList.options[i].value );
	}
}
///////////////////////////////////
function addToDiagnosis()  
{
	var boxLength = document.treatment.pDiagnosis.length;//length of pDiagnosis
	///var Newlength = document.treatment.New.length;//length of newly added icd



	var selectedItem = document.treatment.diseaseSet.selectedIndex;
	var selectedText = document.treatment.diseaseSet.options[selectedItem].text;
	var selectedValue = document.treatment.diseaseSet.options[selectedItem].value;
	var i;
	var isNew = true;
	
	if (boxLength != 0) 
	{
		for (i = 0; i < boxLength; i++) 
		{
			thisitem = document.treatment.pDiagnosis.options[i].text;
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
		document.treatment.pDiagnosis.options[boxLength] = newoption;
	}
	document.treatment.diseaseSet.selectedIndex=-1;
}
/////////////////////////////////
function removeSelected() 
{
	var boxLength = document.treatment.pDiagnosis.length;
	arrSelected = new Array();
	var count = 0;
	for (i = 0; i < boxLength; i++) 
	{
		if (document.treatment.pDiagnosis.options[i].selected) 
		{
			arrSelected[count] = document.treatment.pDiagnosis.options[i].value;
		}
		count++;
	}
	var x;
	for (i = 0; i < boxLength; i++) 
	{
		for (x = 0; x < arrSelected.length; x++) 
		{
			if (document.treatment.pDiagnosis.options[i].value == arrSelected[x]) 
			{
				document.treatment.pDiagnosis.options[i] = null;
   			}
		}
		boxLength = document.treatment.pDiagnosis.length;
   	}
}
///////////////////////

function selectAllDiagnose() 
{
	sourceList = window.document.treatment.pDiagnosis;
	for(var i = 0; i < sourceList.options.length; i++) 
	{
		if (sourceList.options[i] != null)
		sourceList.options[i].selected = true;
	}
	
}

///////////////////////////////////////////////////////////////////////////////////////////////////////
var rowCount=4;
function addRow(id)
{
    var medSet = document.treatment.medicine;
	var tbody = document.getElementById(id).getElementsByTagName("TBODY")[0];
    var row = document.createElement("TR")

    var td1 = document.createElement("<td>")
	var div = document.createElement("<div class=\"genFont\">");
	div.appendChild(document.createTextNode(rowCount+"."));
    td1.appendChild(div);
	
    var td2 = document.createElement("TD")
	var medMenue = document.createElement("<select name=\"medicine\"  class=\"menuFormat\" style=\"width:350;\">")
			
	for (var c = 0 ; c < medSet[0].length ; c ++)
	{
		var value = document.createElement("<option value = "+medSet[0].options[c].value + ">");
		value.appendChild (document.createTextNode(medSet[0].options[c].text));
		medMenue.appendChild (value);
	}
	td2.appendChild (medMenue);

    var td3 = document.createElement("TD")
	var menue = document.createElement("<select name=\"timing\" style=\"width:85;\" class=\"menuFormat\">");
	
	var opt0 = document.createElement("<option value = \"0\">");
	opt0.appendChild (document.createTextNode("0 + 0 + 0"));
	
	var opt1 = document.createElement("<option value = \"1\">");
	opt1.appendChild (document.createTextNode("0 + 0 + 1"));
	
	var opt2 = document.createElement("<option value = \"2\">");
	opt2.appendChild (document.createTextNode("0 + 1 + 0"));
	
	var opt3 = document.createElement("<option value = \"3\">");
	opt3.appendChild (document.createTextNode("0 + 1 + 1"));
	
	var opt4 = document.createElement("<option value = \"4\">");
	opt4.appendChild (document.createTextNode("1 + 0 + 0"));
	
	var opt5 = document.createElement("<option value = \"0\">");
	opt5.appendChild (document.createTextNode("1 + 0 + 1"));
	
	var opt6 = document.createElement("<option value = \"0\">");
	opt6.appendChild (document.createTextNode("1 + 1 + 0"));
	
	var opt7 = document.createElement("<option value = \"0\">");
	opt7.appendChild (document.createTextNode("1 + 1 + 1"));

	menue.appendChild (opt0);
	menue.appendChild (opt1);
	menue.appendChild (opt2);
	menue.appendChild (opt3);
	menue.appendChild (opt4);
	menue.appendChild (opt5);
	menue.appendChild (opt6);
	menue.appendChild (opt7);
	
	td3.appendChild (menue);
	
    var td4 = document.createElement("TD")
 	td4.appendChild(document.createElement("<input type=\"text\" name=\"qty\" size=\"4\"  class=\"inputField\"/>"))

    var td5 = document.createElement("TD")
 	td5.appendChild(document.createElement("<input type=\"text\" name=\"period\" size=\"4\"  class=\"inputField\"/>"))


    var td6 = document.createElement("TD")
 	td6.appendChild(document.createElement("<input type=\"text\" name=\"comments\" size=\"20\"  class=\"inputField\"/>"))

	row.appendChild(td1);

	row.appendChild(td2);
	row.appendChild(td3);
	row.appendChild(td4);
	row.appendChild(td5);
	row.appendChild(td6);
	
    tbody.appendChild(row);
    rowCount=rowCount+1;
	//alert (rowCount);
}
//////////////////////////////
function validateForm (treatment)
{
	var validChars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~-!@#$%^&*()_+|}{\"><.?/;:";
	var spaceChar = " ";
	var validDigs="0123456789";

	if (document.treatment.pComplaints.value == "")
	{
		alert ("Error: Presenting complaints are necessary, Please try again!");
		document.treatment.pComplaints.focus ();
		return false;
	}
	
	for (var i=0;i<document.treatment.pComplaints.value.length;i++)
	{
  		temp=document.treatment.pComplaints.value.substring(i,i+1)

  		if (document.treatment.pComplaints.value.substring(0,1) ==spaceChar)
   		{
			alert ("Error: Invalid presenting complaint/s, Please try again!");
			document.treatment.pComplaints.focus();
    		return false
   		}/*
   		else if (validDigs.indexOf(temp)>=0)
   		{
			alert ("Error: Invalid presenting complaints, Please try again!");
			document.treatment.pComplaints.focus();
    		return false
   		}*/
 	}
	
	if (document.treatment.pDiagnosis.length == 0)
	{
			alert ("Error: Diagnose is necessary, Please try again!");
			document.treatment.diseaseSet.focus();
    		return false
   	}
}