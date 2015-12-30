<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import="java.io.*"%>
<%@page import="java.util.*"%>
<%@page import="coshms.ejb.emergency.PharmacyRemote"%>
<%@page import="coshms.domain.emergency.Patient"%>
<%@page import="coshms.domain.emergency.PatientTprb"%>
<%@page import="coshms.util.emergency.*"%>
<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
   
   <html>
       <head>
           <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
           <title>Issue Balanced Medicine</title>
           <link href="images/styles.css" rel="stylesheet" type="text/css">

       </head>
       <body >
           <form action="issueBalanceMedicine.jsp">
               
               <%
                   int pid = Integer.parseInt (request.getParameter ("pid"));
                   int workForBalanceTransc = Integer.parseInt (request.getParameter ("workForBalanceTransc"));

                   LookupService lookupService = new LookupService ();
                   PharmacyRemote remote = lookupService.lookupPharmacyBean ();

                   ArrayList listBasic = new ArrayList ();
                   ArrayList listTrtmt = new ArrayList ();
                   ArrayList listMedicine = new ArrayList ();
                   
                    String name = null, fatherName = null,  address = null,  dob= null,  sex = null;
                    int age =0;

                   String action = null;
                   if (workForBalanceTransc == 0)
                   {
                       action = "issueMedicine.jsp";
                   }
                   else if (workForBalanceTransc == 1)
                   {
                       action = "issueBalanceMedicine.jsp";
                   }
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
                           age = year - Integer.parseInt (dob.substring (0,3));
               %>

               <input type="hidden" value="<%=pid%>" name="pid"/>
           
               <table cellpadding="1" cellspacing="1"  width="60%">
                   <tr>
                       <td class="tableHeader">Emergency Pharmacy : Issue Medicines </td>
                   </tr>
                   <tr>
                   <td  class="gen9Font"><u><br>
                   Patient Basic Information</u>
                   <table width="100%"  border="0" cellspacing="3" cellpadding="3">
                       <tr>
                           <td width="25%" class="genBFont">Name</td>
                           <td width="44%" class="genFrontFont"><%=name%></td>
                           <td width="7%" class="genBFont">PID</td>
                           <td width="24%" class="genFrontFont"><%=pid%></td>
                       </tr>
                       <tr>
                           <td class="genBFont">Father/Husband Name 

                           </td>
                           <td class="genFrontFont"><%=fatherName%> </td>
                           <td class="genBFont">Age</td>
                           <td class="genFrontFont"><%=age%></td>
                       </tr>
                       <tr>
                           <td class="genBFont">MLC</td>
                           <td class="genFrontFont">Yes (Accedent)

                           </td>
                           <td class="genBFont">Sex</td>
                           <td class="genFrontFont"><%=sex%></td>
                       </tr>
                       <tr>
                           <td class="genBFont">Address</td>
                           <td colspan="3" class="genFrontFont"><%=address%>
                               <%}

                   }
                   catch (Exception e)
                   {}


                   try
                   {
                       listTrtmt = remote.getAllTreatmentOnMaxEnc (pid);

                       Iterator iteratorTrtmt  = listTrtmt.iterator ();
                               %>
                                       
                           </td>
                       </tr>
                   </table> 
                   <table width="100%" border="0">
                       <tr>
                           <td width="12%"><span class="genBFont">Treatment No </span></td>
                           <td width="54%"><span class="genBFont">Treated by </span></td>
                           <td width="34%"><span class="genBFont">Date Time</span></td>
                           <td width="34%"><span class="genBFont">Select</span></td>
                       </tr>
                       <%
                           while (iteratorTrtmt.hasNext ())
                           {
                               PtTreatments ptTreatments = new PtTreatments ();
                               ptTreatments = (PtTreatments)iteratorTrtmt.next ();%>
                       
                       <tr>
                           <td class="genFont"><%=ptTreatments.getTreatmentNo ()%></td>
                           <td class="genFont"><%=ptTreatments.getEmpName ()%></td>
                           <td class="genFont"><%=ptTreatments.getTime ()%></td><!--&empId=<!--%=ptTreatments.getEmpId ()%>-->
                           <td><span class="genFrontFont"><a href="<%=action%>?pid=<%=pid%>&emgEncNo=<%=ptTreatments.getEmgEncNo ()%>&treatmentNo=<%=ptTreatments.getTreatmentNo ()%>&name=<%=name%>&sex=<%=sex%>&fatherName=<%=fatherName%>&address=<%=address%>&age=<%=age%>">This one </a></span></td>
                       </tr>
  
                       <%}}catch (Exception e){}%>
                   </table>

                 
               </table>
           </form>
       </body>
   </html>
