<%@page contentType="text/html" 
import="java.sql.Date"
import="coshms.util.BasicFunction"
import="coshms.util.emergency.reports.EncPatients"
import="coshms.util.EJBAccessPoint"
%>
<%@page pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Emergecy Home </title>
        <link href="../images/styles.css" rel="stylesheet" type="text/css" />
    </head>    
    <body topmargin="0" rightmargin="0" leftmargin="0">
<%
Date fromDate = (Date)request.getAttribute("fromDate");
Date toDate = (Date)request.getAttribute("toDate");
EncPatients encPts = new EJBAccessPoint().lookupRepEmgBean().PatientsEncBw(fromDate,toDate);
%>
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top"><jsp:include page="menu.html" flush="true"/></td>
                <td valign="top">
                    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr><td colspan="3" height="3"></td></tr>
                        <tr>
                            <td width="8" ><img src="../images/left.gif" height="32" /></td>
                            
          <td width="992" background="../images/pixi_bg.gif" class="genArlBFont">Emergency 
            : Encounter Report </td>
                            <td width="9"><img src="../images/right.gif"  height="32" /></td>
                        </tr>
                        <tr><td colspan="3" height="3"></td></tr>
                        <!-- main Dept:SubDepartment Name, heading, 3 row completed -->
                        <tr>
                            <td colspan="3">
                                <table width="100%" cellpadding="0"  cellspacing="0" class="normalBorderTable">
                                
                                    <tr><td width="99%">
                  <table width="100%" border="0" cellspacing="0" cellpadding="7">
                    <tr> 
                      <td width="28%"><span class="genBFont">Criteria</span>:<br />
                        <span class="genFont">@ <%=new BasicFunction().getDateString(fromDate)%> to <%=new BasicFunction().getDateString(toDate)%></span></td>
                      <td width="36%">&nbsp;</td>
                      <td width="36%"><div align="right"><b><a href="EncPatientsReport?fromDate=<%=request.getParameter("fromDate")%>&toDate=<%=request.getParameter("toDate")%>"><img src="../images/pdf_icon.gif" width="20" height="20"  border="0"/></a>&nbsp;<a href="EncPatientsReport?fromDate=<%=request.getParameter("fromDate")%>&toDate=<%=request.getParameter("toDate")%>"><img border="0" src="../images/diagram.gif" width="20" height="20" onclick="small_window('EncPatientsReport?fromDate=<%=request.getParameter("fromDate")%>&toDate=<%=request.getParameter("toDate")%>')"/></a>&nbsp;<img src="../images/print.gif" width="20" height="20" /></b></div></td>
                    </tr>
                    <tr>
                      <td class="topborder"><div class="genBFont">Total Patients Registered:</div></td>
                      <td class="topborder" colspan="2"><div class="genFont"><%=encPts.getTotal()%></div></td>
                    </tr>
                    <tr> 
                      <td class="topborder"><div class="genBFont">Number of Males:</div></td>
                      <td colspan="2" class="topborder"><div class="genFont"><%=encPts.getMales()%></div></td>
                    </tr>
                    <tr>
                      <td class="topborder"><div class="genBFont">Number of Females:</div></td>
                      <td colspan="2" class="topborder"><div class="genFont"><%=encPts.getFemales()%></div></td>
                    </tr>
                  </table>
                </td>
                                        
                <td width="1%">&nbsp; </td>
                <td width="0%">&nbsp;</td>
                                    </tr>
                                 
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>