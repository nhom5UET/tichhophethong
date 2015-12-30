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
    String pthFee=(String)session.getAttribute("pthFee");
    if(pthFee==null){
        AuthenticationRemote aRemote = new coshms.util.administration.LookupService().lookupAuthenticationBean();
        authorized=aRemote.isAuthorized(userId,"pthFee");     
        if (authorized){
            session.setAttribute("pthFee","yes");
        }else if(!authorized){
            session.setAttribute("pthFee","no");
            response.sendRedirect("login.jsp");
        }
    }else if(pthFee.equals("no")){
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
     <title>Test Payment</title>
     <link href="images/styles.css" rel="stylesheet" type="text/css" />
	 <script language="javascript" src="scripts/pthTestPayment.js"></script>
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
            : Test Payment</td>
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
					     <form action="PthTestPaymentAdd" method="POST" onsubmit=" return validateForm (testPay);" name="testPay">
        <div align="left"> 
                          
                          </div>
                          <table width="100%"  cellpadding="5" cellspacing="0">
                            <tr> 
                              <td height="15" colspan="6" class="genBFont"> <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                  <tr> 
                                    <td colspan="5" class="topDotedborder" ><div class="genHeadingFont">Patient 
                                        Basic Information</div></td>
                                  </tr>
                                  <tr> 
                                    <td width="31%" class="genBFont">Name</td>
                                    <td width="21%" class="genFont"><%=pt.getFirstName()%> 
                                      <%=pt.getLastName()%></td>
                                    <td width="5%" class="genBFont">Pid</td>
                                    <td width="17%" class="genFont"><%=pt.getPid()%></td>
                                    <td width="26%" rowspan="6"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                        <tr> 
                                          <td><img width="100" border="1" height="120" src="
<%if(pt.isPicExist()){
    out.write("../images/"+pt.getPid()+".jpg");
}else{
    out.write("../images/na.jpg");
}%>"/></td>
                                        </tr>
                                      </table></td>
                                  </tr>
                                  <tr> 
                                    <td class="genBFont">Father/Husband Name</td>
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
                              <td colspan="6" class="topDotedborder" ><div class="genHeadingFont">Pending 
                                  Tests to be Paid</div></td>
                            </tr>
                            <tr bgcolor="#EFEFEF"> 
                              <td width="103" height="15" class="genBFont">Test 
                                Name</td>
                              <td   width="90"><div class="genBFont" >Request 
                                  Date</div></td>
                              <td   width="95"><div class="genBFont" >Cost</div></td>
                              <td  width="60"><div class="genBFont" >Discount</div></td>
                              <td   width="60"><div class="genBFont" >Charge</div></td>
                              <td  width="60"><div class="genBFont" >Status</div></td>
                            </tr>
                            <% 
    PthTestDisInfo pthTests;
    ArrayList pthTestsList = null;
    Iterator pthTestsIt = null;
    try {
        int ptId = Integer.parseInt(request.getParameter("pid"));
        pthTestsList = pthData.getPthTestsPayement(ptId);
        pthTestsIt = pthTestsList.iterator();
        int charge = 0;
    
        String CbValue = "";
    
    
       while(pthTestsIt.hasNext()){
           pthTests = (PthTestDisInfo)pthTestsIt.next(); 
           charge = pthTests.getTestCost() - (pthTests.getTestCost() * pthTests.getDiscount()/100);
          CbValue = Integer.valueOf(pthTests.getTestId()).toString() + "a" + Integer.valueOf(pthTests.getTestReqId()).toString() + "z";
    
    %>
                            <tr> 
                              <td class="topborder" ><div class="genFont"> 
                                  <input type="hidden" name="testReqId" value="<%= pthTests.getTestReqId() %>"/>
                                  <input type="hidden" name="testId" value="<%= pthTests.getTestId() %>"/>
                                  <%=pthTests.getTestname() %> </div></td>
                              <td class="topborder" ><div class="genFont"><%=pthTests.getDDate() %></div></td>
                              <td class="topborder"><div class="genFont"><%=pthTests.getTestCost() %></div></td>
                              <td  class="topborder"><div class="genFont"><%=pthTests.getDiscount() %>%</div></td>
                              <td class="topborder"><div class="genFont"> <%=charge %></div></td>
                              <td class="topborder"><input type="checkbox" name="payStatusCB" value="<%=CbValue %>" /></td>
                            </tr>
                            <%   
       }
    }catch(Exception ex)
            { %>
                            <%=ex.getMessage()%> 
                            <%    }
            %>
                            <tr> 
                              <td colspan="6"> <div align="center"> 
                                  <input  type="reset" value="Reset" class="btnFormat"/>&nbsp;
                                  <input type="submit" value="Done" class="btnFormat"/>
                                  
                                </div></td>
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
