<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page 
import="coshms.ejb.emergency.RegistrationMedicationRemote" 
import="coshms.util.EJBAccessPoint"
import="coshms.util.emergency.Patient"
import="java.util.*"
%>
<%
                                                String isPreviliged = null;
                                                isPreviliged = (String)session.getAttribute("chkTPRB");
                                                if (isPreviliged == null) {
                                                    response.sendRedirect("login.jsp");
                                                } else if (isPreviliged.equals("no")) {
                                                    response.sendRedirect("login.jsp");
                                                } else if (isPreviliged.equals("yes")) {
                                                %>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Check TPRB</title>
        <link href="../images/styles.css" rel="stylesheet" type="text/css" />
		<script language="javascript" src="scripts/TPRBInput.js"></script>
    </head>    
    <body topmargin="0" rightmargin="0" leftmargin="0">
<%
   Integer pid = new Integer(request.getParameter("pid"));
   RegistrationMedicationRemote regMed=new EJBAccessPoint().lookupRegistrationMedicationBean();
   Patient pt = regMed.getPtForTPRB(pid);
   if(pt==null){
         RequestDispatcher dispatcher = null;
         dispatcher = request.getRequestDispatcher("Info.jsp?msg=Patient not Registered in Emergency");
         dispatcher.forward(request,response);         
   }
     if(pt.isPicExist()){
      byte by2[] = new byte[pt.getPicSize()];
      by2 = pt.getPicByte();
      java.io.RandomAccessFile f1 = new java.io.RandomAccessFile(getServletContext().getRealPath("/emergency/images/"+pid+".jpg"),"rw");
      f1.write(by2);
      f1.close();
     }
%>
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top"><jsp:include page="include/HomeMenu.htm" flush="true"/></td>
                <td valign="top">
                    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr><td colspan="3" height="3"></td></tr>
                        <tr>
                            <td width="8" ><img src="../images/left.gif" height="32" /></td>
                            
          <td width="992" background="../images/pixi_bg.gif" class="genArlBFont">Emergency 
            : Check TPRB</td>
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
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="1%">&nbsp;</td>
                                                    <td width="99%">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td height="24"></td>
                                                    <td class="topDotedborder"><div class="genHeadingFont">Enter 
                          TPRB Record of Selected Patient:</div></td>
                                                </tr>
                                            </table>
											
                                            <!-- end of table for interface heading -->
                                        </td>
                                    </tr>
                                    <tr><td width="2%">&nbsp;</td>
                                        
                <td width="96%"><form name="TPRBInput" method="post" action="TakeTPRB" >
                    <table width="100%" border="0" cellspacing="0" cellpadding="4">
                      <tr>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
                            <tr> 
                              <td width="23%" class="genBFont">Name:</td>
                              <td width="28%" class="genFont"><%=pt.getName()%></td>
                              <td width="13%" class="genBFont">PID:</td>
                              <td width="18%" class="genFont"><%=pt.getPid()%></td>
                              <td width="18%" rowspan="5" class="genFont"><img width="100" height="120" border="1" src=<%if(pt.isPicExist()){%>"images/<%=pid%>.jpg"<%}else{%>"../images/na.jpg"<%}%>/></td>
                            </tr>
                            <tr> 
                              <td class="genBFont">Father/Husband Name:</td>
                              <td class="genFont"><%=pt.getFatherName()%></td>
                              <td class="genBFont">Age:</td>
                              <td class="genFont"><%=pt.getAge()%></td>
                            </tr>
                            <tr> 
                              <td class="genBFont">MLC:</td>
                              <td class="genFont"><%=pt.getMlc()%></td>
                              <td class="genBFont">Gender:</td>
                              <td class="genFont">
                                  <%if ("M".equals(pt.getGender())){%>
                                  Male<%}else if ("F".equals(pt.getGender())){%>
                                  Female
                                  <%}%>

                            </td>
                            </tr>
                            <tr> 
                              <td class="genBFont">Address:</td>
                              <td class="genFont"><%=pt.getAddress()%></td>
                              <td class="genBFont">Encounter No:</td>
                              <td class="genFont"><%=pt.getEncNo()%></td>
                            </tr>
                            <tr> 
                              <td class="genBFont">CNIC:</td>
                              <td class="genFont"><%=pt.getCnic()%>&nbsp;</td>
                              <td class="genBFont">Enc. Date &amp; Time:</td>
                              <td class="genFont"><%=pt.getEncDateTime().toLocaleString()%></td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
                            <tr> 
                              <td colspan="4" class="tableHeader">Input Data:</td>
                            </tr>
                            <tr> 
                              <td width="22%" class="genBFont">Blood Pressure 
                                (B.P.) Min:</td>
                              <td width="37%">
<input name="minBp" type="text" class="inputField" id="BP" size="3" maxlength="3"/>
                              </td>
                              <td width="11%" class="genBFont">Max: </td>
                              <td width="30%" class="genFont"><input name="maxBp" type="text" class="inputField" id="maxBp" size="3" maxlength="3"/>
                                mmHg (e.g. 80/100)</td>
                            </tr>
                            <tr> 
                              <td class="genBFont">Pulse Rate:</td>
                              <td><input name="pulse" type="text" class="inputField" id="pulse" size="3" maxlength="3" />
                                /Minute</td>
                              <td class="genBFont">Temperature:</td>
                              <td class="genFont"><input name="temp" type="text" class="inputField" id="temp" size="3" maxlength="3" />
                                Fo</td>
                            </tr>
                            <tr> 
                              <td class="genBFont">Respiration Rate:</td>
                              <td><input name="rRate" type="text" class="inputField" id="rRate2" size="3" maxlength="3" />
                                /Minute</td>
                              <td class="genFont">&nbsp;</td>
                              <td class="genFont">&nbsp;</td>
                            </tr>
                            <tr> 
                              <td class="genBFont">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td class="genFont">&nbsp;</td>
                              <td class="genFont">&nbsp;</td>
                            </tr>
                            <tr> 
                              <td class="genBFont">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr> 
                              <td colspan="4"><div align="center"> 
                                  <p class="tableFooter"> 
                                    <input name="Reset" type="reset" class="btnFormat" value="Clear" />
                                    <input name="Submit" type="submit" class="btnFormat" value="Submit" />
                                    <input type="hidden" name="pid" value="<%=pid%>"/>
                                    <input type="hidden" name="emgEncNo" value="<%=pt.getEncNo()%>"/>
                                  </p>
                                </div></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table>
                  </form> </td>
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