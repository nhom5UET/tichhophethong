<%@page import="java.io.*"%>
<%@page import="java.util.*"%>
<%@page import="coshms.ejb.domain.AuthenticationRemote"%>
<%@page import="coshms.util.administration.LookupService"%>
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
        LookupService lookupService = new LookupService ();
        AuthenticationRemote aRemote = lookupService.lookupAuthenticationBean();
        previlige = aRemote.authorizedUser (authResult , "toUpdateStock");
        
        if (previlige == 0)
        {
            response.sendRedirect ("login.jsp");
            session.setAttribute("toUpdateStock","no");
        }
        else if (previlige > 0)
        {
            session.setAttribute("toUpdateStock","yes");
           // response.sendRedirect ("pharmacy.jsp");
        }
            
    }
%>
<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Update Pharmacy Stock</title>
        <script language="javascript" src="scripts/toUpdateStock.js"></script>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0">
     <form action="updatePharmStock.jsp" method="GET" onsubmit="return validateForm (toUpdateStock);" name="toUpdateStock">
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
            <td valign="top"><jsp:include page="menue.html" flush="true"/></td>

            <td valign="top">

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td colspan="4" height="3"></td>
          </tr>
          <tr> 
            <td width="8" rowspan="3" ><img src="images/left.gif" height="32" /></td>
            <td width="496" rowspan="3" background="images/pixi_bg.gif" class="genArlBFont">Emergency 
              : Update Medicine Stock </td>
            <%
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
            <td width="496" background="images/pixi_bg.gif" class="genArlBFont"></td>
            <td width="10" rowspan="3"><img src="images/right.gif"  height="32" /></td>
          </tr>
          <tr> 
            <td background="images/pixi_bg.gif"  class="genLoginTag" align="right">Welcome, <%=userName%></td>
          </tr>
          <tr>
            <td  class="genLoginTag" align="right" bgcolor="#51A4D8"><div class="genLoginTag">
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
                  <td height="100%" valign="top"> 
                    <!--the work begin-->
                    <center>
                      <table width="70%"  border="0" cellspacing="4" cellpadding="4">
                        <tr> 
                          <td  colspan="2">&nbsp;</td>
                        </tr>
                        <tr> 
                          <td width="21%" class="genFont">Enter Your EmpID </td>
                          <td width="79%" class="genFrontFont"><input type="text" name="empId" class="inputField"/></td>
                        </tr>
                        <tr> 
                          <td class="genBFont">&nbsp;</td>
                          <td class="genFrontFont"> <input type="submit" name="Submit" value="Submit" class="btnFormat" /></td>
                        </tr>
                      </table>
                    </center></table></tr>
        </table>

                    </td></tr>
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
