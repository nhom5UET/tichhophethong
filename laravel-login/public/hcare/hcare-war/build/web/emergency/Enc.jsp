<%@ page language="java"
import="java.sql.*" 
import="java.util.*"
import="coshms.ejb.emergency.RegistrationMedicationRemote"
import="coshms.util.EJBAccessPoint" 
import="coshms.util.domain.Mapping"
import="coshms.ejb.domain.RegisterPatientRemote"
import="coshms.util.PatientNotFoundException"
import="coshms.util.domain.Patient"

errorPage=""%>

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
                                                } else if (isPreviliged.equals("yes")) {
                                                %>
                                                <!--?xml version="1.0" encoding="iso-8859-1"?-->
                                                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>New Emergency Encounter</title>
        <link href="../images/styles.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
function disable()
{
document.getElementById("refName").disabled=true
document.getElementById("refNotes").disabled=true
document.getElementById("refPhNo").disabled=true
document.getElementById("refGenFileId").disabled=true
}
function enable()
{
document.getElementById("refName").disabled=false
document.getElementById("refNotes").disabled=false
document.getElementById("refPhNo").disabled=false
document.getElementById("refGenFileId").disabled=false
}
</script>

    </head>    
    <body topmargin="0" rightmargin="0" leftmargin="0" onload="disable()">
	 <%
            Integer pid=new Integer(request.getParameter("pid"));
            RegistrationMedicationRemote regMed = new EJBAccessPoint().lookupRegistrationMedicationBean();
            ArrayList list = regMed.getAllMLC();
            Iterator i = list.iterator();
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
            : New Emergency Encounter</td>
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
                                        
                <td width="96%"> <form action="Encounter" method="post">
                                    
                    <table width="100%" border="0" align="center" cellpadding="2">
                      <tr> 
                        <td colspan="2"  class="topDotedborder"><div class="genHeadingFont">Patient Basic Information</div>
        <%
        RegisterPatientRemote regPt = new EJBAccessPoint().lookupRegisterPatientBean();
        Patient pt=null;
        pt= regPt.getPatient(pid);
        if(pt==null){
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
        // Patient pt= regPt.getPatient(new Integer(1));
        %>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan="2" class="tableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr> 
                              <td width="19%" class="genBFont">Name</td>
                              <td width="31%" class="genFont"><%=pt.getFirstName()%> 
                                <%=pt.getLastName()%></td>
                              <td width="14%" class="genBFont">PID</td>
                              <td width="13%" class="genFont"><%=pt.getPid()%></td>
                              <td width="23%" rowspan="5"><img border="1" width="90" height="110" src=<%if(pt.isPicExist()){%>"images/<%=pt.getPid()%>.jpg"<%}else{%>"../images/na.jpg"<%}%>/></td>
                            </tr>
                            <tr> 
                              <td class="genBFont">Father Name</td>
                              <td class="genFont"><%=pt.getFatherName()%></td>
                              <td class="genBFont">Age</td>
                              <td class="genFont"><%=pt.getAge()%> Yr(s) </td>
                            </tr>
                            <tr> 
                              <td class="genBFont">Address</td>
                              <td class="genFont"><%=pt.getStreetAddress()%></td>
                              <td class="genBFont">Gender</td>
                              <td class="genFont">
                                  <% if ("F".equals(pt.getGender())){%>
                                  Female<%}else if ("M".equals(pt.getGender())){%>
                                  Male
                                  <%}%>
                              </td>
                            </tr>
                            <tr> 
                              <td class="genBFont">&nbsp;</td>
                              <td class="genFont"><%=pt.getTown()%>, <%=pt.getCity()%></td>
                              <td class="genBFont">&nbsp;</td>
                              <td class="genFont">&nbsp;</td>
                            </tr>
                            <tr> 
                              <td class="genBFont">CNIC No </td>
                              <td class="genFont"><%=pt.getCnic()%></td>
                              <td class="genBFont">&nbsp;</td>
                              <td class="genFont">&nbsp;</td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr> 
                        <td colspan="2"  class="topDotedborder"><div class="genHeadingFont"><br />
                            Encounter Basic Information</div></td>
                      </tr>
                      <tr> 
                        <td width="49%" class="genBFont">MLC<font color="#FF0000">*</font></td>
                        <td width="51%"><select name="MLC" id="MLC" class="menuFormat">
                            <%
                                                    while(i.hasNext()){
                Mapping map = (Mapping)i.next();
                                                %>
                            <option value="<%=map.getKey()%>"><%=map.getValue()%> 
                            </option>
                            <% } %>
                          </select></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Brought By<font color="#FF0000">*</font></td>
                        <td><input   class="inputField" name="broughtBy" type="text" id="broughtBy" size="35" maxlength="20"></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Phone No.</td>
                        <td><input    class="inputField" name="phNo" type="text" id="phNo" size="35" maxlength="20"></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Is Refered</td>
                        <td><table width="40%" border="0" align="left">
                            <tr> 
                              <td width="12%"><input type="radio" name="isRefered" value="1" onclick="enable()" /></td>
                              <td width="39%" class="genFont">Yes</td>
                              <td width="5%" class="genFont"><input name="isRefered" type="radio" value="0" checked onclick="disable()" /></td>
                              <td width="44%" class="genFont">No</td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr>
                        <td colspan="2" class="topDotedborder"><div class="genHeadingFont"><br />
                            Reference Detail (in case of Refered only)</div></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Name:(Hospital, Doctor)</td>
                        <td><input    class="inputField" name="refName" type="text" id="refName" size="35" maxlength="50"></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Notes<font color="#FF0000">*</font></td>
                        <td><textarea  class="textArea" name="refNotes" cols="27" rows="3" wrap="PHYSICAL" id="refNotes"></textarea></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Phone No.</td>
                        <td><input  class="inputField" name="refPhNo" type="text" id="refPhNo" size="35" maxlength="50"></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Generate File ID</td>
                        <td><table width="40%" border="0" align="left">
                            <tr> 
                              <td width="12%"><input type="radio" name="refGenFileId" value="1" id="refGenFileId"></td>
                              <td width="39%" class="genFont">Yes</td>
                              <td width="5%" class="genFont"><input name="refGenFileId" type="radio" value="0" checked id="refGenFileId"></td>
                              <td width="44%" class="genFont">No</td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr> 
                        <td class="genFont"><input type="hidden" name="pid" value="<%=pid%>" /></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr class="tableFooter"> 
                        <td colspan="2"> <div align="center"> 
                            <input type="reset" name="Reset" value="Clear"  class="btnFormat"/>&nbsp;
                            <input type="submit" name="Submit" value="Submit"  class="btnFormat"/>
                          </div></td>
                      </tr>
                    </table>
                                </form></td>
                
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
</html><% }} %>