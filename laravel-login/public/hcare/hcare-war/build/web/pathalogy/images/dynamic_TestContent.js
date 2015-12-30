// JavaScript Document
var rowCount = 1;
function addRow(id)
{
//	abc();

	rowCount  =rowCount+1;
	var temp;
	var optCounter;
    var tbody = document.getElementById(id).getElementsByTagName("TBODY")[0];
    var row = document.createElement("TR")

    var td1 = document.createElement("<td class=\"genBFont\">")
    td1.appendChild(document.createTextNode(rowCount+"."));

    var td2 = document.createElement("TD")
	var contentName = document.createElement("<input type = \"text\" name = \"cname\" class=\"inputField\"  size=\"50\" />");
	

	td2.appendChild(contentName);

    var td3 = document.createElement("TD")
   	td3.appendChild(document.createElement("<input name=\"minvalue\" type=\"text\" class=\"inputField\" size=\"6\" maxlength=\"6\"/>"))

    var td4 = document.createElement("TD")
 	td4.appendChild(document.createElement("<input name=\"maxvalue\" type=\"text\" class=\"inputField\" size=\"6\" maxlength=\"6\"/>"))

    var td5 = document.createElement("TD")
 	td5.appendChild(document.createElement("<input name=\"unit\" type=\"text\" class=\"inputField\" size=\"6\" maxlength=\"6\"/>"))

	/*
	var td5 = document.createElement("TD")
 
	var selekt = document.createElement("<select name=\"select\" style=\"width:60;\"  class=\"menuFormat\">")

	var opt1 = document.createElement("<option value=\"mg\">")
	var opt2 = document.createElement("<option value=\"dl\">")
	var opt3 = document.createElement("<option value=\"g/dl\">")
	var opt4 = document.createElement("<option value=\"X12/l\">")
	var opt5 = document.createElement("<option value=\"pg\">")
	
	var text1 = document.createTextNode("mg");
   	var text2 = document.createTextNode("dl");
	var text3 = document.createTextNode("g/dl");
	var text4 = document.createTextNode("X12/l");
	var text5 = document.createTextNode("pg");
	
	opt1.appendChild(text1)
	opt2.appendChild(text2)
	opt3.appendChild(text3)
	opt4.appendChild(text4)
	opt5.appendChild(text5)
	
	selekt.appendChild(opt1)
	selekt.appendChild(opt2)
	selekt.appendChild(opt3)
	selekt.appendChild(opt4)
	selekt.appendChild(opt5)
	
	td5.appendChild(selekt)
	*/
	row.appendChild(td1);   row.appendChild(td2);
	row.appendChild(td3);	row.appendChild(td4);
	row.appendChild(td5);	tbody.appendChild(row);
	//temp();

    //document.forms.med.counter.value = rowCount; 
}
