<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import="java.io.*"%>
<%@page import="java.util.*"%>
<%@page import="coshms.ejb.emergency.PharmacyRemote"%>
<%@page import="coshms.domain.emergency.Patient"%>
<%@page import="coshms.domain.emergency.PatientTprb"%>
<%@page import="coshms.util.emergency.*"%>
<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Message</title>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0">
        <form action="issueBalanceMedicine.jsp">
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
            <td valign="top"><jsp:include page="menue.html" flush="true"/></td>

            <td valign="top">

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td colspan="4" height="3"></td>
          </tr>
          <tr> 
            <td width="8" rowspan="2" ><img src="images/left.gif" height="32" /></td>
            <td width="721" rowspan="2" background="images/pixi_bg.gif" class="genArlBFont">Emergency 
              : Message </td>			 <%
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
            <td width="269" background="images/pixi_bg.gif"align="right"><div class="genLoginTag">Welcome, <%=userName%> </div></td>
            <td width="11" rowspan="2"><img src="images/right.gif"  height="32" /></td>
          </tr>
          <tr>
            <td align="right"  bgcolor="#51A4D8"><div class="genLoginTag">
<%if (empName != null){%>
<%=empName%> (<%=designation%>) - <a href="Logout" class="small">Logout</a>
          <%}%>
          </div></td>
          </tr>
          <tr> 
            <td colspan="4" height="3"></td>
          </tr>
          <tr> 
            <td colspan="4"> <table class="normalBorderTable" width="100%"  cellspacing="0" cellpadding="0">
                <tr> 
                  <td align="center"> <br> <img src="images/info.gif" width="32" height="32" /><br> 
                    <!--the work begin-->
                    <div class="genHeadingFont"><%=request.getParameter ("msg")%></div>
                    <br> <br> </td>
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
