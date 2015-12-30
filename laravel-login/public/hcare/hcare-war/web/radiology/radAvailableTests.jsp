<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import = "java.util.*"%>
<%@page import = "coshms.util.radiology.*"
import="coshms.ejb.domain.AuthenticationRemote"%>
<%
int userId = 0;
boolean authorized = false;
try{
    userId=Integer.parseInt((String)session.getAttribute("login"));
}catch(Exception e){}
if(userId == 0){
    response.sendRedirect("login.jsp");
}else if (userId>0){
    String radTestRequest=(String)session.getAttribute("radTestRequest");
    if(radTestRequest==null){
        AuthenticationRemote aRemote = new coshms.util.administration.LookupService().lookupAuthenticationBean();
        authorized=aRemote.isAuthorized(userId,"radTestRequest");
        if (authorized){
            session.setAttribute("radTestRequest","yes");
        }else if(!authorized){
            session.setAttribute("radTestRequest","no");
            response.sendRedirect("login.jsp");
        }
    }else if(radTestRequest.equals("no")){
        response.sendRedirect("login.jsp");
    }
}
%>

<jsp:useBean id="radData" scope="page" class="coshms.beans.RadAvailableTestsDataBean"/>
<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
     <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
     <title>Recomend Test</title>
     <link href="../pathalogy/images/styles.css" rel="stylesheet" type="text/css" />
	 <script  type="text/javascript" language="javascript" src="../pathalogy/images/dynamic_TestContent.js"></script>
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
            <td width="8" ><img src="../pathalogy/images/left.gif" height="32" /></td>
            
          <td width="992" background="../pathalogy/images/pixi_bg.gif" class="genArlBFont">Radiology 
            : Available Test</td>
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
                        <td height="25" class="topDotedborder">
                        <div class="genHeadingFont">Recomend test</div></td>
                    </tr>
                    <tr>
                      <td>
					  
					  <!------------------>
					       <form action="RadTestReq" method="POST">
        
                <table border="0" cellspacing="0" cellpadding="5">

                            <tr>
                                <td width="400" class="genBFont">Test Name</td>
                                <td width="90" class="genBFont">RECOMMEND</td>
                                <td width="100" class="genBFont">URGENT BASIS</td>
                            </tr>
                            
    <% 
        
    RadAvlTestsInfo radTests;
       ArrayList radTestsList = radData.getRadAvailableTests();
       Iterator radTestsIt = radTestsList.iterator();
       String testId = "";
       while(radTestsIt.hasNext()){
           radTests = (RadAvlTestsInfo)radTestsIt.next();
           testId = Integer.valueOf(radTests.getTestId()).toString();
           
    %>                        
                            <tr>
                                <td class="topborder"><div class="genFont"><%= radTests.getName() %></div></td>
                                <td class="topborder"> <input type="checkbox" name="testCB" value= "<%=testId  %>" /></td>
                                <td class="topborder"> <input type="checkbox" name="testUBCB" value= "<%=testId %>" /></td>
                            </tr>
                            <%    }     %>                        
                     

                    </table>

                         <div align="center"><input type="submit" value="Request" name="testRequest" class="btnFormat" /></div>



                         <input type="hidden" name="pid" value="<%=request.getParameter("pid")%>"/>
                         <input type="hidden" name="emgEncNo" value="<%=request.getParameter("emgEncNo")%>"/>
                         
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
