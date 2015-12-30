// JavaScript Document
	var rowCount=3;
function addRow(id)
{
    var tbody = document.getElementById(id).getElementsByTagName("TBODY")[0];
    var row = document.createElement("TR")

    var td1 = document.createElement("<td>")
	
    var td2 = document.createElement("TD")
	td2.appendChild(document.createElement("<select name=\"medicine1"+rowCount+"\" style=\"width:400;\"><option>Select Medicine Here</option></select>"))

    var td3 = document.createElement("TD")
   	 td3.appendChild(document.createElement("<input type=\"checkbox\" name=\"m" +rowCount + "\" value=\"1\" />"))

    var td4 = document.createElement("TD")
 	td4.appendChild(document.createElement("<input type=\"checkbox\" name=\"n" +rowCount + "\" value=\"1\" />"))

    var td5 = document.createElement("TD")
 	td5.appendChild(document.createElement("<input type=\"checkbox\" name=\"e" +rowCount + "\" value=\"1\" />"))

    var td6 = document.createElement("TD")
 	td6.appendChild(document.createElement("<input type=\"text\" name=\"qty" +rowCount + "\" size=\"4\" />"))

    var td7 = document.createElement("TD")
 	td7.appendChild(document.createElement("<input type=\"text\" name=\"period" +rowCount + "\" size=\"4\" />"))


    var td8 = document.createElement("TD")
 	td8.appendChild(document.createElement("<input type=\"text\" name=\"com" +rowCount + "\" size=\"34\" />"))

	var td9 = document.createElement("TD")
// 	td9.appendChild(document.createElement("<input type=\"hidden\" name=\"counter\"  value=\"+rowCount+1\" />"))
	td9.appendChild(document.createElement("<input type=\"hidden\" name=\"counter\"   />"))//value=rowCount+1

//    row.appendChild(td1);
    row.appendChild(td2);
	row.appendChild(td3);
	row.appendChild(td4);
	row.appendChild(td5);
	row.appendChild(td6);
	row.appendChild(td7);
	row.appendChild(td8);
	row.appendChild(td9);

    tbody.appendChild(row);
	temp();
    rowCount=rowCount+1;
}

function temp ()
{
document.forms.med.value = rowCount+1;
}

function temp1 ()
{
alert(document.forms.med.value)
}
