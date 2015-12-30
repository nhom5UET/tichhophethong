<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import = "java.util.*"%>
<%@page import = "coshms.util.pathalogy.*"
import="coshms.ejb.domain.AuthenticationRemote"%>
<%
String searchFor=null;
String interfaceName = "";
searchFor=request.getParameter("searchFor");
System.out.println("SEARCH FOR VALUE IS : = " + searchFor);
if (searchFor != null){
    if(searchFor.equals("Discount")){
        interfaceName = "pthDiscount";       
    }else if(searchFor.equals("Fee")){
        interfaceName = "pthFee";
    }else if(searchFor.equals("sample")){
        interfaceName = "pthSample";
    }else if(searchFor.equals("sampleReject") ){
        interfaceName = "pthSampleReject";
    }else if(searchFor.equals("result") ){
        interfaceName = "pthResults";
    }else if(searchFor.equals("report") ){
        interfaceName = "pthReports";
    }else if(searchFor.equals("TestAudit") ){
        interfaceName = "pthAudit";
    }else if(searchFor.equals("TestAppointment") ){
        interfaceName = "pthTestAppointments";
    }else{
        response.sendRedirect("index.jsp");
    }
}
System.out.println("InterfaceName (grpName) is :: = " + interfaceName);
String authenticated = null;
int userId = 0;
try{
    userId=Integer.parseInt((String)session.getAttribute("userId"));
}catch (Exception e){}

if(userId == 0){
    System.out.println("USER ID NOT IN SESSION , so Redirecting to login.jsp");
    response.sendRedirect("login.jsp"); //?searchFor="+searchFor);
}else if (userId > 0){
    boolean authorized = false;
    AuthenticationRemote aRemote = new coshms.util.administration.LookupService().lookupAuthenticationBean();       
    authorized=aRemote.isAuthorized(userId,interfaceName);
    System.out.println(authorized+"\n\n\n$$$$$$$$$$$$$$$$$$$");
    if (!authorized){System.out.println("NOT AUTHORIZED");
        session.setAttribute(interfaceName,"no");
        response.sendRedirect("login.jsp");
    }else if (authorized){
        session.setAttribute(interfaceName,"yes");
    }
}
%>
   <jsp:useBean id="pthData" scope="page" class="coshms.beans.PthAvailableTestsDataBean" />
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Recomend Test</title>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
		<script language="javascript" src="scripts/pthSearch.js"></script>
    </head>
    <% 

        String option = request.getParameter("searchFor");
    %>
    <body topmargin="0" leftmargin="0" rightmargin="0">
        <form  name = "pSearch" action="PthSearch" onsubmit="return validateForm (pSearch);">
            <table  border="0" cellspacing="0" cellpadding="0">
                <tr> 
                    <td valign="top"><jsp:include page="menue.html" flush="true"/></td>
                    <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                            <td colspan="3" height="3"></td>
                        </tr>
                        <tr> 
                            <td width="8" ><img src="images/left.gif" height="32" /></td>
                            <td width="992" background="images/pixi_bg.gif" class="genArlBFont">Search  For <%=option %></td>
                            <td width="10"><img src="images/right.gif"  height="32" /></td>
                        </tr>
                        <tr> 
            
                            <td colspan="3" height="0"></td>
                        </tr>
                        <tr> 
                            <td colspan="3"> <table class="normalBorderTable" width="100%"  cellspacing="0" cellpadding="0">
                                <tr> 
                                    <td>
                                    <table width="99%" border="0" cellspacing="2" cellpadding="2">
                                        <tr><td height="25"> </td></tr>
                                        <tr> 
                                            <td width="21%"> 
                                                <!------------------>
                                                <%
                                                    String result = "Enter Patient ID";
                                                    if(option.compareTo("result") == 0 || option.compareTo("sampleReject") == 0) {
                                                        result = "Enter Sample ID"; }
                                                %>
                                                <div class="genFont" align="right"><%=result %></div>
                                                <input name="option" type="hidden" value=<%=option %>>
                                                <!-------------------->
                                            </td>
                                            <td width="79%"><input name="pid" type="text" class="inputField" size="10" maxlength="10" /></td>
                                        </tr>
                                        <tr>
                                            <td width="21%">&nbsp;</td>
                                            <td><input type="submit" name="submit" value="Search" class="btnLargeFormat" />
                                                <br />
                                            </td>
                                        </tr>
                                    </table>
                                    </td>
                                </tr>
                            </table></td>
                        </tr>
                    </table></td>
                </tr>
            </table>
        </form>
    </body>
</html>