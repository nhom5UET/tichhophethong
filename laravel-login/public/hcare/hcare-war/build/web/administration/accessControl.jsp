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
        <title>User Access Control</title>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
        <script language="JavaScript"  src="scripts/accessControl.js"></script>
    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0">
        <form action="AccessControl" method="post" name="access">
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
                        : User Access Control</td>
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
                        <%
                            String[] uName = request.getParameterValues("userName");
                            String userName = uName[0];
                            LookupService lookupService = new LookupService();
                            AuthenticationRemote remote = lookupService.lookupAuthenticationBean();

                            ArrayList listEmployee = new ArrayList();
                            ArrayList listAllPrev = new ArrayList();
                            ArrayList listAssignedPrev = new ArrayList();
                            String employeeName = null;
                            String designation = null;
                            int empId = 0;

                            try {
                                listEmployee = remote.getEmployeeInfo(uName[0]);
                                Iterator iteratorEmployee = listEmployee.iterator();

                                while (iteratorEmployee.hasNext()) {
                                    Employee employee = new Employee();
                                    employee = (Employee)iteratorEmployee.next();
                                    employeeName = employee.getEmployeeName();
                                    empId = employee.getEmpId();
                                    designation = employee.getDesignation();

                        %>

                        <input type="hidden" value="<%=userName%>" name="userName"/>
           <input type="hidden" value="<%=empId%>" name="empId"/>

                    <table width="100%"  border="0" cellspacing="4" cellpadding="4">

                      <tr>
                        <td  colspan="4" class="topDotedborder"><div class="genHeadingFont">User
                            Information </div></td>
                      </tr>
                      <tr>
                        <td width="25%" class="genBFont">User Name</td>
                        <td width="40%" class="genFrontFont"><%=userName%></td>
                        <td width="11%" class="genBFont">&nbsp;</td>
                        <td width="24%" class="genFrontFont"></td>
                      </tr>
                      <tr>
                        <td class="genBFont">Name</td>
                        <td class="genFrontFont"><%=employeeName%> </td>
                        <td class="genBFont">Designation</td>
                        <td class="genFrontFont"><%=designation%></td>
                      </tr>
                    </table>
                        <%
                            }
                            }catch (Exception e){}

                        %>

                        <table width="100%" border="0" cellpadding="7" cellspacing="0">
                            <tr>
                                <td class="topDotedborder"><div class="genHeadingFont">Assiging
                                Access Previleges</div></td>
                            </tr>
                            <br>
                            <tr>
                                <td><span class="genBFont">All available previleges</span></td>
                            </tr>
                            <tr>
                                <td><div class="genFont"><span class="genBFont">
                            <select onchange="addToAssignedPrev();" name="available" size="15" multiple="multiple" class="listBox" id="diseaseSet" style="width:550;">
                              <%
                                        try
                                        {

                                            listAllPrev = remote.getAllAvailablePrevileges();
                                            Iterator iteratorAllPrev = listAllPrev.iterator();
                                            while (iteratorAllPrev.hasNext())
                                            {
                                               Preveliges preveliges = new Preveliges();
                                               preveliges = (Preveliges)iteratorAllPrev.next();
                                        %>
                              <option value="<%=preveliges.getInfId()%>"><%=preveliges.getDescription()%></option>
                              <%             }
                                        }
                                        catch (Exception e)
                                        {

                                        }
%>
                            </select>
                            </span> </div></td>
                            </tr>
                            <tr>


                        <td><span class="genBFont">Access previleges assigned
                          to <%=userName%> </span></td>
                            </tr>
                            <tr>
                                <td>

                                    <select  name="assigned" size="10" multiple="multiple" style="width:550;" class="listBox">
                                     <%
                                        try
                                        {

                                            listAssignedPrev = remote.getAssignedPrevileges(userName);
                                            Iterator iteratorAssignedPrev = listAssignedPrev.iterator();
                                            Iterator iteratorAssignedBackup = listAssignedPrev.iterator();
                                            while (iteratorAssignedPrev.hasNext())
                                            {
                                               Preveliges preveliges = new Preveliges();
                                               preveliges = (Preveliges)iteratorAssignedPrev.next();

                                        %>
                                          <option value="<%=preveliges.getInfId()%>"><%=preveliges.getDescription()%></option>
                                          <%             }%></select><br>
                                               <div style="display:none">
                                          <select name="oldA" size="10" style="width:200;" multiple="multiple">
                                              <%while (iteratorAssignedBackup.hasNext())
                                            {
                                               Preveliges preveliges = new Preveliges();
                                               preveliges = (Preveliges)iteratorAssignedBackup.next();

                                        %>
                                          <option value="<%=preveliges.getInfId()%>"><%=preveliges.getDescription()%></option>
                                          <%             }%></select></div>
<%
                                        }
                                        catch (Exception e)
                                        {

                                          }%>

                                </td>
                            </tr>
                            <tr>
                                <td><input type="button" class="btnLargeFormat" onclick="removeSelected();" value="Remove Selected Previlege" />
                                <input type="submit" class="btnFormat" onclick="selectAllAssigned();"  value="Finished" /></td>
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
