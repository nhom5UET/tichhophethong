<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page 
import="coshms.ejb.emergency.RegistrationMedicationRemote" 
import="coshms.ejb.domain.EmployeeRemote"
import="coshms.ejb.domain.WardRemote"
import="coshms.util.EJBAccessPoint"
import="coshms.util.emergency.*"
import="coshms.util.BasicFunction"
import="java.util.Iterator"
import="java.util.ArrayList"
import="coshms.util.domain.Mapping"
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
                                                %>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Treatment Information</title>
        <link href="../images/styles.css" rel="stylesheet" type="text/css" />
        <script  language="JavaScript" type="text/javascript" src="scripts/treatment.js"></script>
    </head>    
    <body topmargin="0" rightmargin="0" leftmargin="0">
        <%
            Integer empId=new Integer(1);
            Integer pid = new Integer(request.getParameter("pid"));
            Integer emgEncNo = new Integer(request.getParameter("emgEncNo"));
            Integer treatmentNo = new Integer(request.getParameter("treatmentNo"));
            
            EJBAccessPoint ejbAP=new EJBAccessPoint();
            RegistrationMedicationRemote regMed=ejbAP.lookupRegistrationMedicationBean();
            Patient pt = regMed.getPatient(pid,emgEncNo);
            TPRBRecord tprb=regMed.getLatestTPRB(pid,emgEncNo);

            Treatment treatment = regMed.getTreatment( pid,emgEncNo,treatmentNo);
            Iterator dItr=treatment.getDiseaseList().iterator(),mItr=treatment.getMedicineList().iterator();
        %>
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top"><jsp:include page="include/HomeMenu.htm" flush="true"/></td>
                <td valign="top">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr><td colspan="3" height="3"></td></tr>
                        <tr>
                            <td width="8" ><img src="../images/left.gif" height="32" /></td>
                            
                            <td width="992" background="../images/pixi_bg.gif" class="genArlBFont">Emergency 
                            :Treatment</td>
                            <td width="9"><img src="../images/right.gif"  height="32" /></td>
                        </tr>
                        <tr><td colspan="3" height="3"></td></tr>
                        <!-- main Dept:SubDepartment Name, heading, 3 row completed -->
                        <tr>
                            <td colspan="3">
                                <table width="100%" cellpadding="0"  cellspacing="0" class="normalBorderTable">
                                    <tr>
                                        
               
                                    </tr>
                                    <tr>
                                        
                                        <td width="96%"><form name="form1" method="post" action="TreatmentReport">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td><table width="100%" border="0" cellspacing="0" cellpadding="7">
                            <tr> 
                              <td colspan="4" class="topDotedborder"><div class="genHeadingFont">Patient 
                                  Information </div></td>
                            </tr>
                            <tr> 
                              <td width="32%" class="genBFont">Name</td>
                              <td width="24%" class="genFont"><%=pt.getName()%></td>
                              <td width="24%" class="genBFont">PID</td>
                              <td width="20%" class="genFont"><%=pt.getPid()%></td>
                            </tr>
                            <tr> 
                              <td class="genBFont">Father/Husband Name</td>
                              <td class="genFont"><%=pt.getFatherName()%></td>
                              <td class="genBFont">Age</td>
                              <td class="genFont"><%=pt.getAge()%> Yrs</td>
                            </tr>
                            <tr> 
                              <td class="genBFont">MLC</td>
                              <td class="genFont"><%=pt.getMlc()%></td>
                              <td class="genBFont">Gender</td>
                              <td class="genFont"> <%if ("M".equals(pt.getGender())){%>
                                  Male<%}else if ("F".equals(pt.getGender())){%>
                                  Female
                                  <%}%></td>
                            </tr>
                            <tr> 
                              <td class="genBFont">Address</td>
                              <td class="genFont"><%=pt.getAddress()%></td>
                              <td class="genBFont">Encounter No</td>
                              <td class="genFont"><%=pt.getEncNo()%></td>
                            </tr>
                            <tr> 
                              <td class="genBFont">CNIC</td>
                              <td class="genFont"><%if(pt.getCnic()==null)out.println("N/A");else out.println(pt.getCnic());%></td>
                              <td class="genBFont">Enc. Date &amp; Time</td>
                              <td class="genFont"><%=pt.getEncDateTime().toLocaleString()%></td>
                            </tr>
                          </table></td>
                                                </tr>
                                                <tr>
                                                    <td><table width="100%" border="0" cellspacing="0" cellpadding="7">
                                                        <tr> 
                                                            <td colspan="6"class="topDotedborder"><div class="genHeadingFont"><br>
                                  Latest TPRB Record : [At Time : <%=tprb.getDTime().toLocaleString()%>]</div></td>
                                                        </tr>
                                                        <tr> 
                                                            
                              <td width="24%" class="genBFont">Blood Pressure 
                                (B.P.)</td>
                                                            <td width="8%">&nbsp;</td>
                                                            <td width="24%" class="genFont"><%=tprb.getMinBp()+"/"+tprb.getMaxBp()%> 
                                                            mmHg </td>
                                                            
                              <td width="19%" class="genBFont">Temperature</td>
                                                            <td width="6%">&nbsp;</td>
                                                            <td width="19%" class="genFont"><%=tprb.getTemp()%> 
                                                            F<sup>o</sup></td>
                                                        </tr>
                                                        <tr> 
                                                            
                              <td class="genBFont">Pulse Rate</td>
                                                            <td>&nbsp;</td>
                                                            <td class="genFont"><%=tprb.getPulse()%>/Minute</td>
                                                            
                              <td class="genBFont">Respiration Rate</td>
                                                            <td>&nbsp;</td>
                                                            <td class="genFont"><%=tprb.getRRate()%>/Minute</td>
                                                        </tr>
                                                    </table></td>
                                                </tr>
                                                <tr>
                                                    <td><table width="100%" border="0" cellpadding="7" cellspacing="0">
                            <tr class="tableHeader"> 
                              <td colspan="3" class="topDotedborder"><div class="genHeadingFont"><br>
                                  Compaints and Diagonosis</div></td>
                            </tr>
                            <tr> 
                              <td width="222" align="left" valign="top"><div align="left"> 
                                  <span class="genBFont">Presenting Complaints</span> 
                                </div></td>
                              <td width="741" colspan="2"><%=treatment.getPComplaints()%></td>
                            </tr>
                            <tr> 
                              <td valign="top" class="genBFont">Provisional Diagonosis</td>
                              <td colspan="2"> 
                                <%
                                                                    Mapping map;
                                                                    while(dItr.hasNext()){
                                                                        map = (Mapping)dItr.next();
                                                                %>
                                <div class="genFont"><%= map.getKey() %> :: <%=map.getValue()%> 
                                </div>
                                <%}%>
                              </td>
                            </tr>
                            <tr> 
                              <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="7">
                                  <tr> 
                                    <td colspan="8" class="topDotedborder"><div class="genHeadingFont"><br>
                                        Medication</div></td>
                                  </tr>
                                  <tr bgcolor="#EFEFEF"> 
                                    
                                    <td width="25%"><span class="genBFont">Medicine 
                                      Name</span></td>
                                    <td colspan="3"><span class="genBFont">Timings</span></td>
                                    <td width="12%"><span class="genBFont">Qty 
                                      (PCS) </span></td>
                                    <td width="15%"><span class="genBFont"> 
                                      Period (Days)</span> </div></td>
                                    <td width="30%"><span class="genBFont">Comments</span></td>
                                  </tr>
                                  <% 
   Medicine med ;
   BasicFunction bf = new BasicFunction();
   
