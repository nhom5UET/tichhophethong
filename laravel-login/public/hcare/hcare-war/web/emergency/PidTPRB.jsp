<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page 
import="coshms.ejb.domain.RegisterPatientRemote" 
import="coshms.util.EJBAccessPoint"
import="coshms.util.domain.Patient"
import="java.util.ArrayList"
import="java.util.Iterator"
%>
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
        previlige = aRemote.authorizedUser (authResult , "chkTPRB");
        
        if (previlige == 0)
        {
            session.setAttribute("chkTPRB","no");
            response.sendRedirect ("login.jsp");
        }
        else if (previlige > 0)
        {
            session.setAttribute("chkTPRB","yes");
        }
            
    }
%>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--?xml version="1.0" encoding="iso-8859-1"?-->
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Select Patient for TPRB</title>
			<script language="javascript" src="scripts/PidTPRB.js"></script>
        <link href="../images/styles.css" rel="stylesheet" type="text/css" />
    </head>    
    <body topmargin="0" rightmargin="0" leftmargin="0">
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top"><jsp:include page="include/HomeMenu.htm" flush="true"/></td>
                <td valign="top">
                    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr><td colspan="3" height="3"></td></tr>
                        <tr>
                            <td width="8" ><img src="../images/left.gif" height="32" /></td>
                            
          <td width="992" background="../images/pixi_bg.gif" class="genArlBFont">Emergency 
            : Check TPRB</td>
                            <td width="9"><img src="../images/right.gif"  height="32" /></td>
                        </tr>
                        <tr><td colspan="3" height="3"></td></tr>
                        <!-- main Dept:SubDepartment Name, heading, 3 row completed -->
                        <tr>
                            <td colspan="3">
                                <table width="100%" cellpadding="0"  cellspacing="0" class="normalBorderTable">
                                    <tr>
                                        <td height="60" valign="top" colspan="2"> 
                                            <!-- table for interface heading -->
                                            <table width="80%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="1%">&nbsp;</td>
                                                    <td width="99%">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td class="topDotedborder"><div class="genHeadingFont">Patient 
                          Identification for TPRB:</div></td>
                                                </tr>
                                            </table>
											
                                            <!-- end of table for interface heading -->
                                        </td>
                                    </tr>
                                    <tr><td width="2%">&nbsp;</td>
                <td width="96%"><form method="post" action="TPRBInput.jsp" name="pidTPRB" onsubmit="return validateForm (pidTPRB);"><table width="40%" border="0"  class="mainTable">
                    <tr> 
                      <td colspan="2" class="tableHeader">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td width="23%">&nbsp;</td>
                      <td width="77%">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td class="genFont">Enter PID </td>
                      <td class="genFont"><input name="pid" type="text" class="inputField" size="10" maxlength="10" /></td>
                    </tr>
                    <tr> 
                      <td class="genBFont">&nbsp;</td>
                      <td>&nbsp; </td>
                    </tr>
                    <tr class="tableFooter"> 
                      <td><div align="right"></div></td>
                      <td ><input type="submit" class="btnFormat" value="Submit" />
                        <input name="reset" type="reset" class="btnFormat" value="Clear" />
                        <br /></td>
                    </tr>
					
                  </table> 
                </form></td>
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