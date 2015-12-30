<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import = "java.util.*"%>
<%@page import = "coshms.util.radiology.*"
import="coshms.ejb.domain.RegisterPatientRemote"
import="coshms.util.EJBAccessPoint"
import="coshms.util.PatientNotFoundException"
import="coshms.util.domain.Patient"
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
%><%
Integer pid=new Integer(request.getParameter("pid"));
EJBAccessPoint ejbAP = new EJBAccessPoint();
RegisterPatientRemote regPt = ejbAP.lookupRegisterPatientBean();
Patient pt=null;

    pt= regPt.getPatient(pid);    
    if(pt==null){
         RequestDispatcher dispatcher = null;
         dispatcher = request.getRequestDispatcher("InfoPth.jsp?msg=Patient not Registered");
         dispatcher.forward(request,response);
     }   
    else{
    if(pt.isPicExist()){
        byte by2[] = new byte[pt.getPicSize()];
        by2 = pt.getPicByte();
        String name = "/images/"+pt.getPid()+".jpg";
        java.io.RandomAccessFile f1 = new java.io.RandomAccessFile(getServletContext().getRealPath(name),"rw");
        f1.write(by2);
        f1.close();
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
                        <td height="25"   class="topDotedborder"><div class="genHeadingFont">Submit 
                          Results </div>
                        </td>
                    </tr>
                    <tr>
                      <td>
					  
					  <!------------------>
					
    
    <form action="PthTestSampleAdd" method="POST">
        
                          <table width="90%"  cellpadding="5" cellspacing="0">
                            <tr> 
                              <td colspan="3" class="genBFont"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                  <tr> 
                                    <td height="23" colspan="5">Patient Basic 
                                      Info:</td>
                                  </tr>
                                  <tr> 
                                    <td width="19%">&nbsp;</td>
                                    <td width="33%">&nbsp;</td>
                                    <td width="11%">&nbsp;</td>
                                    <td width="11%">&nbsp;</td>
                                    <td width="26%">&nbsp;</td>
                                  </tr>
                                  <tr> 
                                    <td class="genBFont">Name:</td>
                                    <td class="genFont"><%=pt.getFirstName()%> <%=pt.getLastName()%></td>
                                    <td class="genBFont">Pid:</td>
                                    <td class="genFont"><%=pt.getPid()%></td>
                                    <td rowspan="6"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                        <tr>
<td><img width="100" height="120" src="
<%if(pt.isPicExist()){
    out.write("../images/"+pt.getPid()+".jpg");
}else{
    out.write("../images/na.jpg");
}%>"/></td>
                                        </tr>
                                      </table></td>
                                  </tr>
                                  <tr> 
                                    <td class="genBFont">Father Name:</td>
                                    <td class="genFont"><%=pt.getFatherName()%></td>
                                    <td class="genBFont">Age:</td>
                                    <td class="genFont"><%=pt.getAge()%> Yr(s)</td>
                                  </tr>
                                  <tr> 
                                    <td class="genBFont">Address:</td>
                                    <td class="genFont"><%=pt.getStreetAddress()%></td>
                                    <td class="genBFont">Gender:</td>
                                    <td class="genFont"><%=pt.getGender()%></td>
                                  </tr>
                                  <tr> 
                                    <td class="genBFont">&nbsp;</td>
                                    <td class="genFont"><%=pt.getTown()%>,<%=pt.getCity()%></td>
                                    <td class="genBFont">&nbsp;</td>
                                    <td class="genFont">&nbsp;</td>
                                  </tr>
                                  <tr> 
                                    <td class="genBFont">CNIC</td>
                                    <td class="genFont"><%if(pt.getCnic()==null)out.println("N/A");else out.println(pt.getCnic());%></td>
                                    <td class="genBFont">&nbsp;</td>
                                    <td class="genFont">&nbsp;</td>
                                  </tr>
                                  <tr> 
                                    <td class="genBFont">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="genBFont">&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>
                                </table></tr>
                            <tr> 
                              <td width="156" class="genBFont">Test Name</th> 
                              <td class="genBFont" width="90">Request Date</th> 
                              <td class="genBFont" width="100">Submit</th> </tr>
                            <% 
    RadTestResultInfo radTests;
    ArrayList radTestsList = null;
    Iterator radTestsIt = null;
    try {
        int ptId = Integer.parseInt(request.getParameter("pid"));
        radTestsList = radData.getRadTestResultInfo(ptId);
        radTestsIt = radTestsList.iterator();
      
    String testReqId = "";
    String testId = "";
       while(radTestsIt.hasNext()){
           radTests = (RadTestResultInfo)radTestsIt.next(); 
           testReqId = Integer.valueOf(radTests.getTestReqId()).toString();
           testId = Integer.valueOf(radTests.getTestId()).toString();
    %>
                            <tr> 
                              <td class="topborder"><div class="genFont"><%=radTests.getTestName() %> 
                                </div></td>
                              <td class="topborder"><div class="genFont"><%=radTests.getReqDate() %></div></td>
                              <td class="topborder"> <div class="genFont"> <a href="radTestResult.jsp?testReqId=<%=testReqId %>&testId=<%=testId %>"> 
                                  Result</a> </div></td>
                            </tr>
                            <%   
       }
    }catch(Exception ex)
            { %>
                            <%=ex.getMessage()%> 
                            <%    }
            %>
                            <tr> 
                              <td></tbody> 
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
<%}%>