while(mItr.hasNext()){
       med= (Medicine)mItr.next();%>
                                  <tr > 
                                    
                                    <td class="topborder"><span class="genFont"><%=med.getMName()%></span></td>
                                    <td colspan="3" class="topborder"><span class="genFont"><%=bf.getTiming(med.getTiming())%></span></td>
                                    <td class="topborder"><span class="genFont"><%=med.getQty()%></span></td>
                                    <td class="topborder"><span class="genFont"><%=med.getPeriod()%></span> 
                                    </td>
                                    <td class="topborder"><span class="genFont"><%=med.getComments()%></span></td>
                                  </tr>
                                  <%}%>
                                </table></td>
                            </tr>
                            <tr> 
                              <td>&nbsp;</td>
                              <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr> 
                              <td class="genBFont">Refer To Ward</td>
                              <td colspan="2" class="genFont"><%=treatment.getWardName()%></td>
                            </tr>
                            
                            <tr> 
                              <td colspan="3"><div align="right"> </div>
                                <div align="center"> 
                                  <input name="submit" type="submit" class="btnLargeFormat" value="Generate PDF Report">
                                </div></td>
                            </tr>
                          </table></td>
                                                </tr>
                                            </table>
                                            <input type="hidden" name="pid" value="<%=pid%>">
                                            <input type="hidden" name="emgEncNo" value="<%=emgEncNo%>">
                                            <input type="hidden" name="treatmentNo" value="<%=treatmentNo%>">
                                            
                                            
                                        </form> </td>
                                        
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