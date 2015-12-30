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
    String pthResults=(String)session.getAttribute("pthResults");
    if(pthResults==null){
        AuthenticationRemote aRemote = new coshms.util.administration.LookupService().lookupAuthenticationBean();
        authorized=aRemote.isAuthorized(userId,"pthResults");     
        if (authorized){
            session.setAttribute("pthResults","yes");
        }else if(!authorized){
            session.setAttribute("pthResults","no");
            response.sendRedirect("login.jsp");
        }
    }else if(pthResults.equals("no")){
        response.sendRedirect("login.jsp");
    }
}
%>

   <jsp:useBean id="pthData" scope="page" class="coshms.beans.PthAvailableTestsDataBean" />
   <%int ptId = pthData.getPtIdfromSamId(Integer.parseInt(request.getParameter("sid")));
   Integer pid=new Integer(ptId);
   System.out.println("\n\n\n " + pid);
%><%
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
   
   <?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
     <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
     <title>Recomend Test</title>
     <link href="images/styles.css" rel="stylesheet" type="text/css" />
	 <!--script language="javascript" src="scripts/pthTestResult.js"></script-->
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
            : Test Result For
           <%=pthData.getPthTestNameforSam(Integer.parseInt(request.getParameter("sid")))%>
          </td>
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
					  
					  
					   
 <form action="PthTestResultAdd" method="POST" name="testResult" onsubmit="return validateForm (testResult)">
  
                          <table width="100%"  cellpadding="5" cellspacing="0">
                            <tr> 
                              <td colspan="6" class="genBFont"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                  <tr> 
                                    <td height="23" colspan="5" class="topDotedborder"><div class="genHeadingFont">Patient 
                                        Basic Information</div></td>
                                  </tr>
                                  <tr> 
                                    <td width="19%" class="genBFont">Name</td>
                                    <td width="33%" class="genFont"><%=pt.getFirstName()%> 
                                      <%=pt.getLastName()%></td>
                                    <td width="6%" class="genBFont">Pid</td>
                                    <td width="16%" class="genFont"><%=pt.getPid().toString()%></td>
                                    <td width="26%" rowspan="6"><table width="100%" border="0" cellspacing="0" cellpadding="2">
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
                            <tr> 
                              <td colspan="6" class="topDotedborder"><div class="genHeadingFont">Test 
                                  Finidings</div></td>
                            </tr>
                            <tr bgcolor="#EFEFEF"> 
                              <td class="genBFont" width="300">Content Name</td>
                              <td  class="genBFont" width="90">Min Value</td>
                              <td  class="genBFont" width="80">Result</td>
                              <td  class="genBFont" width="100">Max Value</td>
                              <td  class="genBFont" width="90">Unit</td>
                              <td  class="genBFont" width="90">Notes</td>
                            </tr>
                            <% 
    PthTestContentsInfo pthTests;
    ArrayList pthTestsList = null;
    Iterator pthTestsIt = null;
    String testName = "";
    try {
        //sampleId
        int sId = Integer.parseInt(request.getParameter("sid"));
        pthTestsList = pthData.getPthAvailableTestCon(sId);
        if(pthTestsList == null)
        {
        response.sendRedirect("pthMessage.jsp?message=MayBe Incorrect Sample ID ");
        }
        pthTestsIt = pthTestsList.iterator();
      %>
                            <input type="hidden" name="sid" value=<%=request.getParameter("sid")%> />
                            <%   
    String cid = "";
    String testId = "";
    
       while(pthTestsIt.hasNext()){
           pthTests = (PthTestContentsInfo)pthTestsIt.next(); 
           cid = Integer.valueOf(pthTests.getContentId()).toString();
                     
    %>
                            <tr> 
                              <td class="topborder"><input type="hidden" name="cid" value=<%=cid%> /> 
                                <div class="genFont"><%=pthTests.getName()%></div></td>
                              <td  class="topborder"><div class="genFont"><%=pthTests.getMinValue()%></div>
                                <input type="hidden" name="minVal" value=<%=pthTests.getMinValue()%> /> 
                              </td>
                              <td  class="topborder"><input type="text" name="result"  class="inputField" size="5"/></td>
                              <td  class="topborder"><div class="genFont"><%=pthTests.getMaxValue()%></div>
                                <input type="hidden" name="maxVal" value=<%=pthTests.getMaxValue()%> /> 
                              </td>
                              <td  class="topborder"><div class="genFont"><%=pthTests.getUnit()%></div></td>
                              <td  class="topborder"> <select name="cNotes" class="menuFormat">
                                  <option value="Normal">Normal</option>
                                  <option value="High">High</option>
                                  <option value="Very High">Very High</option>
                                  <option value="Low">Low</option>
                                  <option value="Very Low">Very Low</option>
                                </select> </div></td>
                            </tr>
                            <%   
       }
    }catch(Exception ex)
            { %>
                            <%=ex.getMessage()%> 
                            <%    }
            %>
                            <tr> 
                              <td align="center" colspan="6"> <input name="reset" type="reset" class="btnFormat" value="Reset"/> 
                                <input type="submit" value="Submit" class="btnFormat"/></td>
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
