<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import="java.io.*"%>
<%@page import="java.util.*"%>
<%@page import="coshms.ejb.domain.AuthenticationRemote"%>
<%
//if (session.getAttribute ("login").equals ("no"))
    String authenticated = null;
    int authResult = 0;
    try{
        authResult = Integer.parseInt ((String)session.getAttribute ("login"));
    }catch (Exception e){}
    
     if (authResult == 0)
    {
        response.sendRedirect ("login.jsp");
    }
    else if (authResult > 0)
    {
        int previlige = 0;
        coshms.util.administration.LookupService lookupService = new coshms.util.administration.LookupService ();
        AuthenticationRemote aRemote = lookupService.lookupAuthenticationBean();
        previlige = aRemote.authorizedUser (authResult , "reportPharmCurrentStock");
        
        if (previlige == 0)
        {
            session.setAttribute("reportPharmCurrentStock","no");
            response.sendRedirect ("login.jsp");
        }
        else if (previlige > 0)
        {
            session.setAttribute("reportPharmCurrentStock","yes");
        }
            
    }%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Current Stock Report</title>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0">
       <form  name="stockRemport"  action="currentPharmStock.jsp"  method="post">
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
            <td valign="top"><jsp:include page="reportMenue.html" flush="true"/></td>

            
    <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td colspan="4" height="3"></td>
          </tr>
          <tr> 
            <td width="8" rowspan="2" ><img src="images/left.gif" height="32" /></td>
            <td width="618" rowspan="2" background="images/pixi_bg.gif" class="genArlBFont">Emergency 
              : Current Stock</td>			 <%
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
            <td width="372" background="images/pixi_bg.gif" class="genLoginTag" align="right">Welcome, 
              <%=userName%></td>
            <td width="11" rowspan="2"><img src="images/right.gif"  height="32" /></td>
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
          <tr> 
            <td  colspan="4"> <table width="100%"   cellpadding="0"  cellspacing="0" class="normalBorderTable">
                <tr> 
                  <td height="99" valign="top" align="center"> <table width="70%"  border="0" cellspacing="0" cellpadding="3">
                      <tr> 
                        <td  class="genBFont">&nbsp;</td>
                        <td class="genFrontFont">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td width="34%" class="genBFont">Select Shift to View 
                          Stock</td>
                        <td width="66%" class="genFrontFont"> <select name="shift"  class="listBox" style="width:100;">
                            <option value="0"></option>
                            <option value="Morning">Morning</option>
                            <option value="Noon">Noon</option>
                            <option value="Evening">Evening</option>
                          </select></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">&nbsp;</td>
                        <td class="genFrontFont"><input type="submit" name="Submit" value="View"  class="btnFormat"/> 
                        </td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
  </tr>
        </table></form>
            </body>
</html>
