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
    String pthDiscount=(String)session.getAttribute("pthDiscount");
    if(pthDiscount==null){
        AuthenticationRemote aRemote = new coshms.util.administration.LookupService().lookupAuthenticationBean();
        authorized=aRemote.isAuthorized(userId,"pthDiscount");     
        if (authorized){
            session.setAttribute("pthDiscount","yes");
        }else if(!authorized){
            session.setAttribute("pthDiscount","no");
            response.sendRedirect("login.jsp");
        }
    }else if(pthDiscount.equals("no")){
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
   <jsp:useBean id="pthData" scope="page" class="coshms.beans.PthAvailableTestsDataBean"/>
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
            : Test Discount</td>
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
                      <td>
<form action="PthTestDisAdd" method="POST">
            
                         
                          <table width="100%" cellpadding="5" cellspacing="0">
                            <tr> 
                              <td colspan="4" class="genBFont"> <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                  <tr> 
                                    <td  class="topDotedborder" colspan="5"><div class="genHeadingFont">Patient 
                                        Basic Information</div></td>
                                  </tr>
                                  <tr> 
                                    <td width="19%" class="genBFont">Name</td>
                                    <td width="33%" class="genFont"><%=pt.getFirstName()%> 
                                      <%=pt.getLastName()%></td>
                                    <td width="5%" class="genBFont">Pid</td>
                                    <td width="17%" class="genFont"><%=pt.getPid()%></td>
                                    <td width="26%" rowspan="6"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                        <tr> 
                                          <td><img width="100" height="120"  border="1" src="
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
                            <tr> 
                              <td height="50" colspan="4" class="topDotedborder" >
<div class="genHeadingFont">
                                  Requests for Discount</div></td>
                            </tr>
                            <tr bgcolor="#EFEFEF"> 
                              <td class="genBFont">Test Name</td>
                              <td width="90" colspan="-1" class="genBFont">Request 
                                Date</td>
                              <td width="25" class="genBFont">Cost</td>
                              <td width="50" class="genBFont">Discount</td>
                            </tr>
                            <% 
 try {
    PthTestDisInfo pthTests;
    ArrayList pthTestsList = null;
    Iterator pthTestsIt = null;
   
        int ptId = Integer.parseInt(request.getParameter("pid"));
        pthTestsList = pthData.getPthTestsDis(ptId);
        pthTestsIt = pthTestsList.iterator();
    
       while(pthTestsIt.hasNext()){
           pthTests = (PthTestDisInfo)pthTestsIt.next(); 
    
    %>
                            <tr> 
                              <td class="topborder"> <div  class="genFont"> 
                                  <input type="hidden" name="testReqId" value="<%= pthTests.getTestReqId() %>"/>
                                  <input type="hidden" name="testId" value="<%= pthTests.getTestId() %>"/>
                                  <%=pthTests.getTestname() %> </div></td>
                              <td colspan="-1" class="topborder"><div  class="genFont"><%=pthTests.getDDate() %></div></td>
                              <td class="topborder"><div  class="genFont"><%=pthTests.getTestCost() %></div></td>
                              <td class="topborder"><select name="select" class="menuFormat">
                                  <option value="0">0%</option>
                                  <option value="5">5%</option>
                                  <option value="10">10%</option>
                                  <option value="20">20%</option>
                                  <option value="25">25%</option>
                                  <option value="30">30%</option>
                                  <option value="40">40%</option>
                                  <option value="50">50%</option>
                                  <option value="75">75%</option>
                                  <option value="100">100%</option>
                                </select> </td>
                            </tr>
                            <%   
       }
    }catch(Exception ex)
            { %>
                            <%    
    response.sendRedirect("pthMessage.jsp?message=Invalid Patient ID");
    }
            %>
                            <tr> 
                              <td colspan="4" align="center"><input type="reset" value="Reset" class="btnFormat"/> 
                                <input type="submit" value="Done"  class="btnFormat"/> 
                                <input name="submit" type="Reset"  class="btnFormat" value="Cancel"/> 
                                <br /> </td>
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
<%}%>
