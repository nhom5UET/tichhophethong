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



    <jsp:useBean id="radData" scope="page" class="coshms.beans.RadAvailableTestsDataBean"/>
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
                        <div class="genHeadingFont">Edit Test</div></td>
                    </tr>
                    <tr>
                      <td>
					  
					  <!------------------>
	<form method="POST"   action="RadTestDomainEdit" onSubmit="return validateForm(newTest)" id="newTest">  
           <table width="70%" cellpadding="5" cellspacing="1" >
             
              <tr>
                <td width="13%">&nbsp;</td>
                <td width="58%">&nbsp;</td>
                <td width="5%">&nbsp;</td>
                <td width="8%">&nbsp;</td>
                <td width="16%">&nbsp;</td>
              </tr>
              
<% 
    RadAvlTestsInfo radTests;
    ArrayList radTestsList = null;
    Iterator radTestsIt = null;
        
        int tId = Integer.parseInt(request.getParameter("testId"));
        radTestsList = radData.getRadTestInfo(tId);
        radTestsIt = radTestsList.iterator();
        radTests = (RadAvlTestsInfo)radTestsIt.next();
%>
                <input type="hidden" name="testId" value="<%=request.getParameter("testId")%>" />
                <tr>
                <td  class="genFont">Test Name</td>
                <td><input name="tname" type="text" class="inputField" size="43" value="<%=radTests.getName()%>" /></td>
                <td><span class="genFont">Cost</span></td>
                <td><input name="tcost" type="text" class="inputField"  maxlength="5" size="6" value="<%=Integer.valueOf(radTests.getCost()).toString()%>"/></td>
           <% 
               if(radTests.isStatus())
               {
            %>
                <td><input type="checkbox" name="status"  checked/>
                    <span class="genFont">Available</span></td>
              <% 
               }else
               {
            %>
                <td><input type="checkbox" name="status" />
                    <span class="genFont">Available</span></td>
              <% } %>  
                </tr>
             <tr>
             <td>
		<div align="center"> </div>
                <td>
		<div align="center">
                        <input name="button" type="submit" class="btnFormat"  value="Update" />
                                  <input name="Clear" type="reset" class="btnFormat"   value="Clear"/>
                                </div>
		</td>
              </tr>
              <tr>
               
                <td colspan="5"> </td>
              </tr>
            </table></form>
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
