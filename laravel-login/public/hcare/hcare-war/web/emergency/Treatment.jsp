<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page 
import="coshms.ejb.emergency.RegistrationMedicationRemote" 
import="coshms.ejb.domain.EmployeeRemote"
import="coshms.ejb.domain.WardRemote"
import="coshms.util.EJBAccessPoint"
import="coshms.util.emergency.*"
import="java.util.Iterator"
import="java.util.ArrayList"
import="coshms.util.domain.Mapping"
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
        <title>Treatment</title>
        <link href="../images/styles.css" rel="stylesheet" type="text/css" />
        <script  language="JavaScript" type="text/javascript" src="scripts/treatment.js"></script>
        <!--script  language="JavaScript" type="text/javascript" src="scripts/dynamic_Controls.js"></script-->	
    </head>    
    <body topmargin="0" rightmargin="0" leftmargin="0">
        <%
            Integer empId=new Integer(1);
            Integer pid = new Integer(request.getParameter("pid"));

            EJBAccessPoint ejbAP=new EJBAccessPoint();
            RegistrationMedicationRemote regMed=ejbAP.lookupRegistrationMedicationBean();
            
            EmployeeRemote emp=ejbAP.lookupEmployeeBean();
            WardRemote ward = ejbAP.lookupWardBean();            
            
            Patient pt = regMed.getPtForTPRB(pid);
              if(pt==null){
                RequestDispatcher dispatcher = null;
                dispatcher = request.getRequestDispatcher("InfoTreatment.jsp?msg=Patient not Exist Or Not Encounted in Emergency !");
                dispatcher.forward(request,response);         
            }          
            TPRBRecord tprb=regMed.getLatestTPRB(pid,pt.getEncNo());
              if(tprb==null){
                RequestDispatcher dispatcher = null;
                dispatcher = request.getRequestDispatcher("InfoTreatment.jsp?msg=TPRB no taken yet !");
                dispatcher.forward(request,response);         
            }
            ArrayList dList,mList,wardList; //mList:medicineList, dList:diseaseList

            dList = emp.getDiseaseSet(empId);
            mList = emp.getMedicineSet(empId);
            wardList = ward.getAllWards();

            Iterator dItr=dList.iterator(),mItr=mList.iterator(),wardItr=wardList.iterator();
            
            //////////////// image related code
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
                <td valign="top"><jsp:include page="include/TreatmentMenu.html" flush="true"/></td>
                <td valign="top">
                    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td colspan="4" height="3"></td>
        </tr>
        <tr> 
          <td width="8" rowspan="2" ><img src="../images/left.gif" height="32" /></td>
          <td width="496" rowspan="2" background="../images/pixi_bg.gif" class="genArlBFont">Emergency 
            : Treatment</td> <%
                                                       String eName = null;
                                                       String designation = null;
                                                       String eId = null;
                                                       String login = null;
                                                       String uName = null;
                                                       
                                                       login = (String)session.getAttribute ("login");
                                                      
                                                       eName = (String)session.getAttribute ("empName");
                                                       designation = (String)session.getAttribute ("designation");
                                                       uName = (String)session.getAttribute ("userName");
                                                       

            if (uName == null)
            {
                                                           uName = "Guest";
            }
%>
          <td width="496" background="../images/pixi_bg.gif" class="genLoginTag" align="right">Welcome, 
            <%=uName%></td>
          <td width="9" rowspan="2"><img src="../images/right.gif"  height="32" /></td>
        </tr>
        <tr>
          <td height="19"  align="right"   bgcolor="#51A4D8" class="genLoginTag">
