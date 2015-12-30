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


<html>
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
            <td colspan="4" height="3"></td>
          </tr>
          <tr> 
            <td width="8" rowspan="2" ><img src="images/left.gif" height="32" /></td>
            <td width="693" rowspan="2" background="images/pixi_bg.gif" class="genArlBFont">Emergency 
              : Stock Outflow </td>			 <%
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
            <td width="279" background="images/pixi_bg.gif" class="genLoginTag"  align="right">Welcome, 
              <%=userName%> </td>
            <td width="12" rowspan="2"><img src="images/right.gif"  height="32" /></td>
          </tr>
          <tr>
            <td  align="right" class="genLoginTag" bgcolor="#51A4D8"> 
              <%if (empName != null){%>
              <%=empName%> (<%=designation%>) - <a href="Logout" class="small">Logout</a> 
              <%}%>
            </td>
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
                        <td width="40%"><div class="genBFont">Shift:</div>
                          <div class="genFont"> <%=shiftId%> @ <%=fromDate%> to 
                            <%=toDate%><br />
                            Sorted by Date </div></td>
                        <td width="14%"  align="right">&nbsp;</td>
                        <td width="14%"  align="right">&nbsp;</td>
                        <td width="10%"  align="right">&nbsp;</td>
                        <td width="40%"  align="right"><img src="images/pdf_icon.gif" alt="View PDF" width="20" height="20" />&nbsp;<img src="images/print.gif" alt="Print this page" width="20" height="20" /></td>
                      </tr>
                      <tr bgcolor="#EFEFEF"> 
                        <td class="topborder"><div class="genBFont">Medicine Name</div></td>
                        <td class="topborder"><div class="genBFont">Issue Qty 
                          </div></td>
                        <td class="topborder"><span class="genBFont">Date</span></td>
                        <td class="topborder"><span class="genBFont">Time</span></td>
                        <td class="topborder"><span class="genBFont">Issued by 
                          </span></td>
                      </tr>
                      <%           
                                                        LookupService lookupService = new LookupService ();
                                                        PharmacyRemote remote = lookupService.lookupPharmacyBean ();
                                                        

                                                        ArrayList list = new ArrayList ();


                                                        try
                                                        {
                                                        list = remote.getStockOutflow ( fromThisDate , toThisDate , shift);
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
                        <td class="topborder"><div class="genFont"><%=medicineStock.getTime()%></div></td>
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