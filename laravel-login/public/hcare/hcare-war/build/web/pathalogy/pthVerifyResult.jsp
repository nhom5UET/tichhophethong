<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import = "java.util.*"%>
<%@page import = "coshms.util.pathalogy.*"
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
    String pthVerifyResults=(String)session.getAttribute("pthVerifyResults");
    if(pthVerifyResults==null){
        AuthenticationRemote aRemote = new coshms.util.administration.LookupService().lookupAuthenticationBean();
        authorized=aRemote.isAuthorized(userId,"pthVerifyResults");
         System.out.println(authorized + "\n\n\n");
        if (authorized){
            session.setAttribute("pthVerifyResults","yes");
        }else if(!authorized){
            session.setAttribute("pthVerifyResults","no");
            response.sendRedirect("login.jsp");
        }
    }else if(pthVerifyResults.equals("no")){
        response.sendRedirect("login.jsp");
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
            
          <td width="992" background="images/pixi_bg.gif" class="genArlBFont">Pathology 
            : Test Result</td>
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
                        <div class="genHeadingFont">Test Result Verification</div></td>
                    </tr>
                    <tr>
                      <td>
					  
					  <!------------------>
					<form method="POST">
        
        <table cellpadding="7" cellspacing="0" width="100%">

                <tr bgcolor="#EFEFEF"> 
                    <td width="478" class="genBFont">Test Name</td>
                    <td class="genBFont"  width="481">Verify</td>
                </tr>


    <% 
    PthTestVerifyInfo pthTests;
    ArrayList pthTestsList = null;
    Iterator pthTestsIt = null;
    try {
        
        pthTestsList = pthData.getPthResultVerify();
        pthTestsIt = pthTestsList.iterator();
      
      String testId1 = "";
      String testReqId1= "";
      
        while(pthTestsIt.hasNext()){
        pthTests = (PthTestVerifyInfo)pthTestsIt.next(); 
        testId1 = Integer.valueOf(pthTests.getTestId()).toString();
        testReqId1 = Integer.valueOf(pthTests.getTestReqId()).toString();
 %>                            
                
                    <tr>
                   <td class="topborder" ><div class="genFont"><%=pthTests.getTestName() %> </div></td>
                    <td class="topborder">
					<div class="genFont">
                        <a href="pthTestConResult.jsp?testId=<%=testId1 %>&testReqId=<%=testReqId1 %>&testName=<%=pthTests.getTestName() %>">Click Here</a>
						</div>
                    </td>
                </tr>

            <%   
       }
    }catch(Exception ex)
            { %>
    
<%    }
            %>       
            </tbody>
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
