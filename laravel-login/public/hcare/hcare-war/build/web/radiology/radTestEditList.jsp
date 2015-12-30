<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import = "java.util.*"%>
<%@page import = "coshms.util.radiology.*"
import="coshms.ejb.domain.AuthenticationRemote"%>
<%
int userId = 0;
boolean authorized = false;
try{
    userId=Integer.parseInt((String)session.getAttribute("userId"));
}catch(Exception e){}

if(userId == 0){
    response.sendRedirect("login.jsp");
}else if (userId>0){
    String radAddAndEditTest=(String)session.getAttribute("radAddAndEditTest");
    if(radAddAndEditTest==null){
        AuthenticationRemote aRemote = new coshms.util.administration.LookupService().lookupAuthenticationBean();
        authorized=aRemote.isAuthorized(userId,"radAddAndEditTest");
        if (authorized){
            session.setAttribute("radAddAndEditTest","yes");
        }else if(!authorized){
            session.setAttribute("radAddAndEditTest","no");
            response.sendRedirect("login.jsp");
        }
    }else if(radAddAndEditTest.equals("no")){
        response.sendRedirect("login.jsp");
    }
}
%>




    <jsp:useBean id="radData" scope="page" class="coshms.beans.RadAvailableTestsDataBean" />
   <?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
     <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
     <title>Recomend Test</title>
     <link href="images/styles.css" rel="stylesheet" type="text/css" />
	 <script  type="text/javascript" language="javascript" src="images/dynamic_TestContent.js"></script>
 </head>

    <body topmargin="0" leftmargin="0" rightmargin="0">
<table  border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td valign="top"><jsp:include page="menue.html" flush="true"/></td>
    <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
            <td colspan="3" height="3"></td>
        </tr>
        <tr> 
            <td width="8" ><img src="images/left.gif" height="32" /></td>
            
          <td width="992" background="images/pixi_bg.gif" class="genArlBFont">Radiology 
            : Available Test</td>
            <td width="10"><img src="images/right.gif"  height="32" /></td>
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
                        <td height="25" class="topDotedborder">
                        <div class="genHeadingFont">Edit the test information</div></td>
                    </tr>
                    <tr>
                      <td>
					  
					  <!------------------>
					     <form  method="POST">
        
        <table border="0" cellspacing="0" cellpadding="5">
                            <tr>
                                <td width="400" class="genBFont"> Test Name</td>
                                <td class="genBFont">Edit</td>
                            </tr>
                            
    <% 
        
    RadAvlTestsInfo radTests;
       ArrayList radTestsList = radData.getRadTestAll();
       Iterator radTestsIt = radTestsList.iterator();
       String testId = "";
       while(radTestsIt.hasNext()){
           radTests = (RadAvlTestsInfo)radTestsIt.next();
           testId = Integer.valueOf(radTests.getTestId()).toString();
           
    %>                        
                            <tr>
                                <td class="topborder"><div class="genFont"><%= radTests.getName() %></div></td>
                                <td  class="topborder"><div class="genFont"><a href="radTestDomainEdit.jsp?testId=<%=testId %>">This One</a></div></td>
                            </tr>
                            <%    }     %>                        
                     
                    
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
