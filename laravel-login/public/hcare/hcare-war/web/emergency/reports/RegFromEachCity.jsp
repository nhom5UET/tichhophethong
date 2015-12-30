<%@page contentType="text/html" 
import="java.sql.Date"
import="coshms.util.BasicFunction"
import="coshms.util.emergency.reports.EncPatients"
import="coshms.util.EJBAccessPoint"
import="java.util.ArrayList"
import="java.util.Iterator"
import="coshms.util.domain.MapInt"
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
ArrayList cityList = new EJBAccessPoint().lookupRepEmgBean().regFromEachCityBw(fromDate,toDate);
Iterator itr = cityList.iterator();
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
            : Report on Patient Registeration from Diffrent Cities </td>
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
                      <td width="26%"><div class="genBFont">Criteria:<br />
                        </div>
                        <div class="genFont">@<%=new BasicFunction().getDateString(fromDate)%> to <%=new BasicFunction().getDateString(toDate)%></div> 
                      </b></td>
                      <b><td width="35%">&nbsp;</td>
                      <td width="39%"><div align="right"><a href="RegFromEachCityReport?fromDate=<%=request.getParameter("fromDate")%>&toDate=<%=request.getParameter("toDate")%>"><img src="../images/pdf_icon.gif" width="20" height="20" border=0/></a>&nbsp;<img src="../images/diagram.gif" border=0 width="20" height="20"  onclick="small_window('RegFromEachCityReport?fromDate=<%=request.getParameter("fromDate")%>&toDate=<%=request.getParameter("toDate")%>')"/>&nbsp;<img src="../images/print.gif" width="20" height="20" /></div></td>
                      </b> 
                    </tr>
                    <tr bgcolor="#EFEFEF"> 
                      <td class="topborder" ><div class="genBFont">City Name</div></td>
                      <td class="topborder" colspan="2" ><div class="genBFont">Number of Patients</div></td>
                    </tr>
<%
MapInt map = null;
while(itr.hasNext()){
    map = (MapInt)itr.next();
%>
<tr>
<td class="topborder"  ><div class="genFont"><%=map.getKey()%></div></td>
<td colspan="2" class="topborder"  ><div class="genFont"><%=map.getValue()%></div></td>
                    </tr>
                    <%}%>
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