<%@ page language="java"
import="java.sql.*"
import="coshms.ejb.domain.RegisterPatientRemote"
import="coshms.util.EJBAccessPoint" 
import="coshms.util.PatientNotFoundException"
import="coshms.util.domain.Patient"
%>

<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%
response.setHeader("Cache-Control","no-cache"); //document should never be cached. HTTP 1.1
response.setHeader("Pragma", "no-cache"); //HTTP 1.0
response.setDateHeader("Expires", 0);
%>


            <%
                                                String isPreviliged = null;

                                                isPreviliged = (String)session.getAttribute("regPatient");



                                                if (isPreviliged == null) {
                                                    response.sendRedirect("login.jsp");
                                                } else if (isPreviliged.equals("no")) {
                                                    response.sendRedirect("login.jsp");
                                                } else if (isPreviliged.equals("yes")) {


                                                    Integer pid=new Integer(request.getParameter("pid"));
                                                    RegisterPatientRemote regPt = new EJBAccessPoint().lookupRegisterPatientBean();
                                                    Patient pt=null;
                                                    pt=regPt.getPatient(pid);
                                                    if(pt==null){
                                    //            response.sendRedirect("InfoReg.jsp?msg=Patient Not Found: !");
                                                        RequestDispatcher dispatcher = null;
                                                        dispatcher = request.getRequestDispatcher("InfoReg.jsp?msg=Patient Not Found: !");
                                                        dispatcher.forward(request,response);
                                                    }else{
                                                        if(pt.isPicExist()){
                                                            byte by2[] = new byte[pt.getPicSize()];
                                                            by2 = pt.getPicByte();
                                                            java.io.RandomAccessFile f1 = new java.io.RandomAccessFile(getServletContext().getRealPath("/emergency/images/"+pid+".jpg"),"rw");
                                                            f1.write(by2);
                                                            f1.close();
                                                        }
                                            %>
                                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta HTTP-EQUIV=”pragma” content=”no-cache” />
        <meta HTTP-EQUIV=”Expires” content=”-1” />
        <title>Registered Patient</title>
        <link href="../images/styles.css" rel="stylesheet" type="text/css" />
    </head>    
    <body topmargin="0" rightmargin="0" leftmargin="0">
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top"><jsp:include page="include/RgMenu.htm" flush="true"/></td>
                <td valign="top">
                    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr><td colspan="3" height="3"></td></tr>
                        <tr>
                            <td width="8" ><img src="../images/left.gif" height="32" /></td>
                            
                            
          <td width="992" background="../images/pixi_bg.gif" class="genArlBFont">Emergency 
            : Registered Patient</td>
                            <td width="9"><img src="../images/right.gif"  height="32" /></td>
                        </tr>
						<tr><td></td>
          <td height="7"></td>
        </tr>
                
                        <!-- main Dept:SubDepartment Name, heading, 3 row completed -->
                        <tr>
                            <td colspan="3">
                                <table width="100%" cellpadding="0"  cellspacing="0" class="normalBorderTable">
                 
                                    <tr><td width="2%">&nbsp;</td>
                                        
                                        <td width="100%"> 
      
                                        <table width="100%" border="0" align="left" cellpadding="4">
                                                                                       <tr> 
                                                <td height="29" colspan="3" class="topDotedborder"><div class="genHeadingFont">Patient Information</div></td>
                                            </tr>
                                                                                       <tr>
                                                                                         <td class="genBFont">PID</td>
                                                                                         <td class="genFont"><%=pt.getPid()%></td>
                                                                                         <td width="38%" rowspan="8" class="genBFont"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                          
                                                          <td><img width="175" height="200" border="1" src=<%if(pt.isPicExist()){%>"images/<%=pt.getPid()%>.jpg"<%}else{%>"../images/na.jpg"<%}%>/></td>
                                                      </tr>
                                                  </table> </td>
                                                                                       </tr>
                                            <tr> 
                                                
                      <td width="24%" class="genBFont">Name</td>
                                                <td width="38%" class="genFont"><%=pt.getFirstName()%> <%=pt.getLastName()%></td>
                                            </tr>
                                            <tr> 
                                                
                      <td height="20" class="genBFont">Father Name</td>
                                                <td class="genFont"><%=pt.getFatherName()%></td>
                                            </tr>
                                            <tr> 
                                                
                      <td height="20" class="genBFont">Address</td>
                                                <td class="genFont"><%=pt.getStreetAddress()%></td>
                                            </tr>
                                            <tr> 
                                                <td class="genBFont"></td>
                                                <td class="genFont"><%=pt.getTown()%>, <%=pt.getCity()%></td>
                                            </tr>
                                            <tr> 
                                                <td class="genBFont">CNIC No </td>
                                                <td><span class="genFont"><%=pt.getCnic()%></span></td>
                                            </tr>
                                            <tr> 
                                                
                      <td class="genBFont">Age</td>
                                                <td class="genFont"><%=pt.getAge()%> Yr(s) </td>
                                            </tr>
                                            <tr> 
                                                
                      <td class="genBFont">Gender</td>
                      <td class="genFont">
                          <%if ("F".equals(pt.getGender())){%>
                            Female
                            <%}else if ("M".equals(pt.getGender())){%>
                            Male
                            <%}%>

                      </td>
                                            </tr>
                                            <tr> 
                                                <td colspan="3"  class="topDotedborder"><div class="genHeadingFont"><br />
                          Basic Actions</div></td>
                                            </tr>
                                            <tr> 
                                                <td colspan="3" class="genBFont"> <table width="100%" border="0" cellpadding="4" cellspacing="0">
                                                    <tr> 
                                                        <td width="3%"><div align="right"><img src="../images/arr.gif" width="12" height="12" /></div></td>
                                                        <td width="97%"><div align="left"> 
                                                            <p class="gen9Font"><a href="Enc.jsp?pid=<%=pt.getPid()%>">Emergency 
                                                            Encounter</a></p>
                                                        </div></td>
                                                    </tr>
                                                    <tr> 
                                                        <td><div align="right"><img src="../images/arr.gif" width="12" height="12" /></div></td>
                                                        <td class="gen9Font"><div align="left"><a href="Edit.jsp?pid=<%=pt.getPid()%>" > 
                                                        Edit Patient Information</a></div></td>
                                                    </tr>
                                                    <tr> 
                                                        <td><div align="right"><img src="../images/arr.gif" width="12" height="12" /></div></td>
                                                        <td class="gen9Font"><div align="left"><a href="HealthCardServlet?pid=<%=pt.getPid()%>">View 
                                                        Health Card</a></div></td>
                                                    </tr>
                                                </table></td>
                                            </tr>
                                        </table></td>
                                        <td width="2%">&nbsp;</td>
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
<%}}%>