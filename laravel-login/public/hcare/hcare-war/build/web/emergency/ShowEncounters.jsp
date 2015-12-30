<%@ page language="java"
import="java.sql.*"
import="coshms.ejb.domain.RegisterPatientRemote"
import="coshms.util.EJBAccessPoint" 
import="coshms.util.PatientNotFoundException"
import="coshms.util.domain.Patient"
import="coshms.util.emergency.EncHeading"
import="java.util.Iterator"
import="java.util.ArrayList"
%>
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
                                                
        Integer pid=new Integer(request.getParameter("pid"));
        EJBAccessPoint ejbAP = new EJBAccessPoint();
        RegisterPatientRemote regPt = ejbAP.lookupRegisterPatientBean();
        Patient pt=null;
        pt= regPt.getPatient(pid);
        if(pt==null){
            RequestDispatcher dispatcher = null;
            dispatcher = request.getRequestDispatcher("InfoTreatment.jsp?msg=Patient Not Found: !");
            dispatcher.forward(request,response);            
        }else{
            

             if(pt.isPicExist()){
                byte by2[] = new byte[pt.getPicSize()];
                by2 = pt.getPicByte();
                java.io.RandomAccessFile f1 = new java.io.RandomAccessFile(getServletContext().getRealPath("/emergency/images/"+pid+".jpg"),"rw");
                f1.write(by2);
                f1.close();
                }
        // Patient pt= regPt.getPatient(new Integer(1));
        %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Old Treatments</title>
        <link href="../images/styles.css" rel="stylesheet" type="text/css" />
    </head>    
    <body topmargin="0" rightmargin="0" leftmargin="0">
        <table  border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td valign="top"><jsp:include page="include/TreatmentMenu.html" flush="true"/></td>
                <td valign="top">
                    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr><td colspan="3" height="3"></td></tr>
                        <tr>
                            <td width="8" ><img src="../images/left.gif" height="32" /></td>
                            
                            
          <td  width="100%" background="../images/pixi_bg.gif" class="genArlBFont">Emergency 
            : Patient Treatment </td>
                            <td width="212"><img src="../images/right.gif"  height="32" /></td>
                        </tr>
                        <tr><td colspan="3" height="3"></td></tr>
                        <!-- main Dept:SubDepartment Name, heading, 3 row completed -->
                        <tr>
                            <td colspan="3">
                                <table width="100%" cellpadding="0"  cellspacing="0" class="normalBorderTable">
                                    <tr>
                                        
                                        
               
                                    </tr>
                                    <tr>
                                        
                                        <td>

                                        <table width="100%" border="0" align="center" cellpadding="4">
                    <tr> 
                      <td height="28" colspan="5"  class="topDotedborder">
<div class="genHeadingFont">Patient 
                          Information</div></td>
                    </tr>
                    <tr> 
                      <td width="23%" height="28" class="genBFont">Name</td>
                      <td width="32%" class="genFont"><%=pt.getFirstName()%> <%=pt.getLastName()%></td>
                      <td width="6%" class="genBFont">PID</td>
                      <td width="11%" class="genFont"><%=pt.getPid()%></td>
                      <td width="28%" rowspan="6"  valign="top"><img  border="1" width="124" height="141" src=<%if(pt.isPicExist()){%>"images/<%=pt.getPid()%>.jpg"<%}else{%>"../images/na.jpg"<%}%>/></td>
                    </tr>
                    <tr> 
                      <td height="27" class="genBFont">Father/Husband Name</td>
                      <td class="genFont"><%=pt.getFatherName()%></td>
                      <td class="genBFont">Age</td>
                      <td class="genFont"><%=pt.getAge()%> Yr(s) </td>
                    </tr>
                    <tr> 
                      <td height="20" class="genBFont">Address</td>
                      <td class="genFont"><%=pt.getStreetAddress()%> </td>
                      <td class="genBFont">Gender</td>
                      <td class="genFont"><%=pt.getGender()%></td>
                    </tr>
                    <tr> 
                      <td class="genBFont"></td>
                      <td class="genFont"><%=pt.getTown()%>,<%=pt.getCity()%></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr> 
                      <td class="genBFont">CNIC</td>
                      <td class="genFont"><%if(pt.getCnic()==null)out.println("N/A");else out.println(pt.getCnic());%></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr> 
                      <td class="genBFont"></td>
                      <td class="genFont">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    
                    <tr> 
                      <td colspan="5" > 
                        <%
                                                ArrayList listEnc = ejbAP.lookupRegistrationMedicationBean().getAllEncsHeading(pid);
                                                Iterator itrEnc = listEnc.iterator();
                                                %>
                        <table width="100%" border="0" cellspacing="0" cellpadding="7">
                          <tr > 
                            <td colspan="5" class="topDotedborder"><div class="genHeadingFont">Encounters 
                                Detail</div></td>
                          </tr>
                          <tr bgcolor="#EFEFEF"> 
                            <td width="16%" class="genBFont">Encounter No.</td>
                            <td width="32%"  class="genBFont">Date &amp; Time</td>
                            <td width="17%"  class="genBFont">MLC Type</td>
                            <td width="18%"  class="genBFont">Encounter Info</td>
                            <td width="17%"  class="genBFont">Treatment Info</td>
                          </tr>
                          <%
                                                    EncHeading encH = new EncHeading();
                                                    while(itrEnc.hasNext()){
                                                    encH = (EncHeading)itrEnc.next();
                                                    %>
                          <tr> 
                            <td class="topborder"><span class="genFont"> <%=encH.getEmgEncNo()%></span></td>
                            <td class="topborder"><span class="genFont"> <%=encH.getDTime().toLocaleString()%></span></td>
                            <td class="topborder"><span class="genFont"><%=encH.getMlcType()%></span> 
                            </td>
                            <td class="topborder"><span class="genFont"><a href="ShowEncDetail.jsp?pid=<%=pid%>&emgEncNo=<%=encH.getEmgEncNo()%>">View 
                              Detail</a></span></td>
                            <td class="topborder"><span class="genFont"><a href="ShowTreatments.jsp?pid=<%=pid%>&emgEncNo=<%=encH.getEmgEncNo()%>">View 
                              Detail</a> </span></td>
                          </tr>
                          <%}%>
                        </table></td>
                    </tr>
                  </table></td>
                                      
                                    </tr>
                                    <tr> 
                                        <td colspan="3">&nbsp; </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
<%}
                                                                                                }%>