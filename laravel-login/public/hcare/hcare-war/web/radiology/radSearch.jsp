<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import = "java.util.*"%>
<%@page import = "coshms.util.radiology.*"
import="coshms.ejb.domain.AuthenticationRemote"%>
<%
String searchFor=null;
String interfaceName = "";
searchFor=request.getParameter("searchFor");
System.out.println("SEARCH FOR VALUE IS : = "+searchFor);
if (searchFor != null){
    if(searchFor.equals("Discount")){
        interfaceName = "radDiscount";       
    }else if(searchFor.equals("Fee")){
        interfaceName = "radFee";
    }else if(searchFor.equals("result") ){
        interfaceName = "radResults";
    }else if(searchFor.equals("report") ){
        interfaceName = "radReports";
    }else if(searchFor.equals("TestAudit") ){
        interfaceName = "radAudit";
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
}else if(userId > 0){
    boolean authorized = false;
    AuthenticationRemote aRemote = new coshms.util.administration.LookupService().lookupAuthenticationBean();       
    authorized=aRemote.isAuthorized(userId,interfaceName);
    System.out.println(authorized+"\n\n\n$$$$$$$$$$$$$$$$$$$");
    
    if (!authorized){
        System.out.println("NOT AUTHORIZED");
        session.setAttribute(interfaceName,"no");
        response.sendRedirect("login.jsp");
    }else if (authorized){
        session.setAttribute(interfaceName,"yes");
    }
}
%>
   <jsp:useBean id="pthData" scope="page" class="coshms.beans.PthAvailableTestsDataBean" />
   <?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
     <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
     <title>Recomend Test</title>
     <link href="../pathalogy/images/styles.css" rel="stylesheet" type="text/css" />
	 <script  type="text/javascript" language="javascript" src="../pathalogy/images/dynamic_TestContent.js"></script>
	 <script language="javascript" src="../pathalogy/scripts/pthSearch.js"></script>
 </head>
     <% 

String option = request.getParameter("searchFor");
%>
    <body topmargin="0" leftmargin="0" rightmargin="0">
<table  border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td valign="top"><jsp:include page="menue.html" flush="true"/></td>
    <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
            <td colspan="3" height="3"></td>
        </tr>
        <tr> 
            <td width="8" ><img src="../pathalogy/images/left.gif" height="32" /></td>
            
          <td width="992" background="../pathalogy/images/pixi_bg.gif" class="genArlBFont">Radiology 
            : Search For <%=option %></td>
            <td width="10"><img src="../pathalogy/images/right.gif"  height="32" /></td>
        </tr>
        <tr> 
            <td colspan="3" height="3"></td>
        </tr>
        <tr> 
          <td colspan="3"> <table class="normalBorderTable" width="100%"  cellspacing="0" cellpadding="0">
              <tr> 
			  <td>
		<table width="99%" border="0" cellspacing="2" cellpadding="2">
                    <tr> 
                        <td height="25" >
                        </td>
                    </tr>
                    <tr>
                      <td>
					  
					  <!------------------>
					
    
  <form  action="RadSearch"  name = "pSearch" onsubmit="return validateForm (pSearch);">
    <table width="40%" cellpadding="1" cellspacing="1">
            
             <tr>
             <%
                String result = "Enter Patient ID";
                if(option.compareTo("result") == 0 || option.compareTo("sampleReject") == 0) {
                    result = "Enter Patient ID"; }
            %>
                              <td class="genFont" align="center"><%=result %> 
                                <input name="pid" type="text" class="inputField" /></td>
               <input name="option" type="hidden" value=<%=option %>>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
                <td align="center"><input type="submit" name="submit" value="Search" class="btnLargeFormat" /></td>
            </tr>
             </table>        
  </form>
					  <!---------------------------------->
					  
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
</body>
</html>
