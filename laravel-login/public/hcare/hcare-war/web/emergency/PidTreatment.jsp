<%@page language="java" import="java.sql.*" errorPage="" %>
<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
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
    else if (authResult>0)
    {
        int previlige = 0;
        coshms.util.administration.LookupService lookupService = new coshms.util.administration.LookupService ();
        AuthenticationRemote aRemote = lookupService.lookupAuthenticationBean();
        previlige = aRemote.authorizedUser (authResult , "newTreatment");
        
        if (previlige == 0)
        {
            session.setAttribute("newTreatment","no");
            response.sendRedirect ("login.jsp");
        }
        else if (previlige > 0)
        {
            session.setAttribute("newTreatment","yes");
        }
    }
%>

<!--?xml version="1.0" encoding="iso-8859-1"?-->
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Select Patient for Treatment</title>
        <link href="../images/styles.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="scripts/PidTreatment.js"></script>
    </head>    
    <body topmargin="0" rightmargin="0" leftmargin="0">
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top"><jsp:include page="include/TreatmentMenu.html" flush="true"/></td>
                <td valign="top">
                    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr><td colspan="3" height="3"></td></tr>
                        <tr>
                            <td width="8" ><img src="../images/left.gif" height="32" /></td>
                            
          <td width="992" background="../images/pixi_bg.gif" class="genArlBFont">Emergency 
            : Patient Treatment</td>
                            <td width="9"><img src="../images/right.gif"  height="32" /></td>
                        </tr>
                        <tr><td colspan="3" height="3"></td></tr>
                        <!-- main Dept:SubDepartment Name, heading, 3 row completed -->
                        <tr>
                            <td colspan="3">
                                <table width="100%" cellpadding="0"  cellspacing="0" class="normalBorderTable">
                                    <tr>
                                        <td height="82" valign="top" colspan="2"> 
                                            <!-- table for interface heading -->
                                            <table width="80%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="1%">&nbsp;</td>
                                                    <td width="99%">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td height="24"></td>
                                                    <td class="topDotedborder"><div class="genHeadingFont">New Treatment:</div></td>
                                                </tr>
                                            </table>
											
                                            <!-- end of table for interface heading -->
                                        </td>
                                    </tr>
                                    <tr><td width="2%">&nbsp;</td>
                                        
                <td width="96%"><form name="pidTreat" method="post" action="Treatment.jsp" onSubmit="return validateForm (pidTreat);"> 
              <table width="40%" border="0" class="mainTable">
                <tr> 
                        <td colspan="2" class="tableHeader">&nbsp;</td>
                </tr>
                
                <tr>
                  <td class="genBFont">PID:</td>
                  <td class="genFont"><input name="pid" type="text" class="inputField" size="10" maxlength="10"></td>
                </tr>
                <tr> 
                  <td class="genBFont">&nbsp;</td>
                  <td>&nbsp; </td>
                </tr>
                <tr class="tableFooter"> 
                  <td><div align="right"> </div></td>
                  <td ><input type="submit" name="Submit" value="Submit" class="btnFormat">
                          <input type="reset" name="Reset" value="Clear"  class="btnFormat"/></td>
                </tr>
              </table>
            </form> </td>
                <td width="2%">&nbsp;</td>
                                    </tr>
                                    <tr> 
                                        <td colspan="3">&nbsp; </td>
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