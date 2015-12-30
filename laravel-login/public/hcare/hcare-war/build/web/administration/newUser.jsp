<%@page import="java.io.*"%>
<%@page import="java.util.*"%>
<%@page import="coshms.ejb.domain.AuthenticationRemote"%>
<%@page import="coshms.util.domain.*"%>
<%@page import="coshms.util.administration.LookupService"%>
<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Create New User Account</title>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
        <script language="JavaScript"  src="scripts/accessControl.js"></script>
    </head>
    <%
        String errorId = null;
        errorId = request.getParameter("errorId");

    %>
    <body topmargin="0" leftmargin="0" rightmargin="0">
        <form action="NewUser" method="post" name="newUser">
            <table  border="0" cellspacing="0" cellpadding="0">
                <tr>
                <td valign="top"><jsp:include page="menue.html" flush="true"/></td>

                <td valign="top">

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td colspan="3" height="3"></td>
                    </tr>
                    <tr>
                        <td width="8" ><img src="images/left.gif" height="32" /></td>
                    
                        
                        <td width="992" background="images/pixi_bg.gif" class="genArlBFont">Administration 
                        : New User</td>
                        <td width="10"><img src="images/right.gif"  height="32" /></td>
                    </tr>
                    <tr>
                        <td colspan="3" height="3"></td>
                    </tr>
                    <tr>
                    <td colspan="3">
                    <table class="normalBorderTable" width="100%"  cellspacing="0" cellpadding="0">
                        <tr><td height="100%" valign="top">
                        
                        <!--the work begin-->


                        
                        <table width="100%"  border="0" cellspacing="4" cellpadding="4">
                            <tr> 
                                <td width="22%" class="genBFont">Employee ID</td>
                                <td colspan="2" class="genFrontFont"><input type="text" name="empId" class="inputField" /></td>
                            </tr>
                            <tr> 
                                <td class="genBFont">User Name</td>
                                <td width="25%" class="genFrontFont"><input type="text" name="userName"  class="inputField"/> 
                                </td>
                                <td width="53%" class="genFrontFont">
                                    <%
                                        if (errorId != null) 
                                        {
                                             if (errorId.equals("un")) 
                                             {
                                        %>
                                            User name already exists, try another!
<%
                                            }
                                            else if (errorId.equals("id"))
                                            {
                    %>
                                            A user name has already alotted to this employee!
                                    <%      }
                                            else if (errorId.equals("x"))
                                            {%>
                                            Can't create account, Please verify your employee exist or enter valid informatin
                                       <%    }
                                       }%>
                                    
                                </td>
                            </tr>
                            <tr> 
                                <td class="genBFont">Password</td>
                                <td colspan="2" class="genFrontFont"><input type="password" name="password" class="inputField" /></td>
                            </tr>
                            <tr> 
                                <td class="genBFont">&nbsp;</td>
                                <td colspan="2" class="genFrontFont"><input type="submit" name="Submit" value="Check"  class="btnFormat"/> 
                                <br /> </td>
                            </tr>
                        </table>
                       
                        

                 
                    </table>


                    </tr>
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
