<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import="java.io.*"%>
<%@page import="java.util.*"%>
<%@page import="coshms.ejb.emergency.PharmacyRemote"%>
<%@page import="coshms.domain.emergency.Patient"%>
<%@page import="coshms.ejb.domain.AuthenticationRemote"%>
<%@page import="coshms.util.administration.LookupService"%>

<?xml version="1.0" encoding="iso-8859-1"?>
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
        previlige = aRemote.authorizedUser (authResult , "toIssueMedicine");
        
        if (previlige == 0)
        {
            session.setAttribute("toIssueMedicine","no");
            response.sendRedirect ("login.jsp");
        }
        else if (previlige > 0)
        {
            session.setAttribute("toIssueMedicine","yes");
        }
            
    }%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Select Patient to Issue Medicine</title>
        <script language="javascript" src="scripts/toIssueMedicine.js"></script>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0">
     <form action="getTreatments.jsp" method="POST"  onsubmit="return validateForm (toIssueMeds);" name ="toIssueMeds">
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
            <td width="496" rowspan="2" background="images/pixi_bg.gif" class="genArlBFont">Emergency 
              : Select Patient to Issue Medicine </td>			 <%
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
    
            <td width="496" background="images/pixi_bg.gif"  class="genLoginTag" align="right">Welcome, 
              <%=userName%> </td>
            <td width="10" rowspan="2"><img src="images/right.gif"  height="32" /></td>
          </tr>
          <tr>
            <td  class="genLoginTag"  bgcolor="#51A4D8" align="right">
<%if (empName != null){%>
<%=empName%> (<%=designation%>) - <a href="Logout" class="small">Logout</a>
          <%}%></td>
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
                      <table width="50%"  border="0" cellspacing="4" cellpadding="4">
                        <tr> 
                          <td  colspan="2">&nbsp;</td>
                        </tr>
                        <tr> 
                          <td width="21%" class="genFont">Enter PID </td>
                          <td width="79%" class="genFrontFont"><input type="text" name="pid" class="inputField"/></td>
                        </tr>
                        <tr> 
                          <td class="genBFont">&nbsp;</td>
                          <td class="genFrontFont"> <input type="hidden" name="workForBalanceTransc" value="0"/> 
                            <input type="submit" name="Submit" value="Submit" class="btnFormat" /></td>
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
