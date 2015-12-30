<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import="java.io.*"%>
<%@page import="java.util.*"%>
<%@page import="coshms.ejb.emergency.PharmacyRemote"%>
<%@page import="coshms.domain.emergency.Patient"
import="coshms.util.emergency.*"
import="coshms.ejb.domain.RegisterPatientRemote"
import="coshms.util.EJBAccessPoint" 
%>
<%
      String isPreviliged = null;
                                                char shift = 'M';
                                               
                                               // try {
                                                    isPreviliged = (String)session.getAttribute("toIssueBalanceMedicine");
                                                    System.out.println("$$$$$$$$$$$$$"+isPreviliged);
                                                //}catch (Exception ex1) {}

                                                if (isPreviliged == null) {
                                                    response.sendRedirect("login.jsp");
                                                } else if (isPreviliged.equals("no")) {
                                                    response.sendRedirect("login.jsp");
                                                } 
                                                else if (isPreviliged.equals("yes")) 
                                                {
//////////////////////////////////////////////////////////////////////
Integer ptId=new Integer(request.getParameter("pid"));
EJBAccessPoint ejbAP = new EJBAccessPoint();
RegisterPatientRemote regPt = ejbAP.lookupRegisterPatientBean();
coshms.util.domain.Patient dmnPt=null;
ArrayList list = new ArrayList ();
int count = 0;
    dmnPt= regPt.getPatient(ptId);    
    if(dmnPt==null){
         RequestDispatcher dispatcher = null;
         dispatcher = request.getRequestDispatcher("InfoPhr.jsp?msg=Patient not Registered");
         dispatcher.forward(request,response);
     }   
    else{
    if(dmnPt.isPicExist()){
        byte by2[] = new byte[dmnPt.getPicSize()];
        by2 = dmnPt.getPicByte();
        String name = "/images/"+dmnPt.getPid()+".jpg";
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
        <title>Issue Balance Medicine</title>
		<script language="javascript" src="scripts/issueBalanceMedicine.js"></script>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0">
        <form action="BalncMedsTransaction" method="get" name = "issueBalncMeds" onsubmit="return validateForm (issueBalncMeds);">
            <table  border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="top"><jsp:include page="menue.html" flush="true"/></td>

                    <td valign="top">

                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td colspan="4" height="3"></td>
          </tr>
          <tr> 
            <td width="8" rowspan="2" ><img src="images/left.gif" height="32" /></td>
            <td width="446" rowspan="2" background="images/pixi_bg.gif" class="genArlBFont">Emergency 
              : Issue Balance Medicine </td>			 <%
                                                       String eName = null, desig = null, eId = null , uName = null;
                                                       eId = (String)session.getAttribute ("empId");
                                                       eName = (String)session.getAttribute ("empName");
                                                       desig = (String)session.getAttribute ("designation");
                                                       uName = (String)session.getAttribute ("userName");
            if (uName == null)
            {
                                                           uName = "Guest";
            }
%>
              <td width="321" height="19" align="right" background="images/pixi_bg.gif"><div class="genLoginTag">Welcome, <%=uName%> </div></td>
            <td width="10" rowspan="2"><img src="images/right.gif"  height="32" /></td>
          </tr>
          <tr>
<td height="14" align="right"  bgcolor="#51A4D8"><div class="genLoginTag">
<%if (eName != null){%>
<%=eName%> (<%=desig%>) - <a href="Logout" class="small">Logout</a>
          <%}%>
          </div></td>
          </tr>
          <tr> 
            <td colspan="4" height="3"></td>
          </tr>
          <tr> 
            <td colspan="4"> <table class="normalBorderTable" width="100%"  cellspacing="0" cellpadding="0">
                <tr> 
                  <td height="100%" valign="top"> 
                    <!--the work begin-->
                    <%
                                              
                                                    
                                                  
      int pid=        Integer.parseInt(request.getParameter ("pid"));
       int emgEncNo=   Integer.parseInt(request.getParameter ("emgEncNo"));
       int treatmentNo=Integer.parseInt(request.getParameter ("treatmentNo"));
       
                        LookupService lookupService = new LookupService ();
                        PharmacyRemote remote = lookupService.lookupPharmacyBean ();

                        ArrayList listBasic = new ArrayList ();
                        ArrayList listTrtmt = new ArrayList ();
                        ArrayList listMedicine = new ArrayList ();

                        String name = null, fatherName = null,  address = null,  dob= null,  sex = null;
                        int age =0;
                        
                        String cnic=null;
                        cnic=new EJBAccessPoint().lookupRegisterPatientBean().getPatient(ptId).getCnic();
                        try
                        {
                            listBasic = remote.getPatientRegInfo (pid);
                            Iterator iteratorBasic = listBasic.iterator ();
                            while (iteratorBasic.hasNext ())
                            {
                                Patient patient = new Patient ();
                                patient = (Patient)iteratorBasic.next ();

                                name = patient.getFirstName () +" "+patient.getLastName ();
                                fatherName = patient.getFatherName ();
                                address = patient.getStreetAddress ()+", "+patient.getTown ()+", "+patient.getCity ();
                                dob = patient.getDob ();
                                sex = patient.getGender ();
                                java.util.Date dt = new java.util.Date ();
                                int year = dt.getYear ();
                                age = (1900 + year) - Integer.parseInt (dob.substring (0,4));
                    %>
                    <input type="hidden" value="<%=pid%>" name="pid"/> <input type="hidden" value="<%=emgEncNo%>" name="emgEncNo"/> 
                    <input type="hidden" value="<%=treatmentNo%>" name="treatmentNo"/> 
                    <table width="100%"  border="0" cellspacing="4" cellpadding="4">
                      <tr> 
                        <td  colspan="5" class="topDotedborder"><div class="genHeadingFont">Basic 
                            Information </div></td>
                      </tr>
                      <tr> 
                        <td width="25%" class="genBFont">Name</td>
                        <td width="30%" class="genFrontFont"><%=name%></td>
                        <td width="2%" class="genBFont">PID</td>
                        <td width="23%" class="genFrontFont"><%=pid%></td>
                        <td width="20%" rowspan="4" class="genFrontFont"><img width="100" height="120" src="
<%if(dmnPt.isPicExist()){
    out.write("../images/"+dmnPt.getPid()+".jpg");
}else{
    out.write("../images/na.jpg");
}%>
"  border="1"/></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Father/Husband Name </td>
                        <td class="genFrontFont"><%=fatherName%> </td>
                        <td class="genBFont">Age</td>
                        <td class="genFrontFont"><%=age%></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Sex</td>
                        <td class="genFrontFont"><%=sex%></td>
                        <td class="genBFont">&nbsp;</td>
                        <td class="genFrontFont">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Address</td>
                        <td class="genFrontFont"><%=address%> </td>
                        <td class="genFrontFont">&nbsp;</td>
                        <td class="genFrontFont">&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="genBFont">CNIC</td>
                        <td class="genFrontFont"><%if(cnic==null)out.println("N/A");else out.println(cnic);%></td>
                        <td class="genFrontFont">&nbsp;</td>
                        <td class="genFrontFont">&nbsp;</td>
                        <td class="genFrontFont">&nbsp;</td>
                      </tr>
                    </table>
                    <br> 
                    <%}}catch (Exception e) {}%>
                    <%
                                                     try
                                                {

                                                    list = remote.getBalanceMedicine (pid , emgEncNo , treatmentNo);
                                                    Iterator iteratorMedicine = list.iterator ();
                                                    %>
                    <table width="100%"  border="0" cellspacing="0" cellpadding="5" id="theTable">
                      <tr> 
                        <td colspan="4" class="topDotedborder"><div class="genHeadingFont">Prescribed 
                            Medicine in Balance </div></td>
                      </tr>
                      <tr bgcolor="#EFEFEF"> 
                        <td width="5%" height="33"><span class="genBFont">Sr</span>.</td>
                        <td width="66%" class="genBFont">Medicine Name</td>
                        <td width="14%" class="genBFont">Balance Qty </td>
                        <td width="10%" class="genBFont">Issue Qty </td>
                      </tr>
                      <%
                                                    while (iteratorMedicine.hasNext ())
                                                    {
                                                        count++;
                                                        MedicinePrescription medicinePrescription = new MedicinePrescription ();
                                                        medicinePrescription = (MedicinePrescription)iteratorMedicine.next ();
                                                %>
                      <tr > 
                        <td  class="topborder"><div  class="genFont"><%=count%></div></td>
                        <td   class="topborder" ><div class="genFont"><%=medicinePrescription.getName ()%></div></td>
                        <td  class="topborder"> <div class="genFont" ><%=medicinePrescription.getQty ()%></div></td>
                        <td  class="topborder"> <input type="text" name="issueQty"  size="1" class="inputField" > 
                          <input type="hidden" name="mCode"  value="<%=medicinePrescription.getMCode ()%>" /> 
                          <input type="hidden" name="balncQty"  value="<%=medicinePrescription.getQty ()%>" /> 
                        </td>
                      </tr>
                      <%}}catch (Exception e) {}%>
                    </table>
                    <div align="center"> <br>
                      <%if (count > 0)
                               {
%>
                      <input  value="Done" type="submit" class="btnFormat"/>
                      <input value="Clear"  type="reset" class="btnFormat"/>
                      <%}else{
%>
                      <div align="center" class="genBFont">No Medicine to issue<br />
                        It means patient medicine request is complete</div>
                      <%}%>
                    </div>
                    <br> </td>
                </tr>
              </table></td>
          </tr>
        </table>
                    </td>
                </tr>
            </table>

            </td>
            </tr>
            </table>
        </form>
    </body>
</html>
<%}}%>