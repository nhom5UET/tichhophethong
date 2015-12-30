<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
   
                    
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Emergecy Home </title>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
    </head>    
    <body topmargin="0" rightmargin="0" leftmargin="0">
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top"><jsp:include page="menue.html" flush="true"/></td>
                <td valign="top">
                    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td colspan="4" height="3"></td>
        </tr>
        <tr> 
          <td width="8" rowspan="2" ><img src="images/left.gif" height="32" /></td>
          <td width="499" rowspan="2" background="images/pixi_bg.gif" class="genArlBFont">Emergency 
            : Pharmacy </td>
			 <%
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
          <td width="286" height="19" align="right" background="images/pixi_bg.gif"><div class="genLoginTag">Welcome, <%=userName%> </div></td>
          <td width="9" rowspan="2"><img src="images/right.gif"  height="32" /></td>
        </tr>
        <tr>
          <td height="14" align="right"  bgcolor="#51A4D8"><div class="genLoginTag">
<%if (empName != null){%>
<%=empName%> (<%=designation%>) - <a href="Logout" class="small">Logout</a>
          <%}%>
          </div></td>
        </tr>
        <tr> 
          <td colspan="4" height="3"></td>
        </tr>
        <!-- main Dept:SubDepartment Name, heading, 3 row completed -->
        <tr> 
          <td colspan="4"> <table width="100%" cellpadding="0"  cellspacing="0" class="normalBorderTable">
              <tr> 
                <td height="60" valign="top" colspan="2"> 
                  <!-- table for interface heading -->
                  <table width="80%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td width="1%">&nbsp;</td>
                      <td width="99%">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td height="24"></td>
                      <td class="topDotedborder"><div class="genHeadingFont">Pharmacy 
                          Home Page</div></td>
                    </tr>
					<tr>
					<td colspan="2"><img src="../images/home.jpg" /></td>
					</tr>
                  </table>
                  <!-- end of table for interface heading -->
                </td>
              </tr>
              <tr> 
                <td width="2%">&nbsp;</td>
                <td width="96%">&nbsp; </td>
                <td width="2%">&nbsp;</td>
              </tr>
              <tr> 
                <td colspan="3">&nbsp; </td>
              </tr>
            </table></td>
        </tr>
      </table>
                </td>
            </tr>
        </table>
    </body>
</html>