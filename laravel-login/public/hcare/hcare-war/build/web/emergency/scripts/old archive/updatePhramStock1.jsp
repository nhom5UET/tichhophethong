<%@page pageEncoding="UTF-8"%>
<%@page import="java.io.*"%>
<%@page import="java.util.*"%>
<%@page import="coshms.ejb.emergency.PharmacyRemote"%>
<%@page import="coshms.domain.emergency.Patient"%>
<%@page import="coshms.domain.emergency.PatientTprb"%>
<%@page import="coshms.util.emergency.*"%>

<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>Pharmacy : Update Stock</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<script language="javascript" src="js/scripts.js"></script>
        <link href="images/styles.css" rel="stylesheet" type="text/css">
    </head>
    <%
        int empId = Integer.parseInt (request.getParameter ("empId"));
        LookupService lookupService = new LookupService ();
        PharmacyRemote remote = lookupService.lookupPharmacyBean ();
        char shift = 'M';
    %>
<form  name="pharmacyUpdate" action="PharmTransaction" >
    <body>
        <center>
            <table width="700"  border="0" cellspacing="1" cellpadding="1"  class="mainTable">
                <tr>
                    <td class="tableHeader">Emergency Pharmacy : Update Stock </td>
                </tr>
                <tr>
                    <td><table width="100%"  border="0" cellspacing="1" cellpadding="1">
                        <tr>
                            <td colspan="2"  align="left"><span  class="genBFont" >Emp Name: </span><span  class="genFont" ><%=empId%>Ehsan Ali</span></td>
                            <td width="12%"  align="right"><span  class="genBFont" >Shift: </span><span  class="genFont" ><%=shift%></span></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center"><span  class="genBFont" >Medicines in stock </span>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">
                            <select name="availableStock" size="15" style="width:700;" class="listBox"  onChange="selectMeds();">
                                <%
                                    ArrayList list = new ArrayList ();


                                    try
                                    {
                                        list = remote.getMedicineInStock (empId , shift);
                                        Iterator iterator = list.iterator ();
                                        Iterator iterator2 = list.iterator ();
                                        while (iterator.hasNext ())
                                        {
                                            MedicineStock medicineStock = new MedicineStock ();
                                            medicineStock = (MedicineStock)iterator.next ();%>
                                

                                <option value="<%=medicineStock.getMCode ()%>"><%=medicineStock.getName ()%></option>
                                
                                <%}%>
                            </select>
                            <%
                                    while (iterator2.hasNext ())
                                        {
                                            MedicineStock medicineStock = new MedicineStock ();
                                            medicineStock = (MedicineStock)iterator2.next ();%>
                                           <input type="hidden" id="<%=medicineStock.getMCode ()%>"  value="<%=medicineStock.getQty ()%>" />       
                                    <%}
                                    }catch (Exception e) {}%>
                                                 <!--input name="qty" type="text" id="1" value="sasasas" /--> 
                            </td>
                        </tr>
                        <tr>
                            <td width="74%"><span  class="genBFont" >          Medicine Name</span></td>
                            <td width="14%" align="center"><span  class="genBFont" >Availabe Qty </span></td>
                            <td width="12%" align="center"><span  class="genBFont">Update Qty</span></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="mName" class="inputField" size="79" />
                            </td>
                            <td align="center">          <input type="text" name="avlQty" class="inputField" size="5"/></td>
                            <td align="center"><input type="text" name="updQty" class="inputField" size="5"/>
							</td>
							<input type="hidden" name="mCode"/>
							<input type="hidden" name="shift" value = "<%=shift%>"/>
                                                        <input type="hidden" name="empId" value = "<%=empId%>"/>
                        </tr>
                        <tr>
                            <td colspan="3" align="center"><br>
                            <input name="Submit" type="submit"  class="btnLargeFormat" value="    Update    "></td>
                        </tr>
                    </table></td>
                </tr>
            </table>
        </center>
		</form>
    </body>
</html>
