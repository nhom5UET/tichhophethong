<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import = "java.util.*"%>
<%@page import = "coshms.util.pathalogy.*"
import="coshms.ejb.domain.AuthenticationRemote"%>

<%
int userId = 0;
boolean authorized = false;
try{
    userId=Integer.parseInt((String)session.getAttribute("login")); //login: becos request comes from treatment interface
}catch(Exception e){}


        AuthenticationRemote aRemote = new coshms.util.administration.LookupService().lookupAuthenticationBean();
        authorized=aRemote.isAuthorized(userId,"pthTestRequest");     
        if (authorized){
            session.setAttribute("pthTestRequest","yes");
        }else if(!authorized){
            session.setAttribute("pthTestRequest","no");
            response.sendRedirect("login.jsp");
        }
 
%>
 <jsp:useBean id="pthData" scope="page" class="coshms.beans.PthAvailableTestsDataBean" />
   <?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
     <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
     <title>Recomend Test</title>
     <link href="images/styles.css" rel="stylesheet" type="text/css" />
	
 </head>

    <body topmargin="0" leftmargin="0" rightmargin="0">
<table  border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td valign="top"></td>
    <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
            <td colspan="3" height="3"></td>
        </tr>
        <tr> 
            <td width="8" ><img src="images/left.gif" height="32" /></td>
            
          <td width="992" background="images/pixi_bg.gif" class="genArlBFont">Pathology 
            : Recomend Test</td>
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
                        <div class="genHeadingFont">Currently 
                        available Pathology Tests</div></td>
                    </tr>
                    <tr>
                      <td>
					  
					  <!------------------>
					   <form action="PthTestReq" method="POST" onsubmit="return validateForm (availableTest)" name="availableTest">
<table border="0" cellspacing="0" cellpadding="5">

                            <tr>
                                <td  class="genBFont" width="400">Test Name</td>
                                <td class="genBFont" width="90">Recomend</td>
                                <td class="genBFont" width="80">Urgent Basis</td>
                            </tr>


                            
    <% 
       int pid = Integer.parseInt(request.getParameter("pid"));
       int emgEncNo =Integer.parseInt(request.getParameter("emgEncNo"));
        
       PthAvlTestsInfo pthTests;
       ArrayList pthTestsList = pthData.getPthAvailableTests();
       Iterator pthTestsIt = pthTestsList.iterator();
       String testId = "";
       while(pthTestsIt.hasNext()){
           pthTests = (PthAvlTestsInfo)pthTestsIt.next();
           testId = Integer.valueOf(pthTests.getTestId()).toString();
           
    %>                        
                            <tr>
                                <td class="topborder"><div class="genFont"><%= pthTests.getName() %></div></td>
                                <td class="topborder"><div class="genFont"> <input type="checkbox" name="testCB" value= "<%=testId  %>" /></div></td>
                                <td class="topborder"><div class="genFont"><input type="checkbox" name="testUBCB" value= "<%=testId %>" /></div> </td>
                            </tr>
                            <%    }     %>                        
                     

<tr><td colspan="3">
                         <div align="center"><input type="submit" value="Request" name="testRequest" class="btnFormat" /></div>
        </td></table>
        <input type="hidden" name="pid" value="<%=pid%>"/>
        <input type="hidden" name="emgEncNo" value="<%=emgEncNo%>"/>        
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
