<%@page contentType="text/html" 
import="java.sql.Date"
import="coshms.util.BasicFunction"
import="coshms.util.emergency.reports.EncPatients"
import="coshms.util.EJBAccessPoint"
import="coshms.util.emergency.reports.DiseaseDiag"
import="java.util.*"

%>
<%@page pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Disease Report</title>
        <link href="../images/styles.css" rel="stylesheet" type="text/css" />
    </head>
    <body topmargin="0" rightmargin="0" leftmargin="0">
<%
Date fromDate = (Date)request.getAttribute("fromDate");
Date toDate = (Date)request.getAttribute("toDate");
ArrayList list = new EJBAccessPoint().lookupRepEmgBean().diseasesDiagBw(fromDate,toDate);
Iterator itrDD=list.iterator();
//list contains DiseaseDiag objects collection
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
            : Disease Report </td>
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
                      <td width="36%"><div align="right"><b><a href="DiseasesDiagReport?fromDate=<%=request.getParameter("fromDate")%>&toDate=<%=request.getParameter("toDate")%>"><img src="../images/pdf_icon.gif" width="20" height="20"  border="0"/></a>&nbsp;<a href="EncPatientsReport?fromDate=<%=request.getParameter("fromDate")%>&toDate=<%=request.getParameter("toDate")%>"><img border="0" src="../images/diagram.gif" width="20" height="20" onclick="small_window('EncPatientsReport?fromDate=<%=request.getParameter("fromDate")%>&toDate=<%=request.getParameter("toDate")%>')"/></a>&nbsp;<img src="../images/print.gif" width="20" height="20" /></b></div></td>
                    </tr>
                    
                    <tr>
                      <td colspan="3" class="topborder"><div class="genBFont">
                        <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                          <tr>
                            <th width="18%" scope="col"><div align="left">Disease Code </div></th>
                            <th width="65%" scope="col"><div align="left">Disease Name </div></th>
                            <th width="17%" scope="col"><div align="left">Count</div></th>
                          </tr>
                          <%
                          DiseaseDiag dd = new DiseaseDiag();
                          while(itrDD.hasNext()){
                              dd = (DiseaseDiag)itrDD.next();
                          %>
                           <tr class="genFont">
                            <td><div align="left"><%=dd.getDCode()%></div></td>
                            <td><div align="left"><%=dd.getName()%></div></td>
                            <td><div align="left"><%=dd.getCount()%></div></td>
                           </tr>
                          <%}%>
                        </table>
                      </div>                          
                      </td>
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