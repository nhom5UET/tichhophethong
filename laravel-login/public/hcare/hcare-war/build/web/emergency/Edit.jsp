<%@ page language="java" import="java.sql.*" errorPage="" %>
<%@page import="coshms.util.domain.Patient"%>
<%@page import="coshms.ejb.domain.RegisterPatientRemote"%>
<%@page import="coshms.util.EJBAccessPoint"%>
<%@page import="coshms.util.BasicFunction"%>
<%
                                                String isPreviliged = null;
                                                //char shift = 'M';
                                               
                                               // try {
                                                    isPreviliged = (String)session.getAttribute("regPatient");
                                                  
                                                //}catch (Exception ex1) {}

                                                if (isPreviliged == null) {
                                                    response.sendRedirect("login.jsp");
                                                } else if (isPreviliged.equals("no")) {
                                                    response.sendRedirect("login.jsp");
                                                } 
                                                else if (isPreviliged.equals("yes"))
                                                {
%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- saved from url=(0081)http://webdeveloper.earthweb.com/repository/javascripts/2001/04/39581/PopDemo.htm -->
<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>New Patient</title>

<link href="../images/styles.css" rel="stylesheet" type="text/css">
<script language="javascript" src="scripts/Edit.js"></script>

</head>
    <body topmargin="0" rightmargin="0" leftmargin="0">
<IFRAME 
id=popFrame 
style="BORDER-RIGHT: 2px ridge; BORDER-TOP: 2px ridge; Z-INDEX: 65535; VISIBILITY: hidden; BORDER-LEFT: 2px ridge; BORDER-BOTTOM: 2px ridge; POSITION: absolute" 
name=popFrame 
src="../images/popcjs.htm" 
frameBorder=0 scrolling=no></IFRAME>
<SCRIPT>document.onclick=function() {document.getElementById("popFrame").style.visibility="hidden";}</SCRIPT>

	<%
    Integer pid=new Integer(request.getParameter("pid"));
    RegisterPatientRemote regPt = new EJBAccessPoint().lookupRegisterPatientBean();
    Patient pt= regPt.getPatient(pid);
    %>
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top"><jsp:include page="include/RgMenu.htm" flush="true"/></td>
                <td valign="top">
                    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr><td colspan="3" height="3"></td></tr>
                        <tr>
                            <td width="8" ><img src="../images/left.gif" height="32" /></td>
                            
          <td width="992" background="../images/pixi_bg.gif" class="genArlBFont">Emergency 
            : Registration Module</td>
                            <td width="9"><img src="../images/right.gif"  height="32" /></td>
                        </tr>
                        <tr><td colspan="3" height="3"></td></tr>
                        <!-- main Dept:SubDepartment Name, heading, 3 row completed -->
                        <tr>
                            <td colspan="3">
                                <table width="100%" cellpadding="0"  cellspacing="0" class="normalBorderTable">
                                    <tr>
                                        <td height="60" valign="top" colspan="2"> 
                                            <!-- table for interface heading -->
                                            <table width="80%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="1%">&nbsp;</td>
                                                    <td width="99%">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td height="24"></td>
                                                    <td class="topDotedborder"><div class="genHeadingFont">Update 
                          Patient Information:</div></td>
                                                </tr>
                                            </table>
											
                                            <!-- end of table for interface heading -->
                                        </td>
                                    </tr>
                                    <tr><td width="2%">&nbsp;</td>
                                        
                <td width="96%"><form name="PtUpdate" method="post" action="EditPtInfo" onSubmit="return validateForm (PtUpdate);">
                    <table width="80%" border="0" cellpadding="4" align="center">
                      <tr> 
                        <td height="20" class="genBFont">PID</td>
                        <td colspan="2" class="genBFont"><%=pid%></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Registration Date</td>
                        <td colspan="2" class="genBFont"><%=new BasicFunction().getDateString(pt.getRegDate())%></td>
                      </tr>
                      <tr> 
                        <td colspan="3" class="genHeadingFont"><br>
                        Patient Basic Info</td>
                      </tr>
                      <tr> 
                        <td width="33%" class="genBFont">First Name</td>
                        <td colspan="2"><input name="firstName" type="text" class="inputField" id="firstName2" value="<%=pt.getFirstName()%>" size="35" maxlength="20"></td>
                      </tr>
                      <tr> 
                        <td height="24" class="genBFont">Last Name</td>
                        <td colspan="2"><input name="lastName" type="text" class="inputField" id="lastName" value="<%=pt.getLastName()%>" size="35" maxlength="20"></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Father/Husband Name</td>
                        <td colspan="2"><input name="fatherName" type="text" class="inputField" id="fatherName" value="<%=pt.getFatherName()%>" size="35" maxlength="20"></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Date of Birth</td>
                        <td width="29%">
<input name="dob" type="text" class="inputField" size="30" maxlength="15" id=dc1 readOnly value="<%=new BasicFunction().getDateString(pt.getDob())%>">						</td>
<td width="38%">
 <INPUT onClick="popFrame.fPopCalendar('dc1','dc1',event);" type=button value=" V " class="btnSmallFormat">                      </tr>
                      <tr>
                        <td class="genBFont">CNIC No </td>
                        <td colspan="2"><input name="cnic" type="text" class="inputField" id="cnic" value="<%=pt.getCnic()%>" size="35" maxlength="20"></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Gender</td>
                        <td colspan="2"><table width="40%" border="0" align="left">
                            <tr> 
                              <td width="12%"><input name="gender" type="radio" value="M" <%if (pt.getGender().equals("M")){%>checked<%}%>></td>
                              <td width="39%" class="genFont">Male</td>
                              <td width="5%"><input name="gender" type="radio" value="F" <%if (pt.getGender().equals("F")){%>checked<%}%>></td>
                              <td width="44%" class="genFont">Female</td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr> 
                        <td colspan="3" class="genHeadingFont"><strong><br>
                        Address</strong></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Street Address</td>
                        <td colspan="2"><input name="streetAddress" type="text" class="inputField" id="firstName422" value="<%=pt.getStreetAddress()%>" size="35" maxlength="20"></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Town</td>
                        <td colspan="2"><input name="town" type="text" class="inputField" id="town" value="<%=pt.getTown()%>" size="35" maxlength="20"></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">City</td>
                       <td colspan="2" class="genFont"><select name="city" class="menuFormat">
                          <option value="" selected >Select City</option>
                          <option value="Lahore" <%if(pt.getCity().equals("Lahore")){%>selected<%}%> >Lahore</option>
                          <option value="Faisalabad" <%if(pt.getCity().equals("Faisalabad")){%>selected<%}%> >Faisalabad</option>
                          <option value="Kasur" <%if(pt.getCity().equals("Kasur")){%>selected<%}%> >Kasur</option>
                          <option value="Islamabad" <%if(pt.getCity().equals("Islamabad")){%>selected<%}%> >Islamabad</option>
                          <option value="Multan" <%if(pt.getCity().equals("Multan")){%>selected<%}%> >Multan</option>
                        </select></td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td colspan="3"><div align="right"> 
                            <p align="center"> 
                              <input type="hidden" name="pid" value="<%=pt.getPid()%>">
                              <input name="Reset" type="reset" class="btnFormat" value="Clear">
                              <input name="Submit2" type="submit" class="btnFormat" value="Submit">
                            </p>
                          </div>
                          <div align="left"> </div></td>
                      </tr>
                    </table>
            </form></td>
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
<%}%>