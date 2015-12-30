<%@page import="java.sql.Date"%>
<%@page import="java.io.*"%>
<%@page import="java.util.*"%>
<%@page import="coshms.ejb.emergency.PharmacyRemote"%>
<%@page import="coshms.domain.emergency.Patient"%>
<%@page import="coshms.domain.emergency.PatientTprb"%>
<%@page import="coshms.util.emergency.*"%>
<%@page import="coshms.util.BasicFunction"%>
<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Update Pharmacy Stock</title>
        <script language="javascript" src="scripts/updatePharmStock.js"></script>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0">
        <form  name="pharmacyUpdate" action="PharmTransaction" onsubmit="return validateForm (pharmacyUpdate);">
            <table  border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="top"><jsp:include page="reportMenue.html" flush="true"/></td>

                    <td valign="top">

                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td colspan="3" height="3"></td>
                            </tr>
                            <tr>
                                <td width="8" ><img src="images/left.GIF" height="32" /></td>
                                <td width="992" background="images/pixi_bg.GIF" class="genArlBFont">Emergency : Stock Consumption </td>
                                <td width="10"><img src="images/right.GIF"  height="32" /></td>
                            </tr>
                            <tr>
                                <td colspan="3" height="3"></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <table class="normalBorderTable" width="100%"  cellspacing="0" cellpadding="5">
                                        <tr>
                                            <td height="100%" valign="top" > 
                                                <!--the work begin-->

 

                                                <table width="100%" border="0" cellspacing="0" cellpadding="7">
                                                    <tr>
                                                        <%     
                                                            String fromDate = request.getParameter ("fromDate");
                                                            String toDate = request.getParameter ("toDate");
                                                            
                                                        Date fromThisDate = new BasicFunction ().strToDate (fromDate);
                                                        Date toThisDate  =  new BasicFunction ().strToDate (toDate);
                                                        %>
                       
                                                        <td width="46%"><div class="genBFont">Criteria:</div><div class="genFont">@ <%=fromDate%> to <%=toDate%><br />
                                                        Sorted by Consumed Qty </div>                                                        </td>
                                                        <td width="54%"  align="right"><a href="ConsumptionReport?fromDate=<%=fromDate%>&toDate=<%=toDate%>"><img src="images/pdf_icon.gif" alt="get PDF" width="20" height="20"  border="0"/></a>&nbsp;<a href="ConsumptionReport?fromDate=<%=fromDate%>&toDate=<%=toDate%>"><img src="images/diagram.gif" width="20" height="20" alt="View Graph"/></a>&nbsp;<img src="images/print.gif" alt="print" width="20" height="20" /></td>
                                                    </tr>
                                                    <tr bgcolor="#EFEFEF">
                                                        <td class="topborder"><div class="genBFont">Medicine Name</div></td>
                                                        <td class="topborder"><div class="genBFont">Consumed Qty </div></td>
                                                        </tr>
                                                        <%           
                                                        LookupService lookupService = new LookupService ();
                                                        PharmacyRemote remote = lookupService.lookupPharmacyBean ();
                                                        int empId = 0;

                                                        ArrayList list = new ArrayList ();


                                                        try
                                                        {
                                                        list = remote.getStockConsumption( fromThisDate , toThisDate);
                                                        Iterator iterator = list.iterator ();
                                                        
                                                        while (iterator.hasNext ())
                                                        {
                                                        MedicineStock medicineStock = new MedicineStock ();
                                                        medicineStock = (MedicineStock)iterator.next ();

                                                    %>
                                                    <tr>
                                                        <td class="topborder"><div class="genFont"><%=medicineStock.getName()%></div></td>
                                                        <td class="topborder"><div class="genFont"><%=medicineStock.getQty()%></div></td>
                                                    </tr>
                 
                                                    <%
                                                        }
                                                        }
                                                        catch (Exception e)
                                                        {}
                                                    %>
                                                </table> 
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
