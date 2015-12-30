<%@page import="java.sql.Date"%>
<%@page import="java.io.*"%>
<%@page import="java.util.*"%>
<%@page import="coshms.ejb.emergency.PharmacyRemote"%>
<%@page import="coshms.domain.emergency.Patient"%>
<%@page import="coshms.domain.emergency.PatientTprb"%>
<%@page import="coshms.util.emergency.*"%>
<%@page import="coshms.util.BasicFunction"%>
<%
                                                String isPreviliged = null;
                                                //char shift = 'M';
                                               
                                               // try {
                                                    isPreviliged = (String)session.getAttribute("reportPharOutflow");
                                                  
                                                //}catch (Exception ex1) {}

                                                if (isPreviliged == null) {
                                                    response.sendRedirect("login.jsp");
                                                } else if (isPreviliged.equals("no")) {
                                                    response.sendRedirect("login.jsp");
                                                } 
                                                else if (isPreviliged.equals("yes"))
                                                {
%>
<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Stock Arival</title>
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
            <td colspan="4" height="3"></td>
          </tr>
          <tr> 
            <td width="8" rowspan="2" ><img src="images/left.gif" height="32" /></td>
            <td width="514" rowspan="2" background="images/pixi_bg.gif" class="genArlBFont">Emergency 
              : Stock Arival </td>			 <%
                                                       String empName = null, designation = null, empId = null , login = null, userName = null;
                                                       login = (String)session.getAttribute ("login");
                                                       empId = (String)session.getAttribute ("empId");
                                                       empName = (String)session.getAttribute ("empName");
                                                       designation = (String)session.getAttribute ("designation");
                                                       userName = (String)session.getAttribute ("userName");
            if (userName == null)
            {
                                                           userName = "Guest";
            }
%>
            <td width="476" background="images/pixi_bg.gif"  class="genLoginTag" align="right">Welcome, <%=userName%></td>
            <td width="11" rowspan="2"><img src="images/right.gif"  height="32" /></td>
          </tr>
          <tr>
            <td bgcolor="#51A4D8" class="genLoginTag" align="right">
<%if (empName != null){%>
<%=empName%> (<%=designation%>) - <a href="Logout" class="small">Logout</a>
          <%}%></td>
          </tr>
          <tr> 
            <td colspan="4" height="3"></td>
          </tr>
          <tr> 
            <td colspan="4"> <table class="normalBorderTable" width="100%"  cellspacing="0" cellpadding="5">
                <tr> 
                  <td height="100%" valign="top" > 
                    <!--the work begin-->
                    <table width="100%" border="0" cellspacing="0" cellpadding="7">
                      <tr> 
                        <%     
                                                            String fromDate = request.getParameter ("fromDate");
                                                            String toDate = request.getParameter ("toDate");
                                                            String shift = request.getParameter ("shift");
                                                            String shiftId = null;
                                                            
                                                            if (shift.equals ("M"))
                                                            {
                                                                shiftId = "Morning";
                                                            }
                                                            else if (shift.equals ("E"))
                                                            {
                                                                shiftId = "Evening";
                                                            }
                                                            else if (shift.equals ("N"))
                                                            {
                                                                shiftId = "Noon";
                                                            }

                                                        Date fromThisDate = new BasicFunction ().strToDate (fromDate);
                                                        Date toThisDate  =  new BasicFunction ().strToDate (toDate);
                                                        %>
                        <td width="33%"><div class="genBFont">Shift:</div>
                          <div class="genFont"> <%=shiftId%> @ <%=fromDate%> to 
                            <%=toDate%><br />
                            Sorted by Date </div></td>
                        <td width="14%"  align="right">&nbsp;</td>
                        <td width="20%"  align="right">&nbsp;</td>
                        <td width="60%"  align="right"><img src="images/pdf_icon.gif" alt="get PDF" width="20" height="20" />&nbsp;<img src="images/print.gif" alt="print" width="20" height="20" /></td>
                      </tr>
                      <tr bgcolor="#EFEFEF"> 
                        <td class="topborder"><div class="genBFont">Medicine Name</div></td>
                        <td class="topborder"><div class="genBFont">Updated Qty</div></td>
                        <td class="topborder"><span class="genBFont">Date</span></td>
                        <td class="topborder"><span class="genBFont">Updated by 
                          </span></td>
                      </tr>
                      <%           
                                                        LookupService lookupService = new LookupService ();
                                                        PharmacyRemote remote = lookupService.lookupPharmacyBean ();
                                                       

                                                        ArrayList list = new ArrayList ();


                                                        try
                                                        {
                                                        list = remote.getStockInflow ( fromThisDate , toThisDate , shift);
                                                        Iterator iterator = list.iterator ();
                                                        Iterator iterator2 = list.iterator ();
                                                        while (iterator.hasNext ())
                                                        {
                                                        MedicineStock medicineStock = new MedicineStock ();
                                                        medicineStock = (MedicineStock)iterator.next ();

                                                    %>
                      <tr> 
                        <td class="topborder"><div class="genFont"><%=medicineStock.getName()%></div></td>
                        <td class="topborder"><div class="genFont"><%=medicineStock.getQty()%></div></td>
                        <td class="topborder"><div class="genFont"><%=medicineStock.getDate()%></div></td>
                        <td class="topborder"><div class="genFont"><%=medicineStock.getEmpName()%></div></td>
                      </tr>
                      <%
                                                        }
                                                        }
                                                        catch (Exception e)
                                                        {}
                                                    %>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table>

                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
<%}%>