<%if (eName != null){%>
<%=eName%> (<%=designation%>) - <a href="Logout" class="small">Logout</a>
          <%}%></td>
        </tr>
        <tr> 
          <td colspan="4" height="3"></td>
        </tr>
        <!-- main Dept:SubDepartment Name, heading, 3 row completed -->
        <tr> 
          <td colspan="4"> <table width="100%" cellpadding="0"  cellspacing="0" class="normalBorderTable">
              <tr> 
                <td  valign="top" class="genHeadingFont">&nbsp;&nbsp;&nbsp;</td>
                <td  valign="top"  class="topDotedborder"><div class="genHeadingFont">Patient 
                    Basics</div></td>
              </tr>
              <tr> 
                <td width="2%">&nbsp;</td>
                <td width="100%"> <form name="treatment" method="post" action="Treatment" onSubmit="return validateForm (treatment);">
                    <table width="100%" border="0" cellspacing="0" cellpadding="4">
                      <tr> 
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
                            <tr> 
                              <td width="22%" class="genBFont">
                                Name</td>
                              <td width="28%" class="genFont"><%=pt.getName()%></td>
                              <td width="12%" class="genBFont">PID</td>
                              <td width="17%" class="genFont"><%=pt.getPid()%></td>
                              <td width="21%" rowspan="5" class="genFont"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr> 
                                    <td><img width="100" height="120" border="1" src=<%if(pt.isPicExist()){%>"images/<%=pt.getPid()%>.jpg"<%}else{%>"../images/na.jpg"<%}%>/></td>
                                  </tr>
                                </table></td>
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
                              <td class="genFont"><%=pt.getGender()%></td>
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
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
                            <tr> 
                              <td colspan="6" class="topDotedborder"><div class="genHeadingFont"><br>
                                  Latest TPRB Record : [at Time : <%=tprb.getDTime().toLocaleString()%>]</div></td>
                            </tr>
                            <tr> 
                              <td width="24%" class="genBFont"><br>
                                Blood Pressure (B.P.)</td>
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
                            <tr> 
                              <td class="genBFont">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td class="genFont">&nbsp;</td>
                              <td class="genBFont">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td class="genFont"><input type="button" class="btnLargeFormat" onClick="javascript:small_window('PreviousTPRB.jsp?pid=<%=pid%>&emgEncNo=<%=pt.getEncNo()%>');" value="View Previous TPRB"> 
                                <br></td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr> 
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="7">
                            <tr > 
                              <td colspan="2"  class="topDotedborder"><div class="genHeadingFont">Compaints 
                                  and Diagonosis</div></td>
                            </tr>
                            
                            <tr> 
                              <td width="17%" align="left" valign="top"><div align="left"> 
                                  <p class="genBFont">Presenting Complaints</p>
                                </div></td>
                              <td><textarea name="pComplaints" cols="75" wrap="PHYSICAL" class="listBox" id="pComplaints"></textarea></td>
                            </tr>
                            <tr> 
                              <td valign="top" class="genBFont">Disease Set</td>
                              <td><select onChange="addToDiagnosis();" name="diseaseSet" size="12" multiple class="listBox" id="diseaseSet" style="width:550;">
                                  <%Mapping map=null;
                                                                    while(dItr.hasNext()){
                                                                        map = (Mapping)dItr.next();
                                                                %>
                                  <option value="<%=map.getKey()%>"><%=map.getValue()%></option>
                                  <%
                                                                    }
                                                                %>
                                </select></td>
                            </tr>
                            <tr> 
                              <td>&nbsp;</td>
                              <td > <input name="button2" type="button" class="btnLargeFormat" value="Diagnose Selected "> 
                                <input name="button3" type="button" class="btnLargeFormat" onclick = "javascript:normal_window('icd10.htm');" value="Edit Disease Set"></td>
                            </tr>
                            <tr> 
                              <td valign="top" class="genBFont">Provisional Diagonosis</td>
                              <td><select name="pDiagnosis" size="3" multiple class="listBox" style="width:550;">
                                </select></td>
                            </tr>
                            <tr> 
                              <td>&nbsp;</td>
                              <td><input name="button"  onClick="removeSelected();"type="button" class="btnLargeFormat" value="Remove Selected"> 
                                <strong> </strong></td>
                            </tr>
                            <tr> 
                              <td colspan="2"> <table width="100%" border="0" cellspacing="0" cellpadding="3"  id = "medicine">
                                  <tr> 
                                    <td colspan="9" class="topDotedborder"> 
                                      <div class="genHeadingFont"> Medication</div></td>
                                  </tr>
                                  
                                  <tr class="genBFont"> 
                                    <td width="2%">&nbsp;</td>
                                    <td width="48%"><div align="left">Medicine 
                                        Name</div></td>
                                    <td width="6%">Timings</td>
                                    <td width="6%"><div align="center">QTY<br>
                                        (PCS) </div></td>
                                    <td width="5%"><div align="center"> Period 
                                        (Days) </div></td>
                                    <td width="27%"><div align="left">Comments</div></td>
                                  </tr>
                                  <tr> 
                                    <td class="genFont">1.</td>
                                    <td><select name="medicine" class="menuFormat" id="select5" style="width:350">
                                        <option value="0">Select Medicine</option>
                                        <%
                                                                            while(mItr.hasNext()){
                                                                        map = (Mapping)mItr.next();
                                                                        %>
                                        <option value="<%=map.getKey()%>"><%=map.getValue()%></option>
                                        <%
                                                                            }
                                                                        %>
                                      </select></td>
                                    <td><select name="timing" class="menuFormat" id="select6" style="width:85">
                                        <option value="0">0 + 0 + 0</option>
                                        <option value="1">0 + 0 + 1</option>
                                        <option value="2">0 + 1 + 0</option>
                                        <option value="3">0 + 1 + 1</option>
                                        <option value="4">1 + 0 + 0</option>
                                        <option value="5">1 + 0 + 1</option>
                                        <option value="6">1 + 1 + 0</option>
                                        <option value="7">1 + 1 + 1</option>
                                      </select></td>
                                    <td><input name="qty" type="text" class="inputField" id="qty2" size="4" maxlength="2"></td>
                                    <td><strong> 
                                      <input name="period" type="text" class="inputField" id="period2" size="4" maxlength="3">
                                      </strong></td>
                                    <td><strong> 
                                      <input name="comments" type="text" class="inputField" id="comments2" size="20" maxlength="50">
                                      </strong></td>
                                  </tr>
                                  <tr> 
                                    <td class="genFont">2.</td>
                                    <td><select name="medicine" class="menuFormat" id="select7" style="width:350">
                                        <option value="0">Select Medicine</option>
                                        <% 
                                                                            mItr=mList.iterator();
                                                                            while(mItr.hasNext()){
                                                                                map = (Mapping)mItr.next();
                                                                        %>
                                        <option value="<%=map.getKey()%>"><%=map.getValue()%></option>
                                        <%
                                                                            }
                                                                        %>
                                      </select></td>
                                    <td><select name="timing" class="menuFormat" id="select8" style="width:85">
                                        <option value="0">0 + 0 + 0</option>
                                        <option value="1">0 + 0 + 1</option>
                                        <option value="2">0 + 1 + 0</option>
                                        <option value="3">0 + 1 + 1</option>
                                        <option value="4">1 + 0 + 0</option>
                                        <option value="5">1 + 0 + 1</option>
                                        <option value="6">1 + 1 + 0</option>
                                        <option value="7">1 + 1 + 1</option>
                                      </select></td>
                                    <td><strong> 
                                      <input name="qty" type="text" class="inputField" id="qty2" size="4" maxlength="2">
                                      </strong></td>
                                    <td><strong> 
                                      <input name="period" type="text" class="inputField" id="period2" size="4" maxlength="3">
                                      </strong></td>
                                    <td><strong> 
                                      <input name="comments" type="text" class="inputField" id="comments2" size="20" maxlength="50">
                                      </strong></td>
                                  </tr>
                                  <tr> 
                                    <td class="genFont">3.</td>
                                    <td><select name="medicine" class="menuFormat" id="select7" style="width:350">
                                        <option value="0">Select Medicine</option>
                                        <%
                                                                            mItr = mList.iterator();
                                                                            while(mItr.hasNext()){
                                                                                map = (Mapping)mItr.next();
                                                                        %>
                                        <option value="<%=map.getKey()%>"><%=map.getValue()%></option>
                                        <%
                                                                            }
                                                                        %>
                                      </select></td>
                                    <td><select name="timing" class="menuFormat" id="select9" style="width:85">
                                        <option value="0">0 + 0 + 0</option>
                                        <option value="1">0 + 0 + 1</option>
                                        <option value="2">0 + 1 + 0</option>
                                        <option value="3">0 + 1 + 1</option>
                                        <option value="4">1 + 0 + 0</option>
                                        <option value="5">1 + 0 + 1</option>
                                        <option value="6">1 + 1 + 0</option>
                                        <option value="7">1 + 1 + 1</option>
                                      </select></td>
                                    <td><strong> 
                                      <input name="qty" type="text" class="inputField" id="qty2" size="4" maxlength="2">
                                      </strong></td>
                                    <td><strong> 
                                      <input name="period" type="text" class="inputField" id="period2" size="4" maxlength="3">
                                      </strong></td>
                                    <td><strong> 
                                      <input name="comments" type="text" class="inputField" id="comments2" size="20" maxlength="50">
                                      </strong></td>
                                  </tr>
                                </table>
                                <div align="center"> 
                                  <input type="button" class="btnLargeFormat" value="Add New Medicine" onclick="addRow('medicine')">
                                  <input name="Button" type="button" class="btnLargeFormat" value="Change Medicine Set" onclick="addRow1()">
                                </div></td>
                            </tr>
                            <tr> 
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr> 
                              <td class="genBFont">Refer To Ward</td>
                              <td><select name="refer" class="menuFormat" id="refer">
                                  <option value="0">Do not Refer</option>
                                  <% 
                                                                    while(wardItr.hasNext()){
                                                                                map = (Mapping)wardItr.next();
                                                                %>
                                  <option value="<%=map.getKey()%>"><%=map.getValue()%></option>
                                  <%

                                                                    }
                                                                %>
                                </select></td>
                            </tr>
                            <tr> 
                              <td class="genBFont">Perform Actions</td>
                              <td class="genFont"><a target="blank" href="../pathalogy/pthAvailableTests.jsp?pid=<%=pt.getPid()%>&emgEncNo=<%=pt.getEncNo()%>">Recommend Pathology 
                                Test </a>: : <a target="blank" href="../radiology/radAvailableTests.jsp?pid=<%=pt.getPid()%>&emgEncNo=<%=pt.getEncNo()%>">Recommend Radiology 
                                Test </a> :: Admit / Discharge : :</td>
                            </tr>
                            <tr> 
                              <td colspan="2"><div align="center"> 
                                  <input name="Reset" type="reset" class="btnFormat" value="Clear">
                                  <input type="hidden" name="pid" value="<%=pid%>"/>
                                  <input type="hidden" name="emgEncNo" value="<%=pt.getEncNo()%>"/>
                                  <input type="submit" class="btnFormat" value="Submit" onClick="selectAllDiagnose();">
                                </div></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table>
                  </form></td>
                <td width="2%">&nbsp;</td>
              </tr>
              <tr> 
                <td colspan="3">&nbsp; </td>
              </tr>
            </table></td>
        </tr>
      </table>
                </td>
            </tr>
        </table>
    </body>
</html>
<%}%>