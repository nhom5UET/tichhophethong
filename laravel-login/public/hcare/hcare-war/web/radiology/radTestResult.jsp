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
    String radResults=(String)session.getAttribute("radResults");
    if(radResults==null){
        AuthenticationRemote aRemote = new coshms.util.administration.LookupService().lookupAuthenticationBean();
        authorized=aRemote.isAuthorized(userId,"radResults");     
        if (authorized){
            session.setAttribute("radResults","yes");
        }else if(!authorized){
            session.setAttribute("radResults","no");
            response.sendRedirect("login.jsp");
        }
    }else if(radResults.equals("no")){
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
            : Test Results</td>
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
                        <td height="25"   class="topDotedborder"><div class="genHeadingFont">Tets 
                          Results </div>
                        </td>
                    </tr>
                    <tr>
                      <td>
					  
					  <!------------------>
					<form  name = "testDiscount" action="RadTestResult" method="POST" ENCTYPE="multipart/form-data">
    <table width="40%"cellpadding="1" cellspacing="1">
            
             <tr>
               <td class="genFont" align="center">&nbsp;</td>
             </tr>
             <tr>
                <td>
                  <input name="Browse" type="file"  value="Browse"  class="btnFormat" >
                </td>
             </tr>
             <tr>
                <td >
                    <textarea name="notes" rows="4" cols="20">
                    </textarea>
                    <input type="hidden" name="testId" value=<%=request.getParameter("testId")%> />
                    <input type="hidden" name="testReqId" value=<%=request.getParameter("testReqId")%> />
                </td>
             </tr>
             <tr>
               <td>&nbsp;</td>
             </tr>
             <tr>
                <td align="center"><input type="submit" name="submit" value="Submit" class="btnLargeFormat" /></td>
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
