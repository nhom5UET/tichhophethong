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
        <title>JSP Pagde</title>
         <link href="images/styles.css" rel="stylesheet" type="text/css">
    </head>
    <body>
    <form action="MedTransaction" method="get">

   <%
      ArrayList listMedicine = new ArrayList ();
      
       LookupService lookupService = new LookupService ();
       PharmacyRemote remote = lookupService.lookupPharmacyBean ();

       int pid=        Integer.parseInt(request.getParameter ("pid"));
       int emgEncNo=   Integer.parseInt(request.getParameter ("emgEncNo"));
       int treatmentNo=Integer.parseInt(request.getParameter ("treatmentNo"));
       
       String name =  request.getParameter ("name");
       String address = request.getParameter ("address"); 
       String fatherName = request.getParameter ("fatherName");
       String age = request.getParameter ("age");
       String sex = request.getParameter ("sex");
               
   %>
   <input type="hidden" name="pid"  value="<%=pid%>" />
   <input type="hidden" name="emgEncNo"  value="<%=emgEncNo%>" />
   <input type="hidden" name="treatmentNo"  value="<%=treatmentNo%>" />
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
                       </td>
                   </tr>
               </table> 
  <span class="gen9Font"><u><br>
                           Prescribed Medicines</u></span>
                           <table width="100%"  border="0" cellspacing="0" cellpadding="5" id="theTable">
                               <%  
                                   try
                                   {
                                       listMedicine = remote.getMedicineRecord (pid , emgEncNo , treatmentNo);
                                       Iterator iteratorMedicine = listMedicine.iterator ();
                                       int count = 0;%>
     
                               <tr>
                                   <td width="5%" height="33"><span class="genBFont">Sr</span>.</td>
                                   <td width="66%" class="genBFont">Medicine Name</td>
                                   <td width="14%" class="genBFont">Prescribed Qty                         </td>
                                   <td width="10%" class="genBFont">Issue<br> 
                                   Qty </td>
                                   <td width="5%" class="genBFont">&nbsp;</td>
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
                                   <td  class="topborder">
                           
                                       <input type="text" name="issueQty"  size="1" class="inputField" >
                                       <input type="hidden" name="mCode"  value="<%=medicinePrescription.getMCode ()%>" />
                                       <input type="hidden" name="actQty"  value="<%=medicinePrescription.getQty ()%>" />                                   </td>
                                   <td   class="topborder">&nbsp;</td>
                               </tr>
                               <%}}catch (Exception e) {}%>         
                           </table>		
                           <div align="center">
                               
                               <br>
                               <input  value="Done" type="submit" class="btnFormat"/> <input value="Clear"  type="reset" class="btnFormat"/>
                           </div>                     </td>

                   </tr>
               </table>
           
           </form>
       </body>
   </html>
   

 
 