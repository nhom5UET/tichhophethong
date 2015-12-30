<%@page import="java.io.*"%>
<%@page import="java.util.*"%>
<%@page import="coshms.ejb.domain.AuthenticationRemote"%>
<%@page import="coshms.util.domain.*"%>
<%@page import="coshms.util.administration.LookupService"%>
<!--?xml version="1.0" encoding="iso-8859-1"?-->
<html>
    <head>
        <title>User Access Control</title>
        <script language="javascript" src="scripts/toIssueMedicine.js"></script>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
    </head>
    
    <body topmargin="0" leftmargin="0" rightmargin="0">
        <form action="accessControl.jsp" method="post"  onsubmit="return validateForm (toIssueMeds);" name ="toIssueMeds">
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
                        <td width="992" background="images/pixi_bg.gif" class="genArlBFont">Administration : Select User to Assign/Dassign Preveliges </td>
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
                        <center>
                            <table width="50%"  border="0" cellspacing="4" cellpadding="4">
                                <tr><td  colspan="2">&nbsp;</td></tr>
               
                                <tr>
                                    <td width="21%" class="genFont"></td>
                                    <td width="79%" class="genFrontFont">
                                        <select class="listBox" name="userName"  style="width:200;">
                                            <option value="0">Select User Here</option>
                                            <%
                                                //String userName = request.getParameter("userName");
                                                LookupService lookupService = new LookupService();
                                                AuthenticationRemote remote = lookupService.lookupAuthenticationBean();

                                                ArrayList lstUser = new ArrayList();
                                                String userName = null;
                                                String designation = null;
                                                int empId = 0;

                                                try {
                                                    lstUser = remote.getAllUsers();
                                                    Iterator itrUser = lstUser.iterator();

                                                    while (itrUser.hasNext()) 
                                                    {
                                                        Employee employee = new Employee();
                                                        employee = (Employee)itrUser.next();
                                                        userName += employee.getUserName();
                                                        
                                            %>
                                            <option value="<%=employee.getUserName()%>"><%=employee.getUserName()%></option>                                        
                                            <%}
                                                }catch (Exception e){}%>
                                        </select>
                                    </td>
                                </tr>
                             
                                <tr>
                                    <td class="genBFont">&nbsp;</td>
                                    <td class="genFrontFont">
                                    <input type="hidden" name="workForBalanceTransc" value="0"/>
                                    <input type="submit" name="Submit" value="GO" class="btnFormat" /></td>
                                </tr>
                            </table> 
                        </center>
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
