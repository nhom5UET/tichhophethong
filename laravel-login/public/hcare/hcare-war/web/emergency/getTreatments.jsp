<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import="java.io.*"%>
<%@page import="java.util.*"%>
<%@page import="coshms.ejb.emergency.PharmacyRemote"%>
<%@page import="coshms.domain.emergency.Patient"
import="coshms.util.emergency.*"
import="coshms.ejb.domain.RegisterPatientRemote"
import="coshms.util.EJBAccessPoint" 
%><%
   int workForBalanceTransc = -1;
   String temp = null;
   //workForBalanceTransc = Integer.parseInt(request.getParameter("workForBalanceTransc"));
   temp = request.getParameter("workForBalanceTransc");
   if (temp != null)
   {
       workForBalanceTransc = Integer.parseInt(temp);
   }
   String role = null , roleResult = null;
   if (workForBalanceTransc == 0) 
   {
       role = "toIssueMedicine";
   System.out.println(session.getAttribute(role).toString());
       roleResult = session.getAttribute(role).toString();
   } 
   else if (workForBalanceTransc == 1) 
   {
       role = "toIssueBalanceMedicine";
       System.out.println(session.getAttribute(role).toString());
       roleResult = session.getAttribute(role).toString();
   }
   /*
   else if (workForBalanceTransc == -1) 
   {
        response.sendRedirect("login.jsp");
   }
   */
   if (roleResult == null)
   {
       response.sendRedirect("login.jsp");
   }
   if (roleResult != null)
   {
    Integer ptId=new Integer(request.getParameter("pid"));
    EJBAccessPoint ejbAP = new EJBAccessPoint();
    RegisterPatientRemote regPt = ejbAP.lookupRegisterPatientBean();
    coshms.util.domain.Patient dmnPt=null;
    dmnPt= regPt.getPatient(ptId);
    if(dmnPt==null){
        RequestDispatcher dispatcher = null;
        dispatcher = request.getRequestDispatcher("InfoPhr.jsp?msg=Patient not Registered");
        dispatcher.forward(request,response);
    } else {
        if(dmnPt.isPicExist()) {
            byte by2[] = new byte[dmnPt.getPicSize()];
            by2 = dmnPt.getPicByte();
            String name = "/images/"+dmnPt.getPid()+".jpg";
            java.io.RandomAccessFile f1 = new java.io.RandomAccessFile(getServletContext().getRealPath(name),"rw");
            f1.write(by2);
            f1.close();
        }
    %>
   <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>All Treatments</title>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0">
       
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
          <td width="441" rowspan="2" background="images/pixi_bg.gif" class="genArlBFont">Emergency 
            : All Available Treatments </td>			 <%
                                                       String empName = null, designation = null, empId = null , login = null, userName = null;
                                                       login = (String)session.getAttribute ("login");
                                                       empId = (String)session.getAttribute ("empId");
                                                       empName = (String)session.getAttribute ("empName");
                                                       designation = (String)session.getAttribute ("designation");
                                                       userName = (String)session.getAttribute ("userName");
            if (userName == null)
            {
                                                           userName = "Guest";
            }
%>
          <td width="326" background="images/pixi_bg.gif" align="right"><div class="genLoginTag">Welcome, <%=userName%> </div></td>
          <td width="10" rowspan="2"><img src="images/right.gif"  height="32" /></td>
        </tr>
        <tr>
          <td align="right"  bgcolor="#51A4D8"><div class="genLoginTag">
<%if (empName != null){%>
<%=empName%> (<%=designation%>) - <a href="Logout" class="small">Logout</a>
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
                        int pid = Integer.parseInt(request.getParameter("pid"));
                        
                        LookupService lookupService = new LookupService();
                        PharmacyRemote remote = lookupService.lookupPharmacyBean();

                        ArrayList listBasic = new ArrayList();
                        ArrayList listTrtmt = new ArrayList();
                        ArrayList listMedicine = new ArrayList();

                        String name = null, fatherName = null,  address = null,  dob= null,  sex = null;
                        int age =0;
                        String cnic=null;
                        cnic=new EJBAccessPoint().lookupRegisterPatientBean().getPatient(ptId).getCnic();
                        String action = null;
                        if (workForBalanceTransc == 0) {
                            action = "issueMedicine.jsp";
                        } else if (workForBalanceTransc == 1) {
                            action = "issueBalanceMedicine.jsp";
                        }
                        try {
                            listBasic = remote.getPatientRegInfo(pid);
                            Iterator iteratorBasic = listBasic.iterator();
                            while (iteratorBasic.hasNext()) {
                                Patient patient = new Patient();
                                patient = (Patient)iteratorBasic.next();

                                name = patient.getFirstName() +" "+patient.getLastName();
                                fatherName = patient.getFatherName();
								
                                address = patient.getStreetAddress()+", "+patient.getTown()+", "+patient.getCity();
                                dob = patient.getDob();
                                sex = patient.getGender();
                                java.util.Date dt = new java.util.Date();
                                int year = dt.getYear();
                                age = (1900 + year) - Integer.parseInt(dob.substring(0,4));
                        %>
                  <input type="hidden" value="<%=pid%>" name="pid"/> <table width="100%"  border="0" cellspacing="4" cellpadding="4">
                    <tr> 
                      <td  colspan="5" class="topDotedborder"><div class="genHeadingFont">Basic 
                          Information </div></td>
                    </tr>
                    <tr> 
                      <td width="24%" class="genBFont">Name</td>
                      <td width="31%" class="genFrontFont"><%=name%></td>
                      <td width="1%" class="genBFont">PID</td>
                      <td width="18%" class="genFrontFont"><%=pid%></td>
                      <td width="26%" rowspan="4" class="genFrontFont"><img width="100" height="120" src="
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
                      <td colspan="2" class="genFrontFont"><%=address%> 
                        <%}

                        } catch (Exception e) {
                        }


                        try {
                            listTrtmt = remote.getAllTreatmentOnMaxEnc(pid);

                            Iterator iteratorTrtmt  = listTrtmt.iterator();
                                    %>
                      </td>
                      <td class="genFrontFont">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="genBFont">CNIC</td>
                      <td colspan="2" class="genFrontFont"><%if(cnic==null)out.println("N/A");else out.println(cnic);%></td>
                      <td class="genFrontFont">&nbsp;</td>
                      <td class="genFrontFont">&nbsp;</td>
                    </tr>
                  </table>
                  <br> <table width="100%" border="0" cellpadding="7" cellspacing="0">
                    <tr> 
                      <td colspan="4" class="topDotedborder"><div class="genHeadingFont">Encounter 
                          Detail</div></td>
                    </tr>
                    <br>
                    <tr bgcolor="#EFEFEF"> 
                      <td width="16%"><span class="genBFont">Treatment No </span></td>
                      <td width="26%"><span class="genBFont">Treated by </span></td>
                      <td width="24%"><span class="genBFont">Date & Time</span></td>
                      <td width="34%"><span class="genBFont">Select</span></td>
                    </tr>
                    <%
                            while (iteratorTrtmt.hasNext()) {
                                        PtTreatments ptTreatments = new PtTreatments();
                                        ptTreatments = (PtTreatments)iteratorTrtmt.next();%>
                    <tr> 
                      <td  class="topborder"><div class="genFont"><%=ptTreatments.getTreatmentNo ()%></div></td>
                      <td class="topborder"><div class="genFont"><%=ptTreatments.getEmpName ()%></div></td>
                      <td  class="topborder"><div class="genFont"><%=ptTreatments.getTime ()%></div></td>
                      <td class="topborder"><span class="genFrontFont"><a href="<%=action%>?pid=<%=pid%>&emgEncNo=<%=ptTreatments.getEmgEncNo ()%>&treatmentNo=<%=ptTreatments.getTreatmentNo ()%>">This 
                        one </a></span></td>
                    </tr>
                    <%}}catch (Exception e){}%>
                  </table></table></tr>
      </table>

            </td></tr>
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
