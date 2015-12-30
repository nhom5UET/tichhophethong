<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import = "java.util.*"%>
<%@page import = "coshms.util.pathalogy.*"
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


<%
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
    <td valign="top"><jsp:include page="menue.html" flush="true"/></td>
    <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
            <td colspan="3" height="3"></td>
        </tr>
        <tr> 
            <td width="8" ><img src="images/left.gif" height="32" /></td>
            
          <td width="992" background="images/pixi_bg.gif" class="genArlBFont">Pathology 
            : Test Sample</td>
            <td width="10"><img src="images/right.gif"  height="32" /></td>
        </tr>
        <tr> 
            <td colspan="3" height="3"></td>
        </tr>
        <tr> 
          <td colspan="3"> <table class="normalBorderTable" width="100%"  cellspacing="0" cellpadding="0">
              <tr> 
			  <td>
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
                    
                    <tr>
                      <td> 
                        <!------------------>
                        <form action="PthTestSampleAdd" method="POST">
                        
        
                          <table width="100%"  cellpadding="5"  cellspacing="0">
                            <tr> 
                              <td colspan="3" class="genBFont"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                  <tr> 
                                    <td height="23" colspan="5" class="topDotedborder"><div class="genHeadingFont">Patient 
                                        Basic Information</div></td>
                                  </tr>
                                  <tr> 
                                    <td width="18%" class="genBFont">Name</td>
                                    <td width="32%" class="genFont"><%=pt.getFirstName()%> 
                                      <%=pt.getLastName()%></td>
                                    <td width="6%" class="genBFont">Pid</td>
                                    <td width="15%" class="genFont"><%=pt.getPid()%></td>
                                    <td width="29%" rowspan="6"><table width="100%" border="0" cellspacing="0" cellpadding="2">
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
                                    <td class="genBFont">Father Name</td>
                                    <td class="genFont"><%=pt.getFatherName()%></td>
                                    <td class="genBFont">Age</td>
                                    <td class="genFont"><%=pt.getAge()%> Yr(s)</td>
                                  </tr>
                                  <tr> 
                                    <td class="genBFont">Address</td>
                                    <td class="genFont"><%=pt.getStreetAddress()%></td>
                                    <td class="genBFont">Gender</td>
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
                                </table></td>
                            </tr>
                            <tr >
                              <td colspan="3" class="topDotedborder"><div class="genHeadingFont">Take 
                                  Samples Here</div></td>
                            </tr>
                            <tr bgcolor="#EFEFEF"> 
                              <td width="269" class="genBFont">Test Name</td>
                              <td width="256" class="genBFont"> Request Date</td>
                              <td width="318" class="genBFont">Take Sample</td>
                            </tr>
                            <% 
    PthTestSampleInfo pthTests;
    ArrayList pthTestsList = null;
    Iterator pthTestsIt = null;
    try {
        int ptId = Integer.parseInt(request.getParameter("pid"));
        pthTestsList = pthData.getPthTestsSample(ptId);
        pthTestsIt = pthTestsList.iterator();
      
    String testReqId = "";
    String testId = "";
       while(pthTestsIt.hasNext()){
           pthTests = (PthTestSampleInfo)pthTestsIt.next(); 
           testReqId = Integer.valueOf(pthTests.getTestReqId()).toString();
           testId = Integer.valueOf(pthTests.getTestId()).toString();
    %>
                            <tr> 
                              <td   class="topborder"> <div class="genFont"><%=pthTests.getTName() %> 
                                </div></td>
                              <td class="topborder"><div    class="genFont"><%=pthTests.getTestReqDate() %></div></td>
                              <td  class="topborder"><div   class="genFont"> <a href="PthTestSampleAdd?tRId=<%=testReqId %>&tId=<%=testId %>">Take 
                                  Sample</a></div></td>
                            </tr>
                            <%   
       }
    }catch(Exception ex)
            { %>
                            <%=ex.getMessage()%> 
                            <%    }
            %>
                            <tr> 
                              <td> 
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
