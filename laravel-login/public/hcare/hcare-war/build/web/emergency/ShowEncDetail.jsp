<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page 
import="coshms.ejb.emergency.RegistrationMedicationRemote" 
import="coshms.util.EJBAccessPoint"
import="coshms.util.emergency.Patient"
import="coshms.util.emergency.EncounterDetail"
import="java.util.*"
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
        <title>Encounter Detail</title>
        <link href="../images/styles.css" rel="stylesheet" type="text/css" />
		<script language="javascript" src="scripts/TPRBInput.js"></script>
    </head>    
    <body topmargin="0" rightmargin="0" leftmargin="0">
<%
   int pid = Integer.parseInt(request.getParameter("pid"));
   int emgEncNo = Integer.parseInt(request.getParameter("emgEncNo"));
   
   RegistrationMedicationRemote regMed=new EJBAccessPoint().lookupRegistrationMedicationBean();
   Patient pt = regMed.getPtForTPRB(new Integer(pid));
   EncounterDetail encD = regMed.getEncounterDetail(pid,emgEncNo);
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
            : Encounter Detail </td>
                            <td width="9"><img src="../images/right.gif"  height="32" /></td>
                        </tr>
                        <tr><td colspan="3" height="3"></td></tr>
                        <!-- main Dept:SubDepartment Name, heading, 3 row completed -->
                        <tr>
                            <td colspan="3">
                                <table width="100%" cellpadding="0"  cellspacing="0" class="normalBorderTable">
                                    <tr>
                                        
                <td valign="top" colspan="2"> 
                  <!-- table for interface heading -->
                  <!-- end of table for interface heading -->
                </td>
                                    </tr>
                                    <tr>
                                        
                <td width="96%"><form name="TPRBInput" method="post" action="TakeTPRB"  onSubmit="return validateForm(TPRBInput);">
                    <table width="100%" border="0" cellspacing="0" cellpadding="4">
                      <tr> 
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="7">
                            <tr> 
                              <td width="24%" class="genBFont">Name</td>
                              <td width="28%" class="genFont"><%=pt.getName()%></td>
                              <td width="15%" class="genBFont">PID</td>
                              <td width="15%" class="genFont"><%=pt.getPid()%></td>
                              <td width="18%" rowspan="5" class="genFont"><img width="100" height="120" border="1" src=<%if(pt.isPicExist()){%>"images/<%=pt.getPid()%>.jpg"<%}else{%>"../images/na.jpg"<%}%>/></td>
                            </tr>
                            <tr> 
                              <td class="genBFont">Father/Husband Name</td>
                              <td class="genFont"><%=pt.getFatherName()%></td>
                              <td class="genBFont">Age</td>
                              <td class="genFont"><%=pt.getAge()%></td>
                            </tr>
                            <tr> 
                              <td class="genBFont">MLC</td>
                              <td class="genFont"><%=encD.getMlc()%></td>
                              <td class="genBFont">Gender</td>
                              <td class="genFont"><%=pt.getGender()%></td>
                            </tr>
                            <tr> 
                              <td class="genBFont">Address</td>
                              <td class="genFont"><%=pt.getAddress()%></td>
                              <td class="genBFont">Encounter No</td>
                              <td class="genFont"><%=emgEncNo%></td>
                            </tr>
                            <tr> 
                              <td class="genBFont">CNIC</td>
                              <td class="genFont"><%if(pt.getCnic()==null)out.println("N/A");else out.println(pt.getCnic());%></td>
                              <td class="genBFont">Enc. Date &amp; Time</td>
                              <td class="genFont"><%=encD.getEncDateTime().toLocaleString()%></td>
                            </tr>
                            <tr> 
                              <td>&nbsp; </td>
                              <td>&nbsp;</td>
                              <td class="genBFont">&nbsp;</td>
                              <td class="genFont">&nbsp;</td>
                              <td rowspan="6" class="genFont">&nbsp;</td>
                            </tr>
                            <tr> 
                              <td class="genBFont">Brought By</td>
                              <td class="genFont"><%=encD.getBroughtBy()%> </td>
                              <td class="genBFont">Phone No</td>
                              <td class="genFont"><%=encD.getPhNo()%></td>
                            </tr>
                             <tr> 
                              <td class="genBFont">Refered</td>
                              <td class="genFont"> 
                                <%if(encD.isIsRefered()){%>
                                YES 
                                <%}else{%>
                                NO 
                                <%}%>
                              </td>
                              <td class="genBFont">&nbsp;</td>
                              <td class="genFont">&nbsp;</td>
                            </tr>
                            <% if(encD.isIsRefered()){%>                           
                            <tr> 
                              <td colspan="4" class="genBFont">Reference Detail</td>
                            </tr>
                            <tr> 
                              <td class="genBFont">Name</td>
                              <td class="genFont"><%=encD.getRefName()%></td>
                              <td class="genBFont">Phone No</td>
                              <td class="genFont"><%=encD.getRefPhNo()%></td>
                            </tr>
                            <tr> 
                              <td class="genBFont">Notes</td>
                              <td class="genFont"><%=encD.getRefNotes()%></td>
                              <td class="genBFont">FileId</td>
                              <td class="genFont"><%=encD.getFileId()%></td>
                            </tr>
                            <%}%>
                          </table></td>
                      </tr>
                    </table>
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