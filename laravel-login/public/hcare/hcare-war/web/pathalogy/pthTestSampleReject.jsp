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
        String pthSample=(String)session.getAttribute("pthSample");
        if(pthSample==null){
            AuthenticationRemote aRemote = new coshms.util.administration.LookupService().lookupAuthenticationBean();
            authorized=aRemote.isAuthorized(userId,"pthSample");
            if (authorized){
                session.setAttribute("pthSample","yes");
            }else if(!authorized){
                session.setAttribute("pthSample","no");
                response.sendRedirect("login.jsp");
            }
        }else if(pthSample.equals("no")){
            response.sendRedirect("login.jsp");
        }
    }
%>

   <jsp:useBean id="pthData" scope="page" class="coshms.beans.PthAvailableTestsDataBean" />
   
     <% 
         PthTestSampleInfo pthTests;
         ArrayList pthTestsList = null;
         Iterator pthTestsIt = null;
         try {
             int sId = Integer.parseInt(request.getParameter("sid"));
             pthTestsList = pthData.getPthTestsSampleReject(sId);
    //            response.sendRedirect("pthMessage.jsp?message=Invalid sample ID entered or Sample already rejected");
             pthTestsIt = pthTestsList.iterator();
     %>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Sample Rejectiont</title>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
        <script language="javascript" src="scripts/pthTestSampleReject.js"></script>
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
                : Sample Rejection</td>
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
                            <td height="25">
                            <div class="genHeadingFont">Sample Rejection</div></td>
                        </tr>
                        <tr>
                            <td>
					  
                                <!------------------>
                                <form action="PthTestSampleRejAdd" method="POST" onsubmit="return validateForm (sReject)" name="sReject">
                                    <table>
                                    <tr> 
                                        <table  cellpadding="5">

                                        <tr>
                                            <td  width="90" class="genBFont">Test Name</td>
                                            <td class="genBFont">Request Date</td>
                                            <td class="genBFont">Reject Description</td>
                                        </tr>

  
                                        <input type="hidden" name="sid" value=<%=request.getParameter("sid")%> />
                                        <%   

                                            while(pthTestsIt.hasNext()){
                pthTests = (PthTestSampleInfo)pthTestsIt.next();

                                        %>                            
                
                    
                                        <td class="genFont"><%=pthTests.getTName() %> </td>
                                        <td class="genFont"><%=pthTests.getTestReqDate() %></td>
                                        <td  > <textarea name="description" rows="4" cols="35" class="textArea">
                                        </textarea></td>
                                    </tr>
             
         
                                        <%   
                                                }
        }catch(Exception ex) {
            %>
                                        <%=ex.getMessage()%>    
                                        <%    }
                                        %>     
                                        <tr><td colspan="3" align="center">
                                            <input type="reset" value="Reset" class="btnFormat"/>&nbsp;
                                            <input type="submit" value="Reject" class="btnFormat"/>&nbsp;
                                  
                                        </td></tr>  

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
