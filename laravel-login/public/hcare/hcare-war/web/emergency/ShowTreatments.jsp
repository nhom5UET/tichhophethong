<%@ page language="java"
import="java.sql.*"
import="coshms.ejb.domain.RegisterPatientRemote"
import="coshms.util.EJBAccessPoint" 
import="coshms.util.PatientNotFoundException"
import="coshms.util.domain.Patient"
import="coshms.util.emergency.EncHeading"
import="coshms.util.emergency.TreatmentHeading"
import="java.util.Iterator"
import="java.util.ArrayList"
%>

<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>

<%
                                                String isPreviliged = null;
                                                //char shift = 'M';

                                                // try {
                                                isPreviliged = (String)session.getAttribute("newTreatment");

                                                //}catch (Exception ex1) {}

                                                if (isPreviliged == null) {
                                                    response.sendRedirect("login.jsp");
                                                } else if (isPreviliged.equals("no")) {
                                                    response.sendRedirect("login.jsp");
                                                } else if (isPreviliged.equals("yes")) {
                                                %>
                                                <%
        Integer pid=new Integer(request.getParameter("pid"));
        Integer emgEncNo=new Integer(request.getParameter("emgEncNo"));
        
        EJBAccessPoint ejbAP = new EJBAccessPoint();
        RegisterPatientRemote regPt = ejbAP.lookupRegisterPatientBean();
        Patient pt=null;
        pt= regPt.getPatient(pid);
      if(pt==null){
            RequestDispatcher dispatcher = null;
            dispatcher = request.getRequestDispatcher("InfoReg.jsp?msg=Patient Not Found: !");
            dispatcher.forward(request,response);            
        }else{
        %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Untitled Document</title>
        <link href="../images/styles.css" rel="stylesheet" type="text/css" />
    </head>    
    <body topmargin="0" rightmargin="0" leftmargin="0">
<table  border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td valign="top"><jsp:include page="include/TreatmentMenu.html" flush="true"/></td>
    <td valign="top"> <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3" height="3"></td>
        </tr>
        <tr> 
          <td width="8" ><img src="../images/left.gif" height="32" /></td>
          <td width="992" background="../images/pixi_bg.gif" class="genArlBFont">Emergency 
            : Patient Treatment</td>
          <td width="9"><img src="../images/right.gif"  height="32" /></td>
        </tr>
        <tr>
          <td colspan="3" height="3"></td>
        </tr>
        <!-- main Dept:SubDepartment Name, heading, 3 row completed -->
        <tr> 
          <td colspan="3"> <table width="100%" cellpadding="0"  cellspacing="0" class="normalBorderTable">
              <tr> </tr>
              <tr> 
                <td > <table width="100%" border="0" cellpadding="4">
                    <tr> 
                      <td  colspan="4" class="topDotedborder"><div class="genHeadingFont">Patient 
                          Information</div></td>
                    </tr>
                    <tr> 
                      <td width="23%" class="genBFont">Name</td>
                      <td width="37%" class="genFont"><%=pt.getFirstName()%> <%=pt.getLastName()%></td>
                      <td width="13%" class="genBFont">PID</td>
                      <td width="27%" class="genFont"><%=pt.getPid()%></td>
                    </tr>
                    <tr> 
                      <td class="genBFont">Father Name</td>
                      <td class="genFont"><%=pt.getFatherName()%></td>
                      <td class="genBFont">Age</td>
                      <td class="genFont"><%=pt.getAge()%> Yr(s) </td>
                    </tr>
                    <tr>
                      <td height="20" class="genBFont">Address</td>
                      <td class="genFont"><%=pt.getStreetAddress()%>, <%=pt.getTown()%>, <%=pt.getCity()%> </td>
                      <td class="genBFont">Gender</td>
                      <td class="genFont"><%=pt.getGender()%></td>
                    </tr>
                    <tr> 
                      <td height="20" class="genBFont">CNIC</td>
                      <td class="genFont"><%if(pt.getCnic()==null)out.println("N/A");else out.println(pt.getCnic());%></td>
                      <td class="genBFont">&nbsp;</td>
                      <td class="genFont">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td colspan="4" > 
                        <%
ArrayList listTrt = ejbAP.lookupRegistrationMedicationBean().getAllTreatmentsHeading(pid,emgEncNo);
Iterator itrTrt = listTrt.iterator();
%>
                        <table width="100%" border="0" cellspacing="0" cellpadding="7">
                          <tr> 
                            <td colspan="4"  class="topDotedborder"><div class="genHeadingFont"><br />
                                Treatments Detail</div></td>
                          </tr>
                          <tr bgcolor="#EFEFEF"> 
                            <td width="20%"><span class="genBFont">Treatment No.</span></td>
                            <td width="46%"><span class="genBFont">Date&amp;Time</span></td>
                            <td width="34%"><span class="genBFont">Doctor Name</span></td>
                          </tr>
                          <% 
   TreatmentHeading trtH = new TreatmentHeading();
while(itrTrt.hasNext()){
       trtH = (TreatmentHeading)itrTrt.next();
%>
                          <a href="ShowTreatmentRecord.jsp?pid=<%=pid%>&emgEncNo=<%=emgEncNo%>&treatmentNo=<%=trtH.getTreatmentNo()%>"> 
                                              <tr onMouseOver="this.style.backgroundColor='#EBEAE9'" onMouseOut="this.style.backgroundColor='WHITE';"> 
                            <td class="topborder"><span class="genFont"><%=trtH.getTreatmentNo()%> 
                              </span> </td>
                            <td  class="topborder"><span class="genFont"> 
                              <%=trtH.getDTime().toLocaleString()%> </span></td>
                            <td  class="topborder"><span class="genFont"><%=trtH.getDrName()%> 
                              </span> </td>
                          </tr>
                          </a> 
                          <%}%>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<%}}%>