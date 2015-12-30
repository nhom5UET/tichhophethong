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
                                                    isPreviliged = (String)session.getAttribute("reportPharmConsum");
                                                  
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
            <td width="431" rowspan="2" background="images/pixi_bg.gif" class="genArlBFont">Emergency 
              : Stock Consumption </td> <%
                                                       String empName = null;
                                                       String designation = null;
                                                       String empId = null;
                                                       String login = null;
                                                       String userName = null;
                                                       
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
            <td width="542" background="images/pixi_bg.gif"  class="genLoginTag" align="right">Welcome, 
              <%=userName%></td>
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
                                                            
                                                        Date fromThisDate = new BasicFunction ().strToDate (fromDate);
                                                        Date toThisDate  =  new BasicFunction ().strToDate (toDate);
                                                        %>
                        <td width="46%"><div class="genBFont">Criteria:</div>
                          <div class="genFont">@ <%=fromDate%> to <%=toDate%><br />
                            Sorted by Consumed Qty </div></td>
                        <td width="54%"  align="right"><a href="ConsumptionReport?fromDate=<%=fromDate%>&toDate=<%=toDate%>"><img src="images/pdf_icon.gif" border=0 alt="get PDF" width="20" height="20" /></a>&nbsp;<img src="images/diagram.gif" width="20" height="20" alt="View Graph"/>&nbsp;<img src="images/print.gif" alt="print" width="20" height="20" /></td>
                      </tr>
                      <tr bgcolor="#EFEFEF"> 
                        <td class="topborder"><div class="genBFont">Medicine Name</div></td>
                        <td class="topborder"><div class="genBFont">Consumed Qty 
                          </div></td>
                      </tr>
                      <%           
                                                        LookupService lookupService = new LookupService ();
                                                        PharmacyRemote remote = lookupService.lookupPharmacyBean ();
                                                        

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