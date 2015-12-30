<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page 
import="coshms.ejb.domain.RegisterPatientRemote" 
import="coshms.util.EJBAccessPoint"
import="coshms.util.domain.Patient"
import="java.util.ArrayList"
import="java.util.Iterator"
%>
<%
EJBAccessPoint ejbAP = new EJBAccessPoint();
Patient p = (Patient)request.getAttribute("patient");
RegisterPatientRemote regPtRem = ejbAP.lookupRegisterPatientBean();
ArrayList list = regPtRem.searchPatient(p);
if(list.size()==0){
    RequestDispatcher dispatcher = request.getRequestDispatcher("InfoReg.jsp?msg=Search Result Empty!");
    dispatcher.forward(request,response);
    //out.clearBuffer();
    //out.println("NO Patient Found");
    //out.close();
}
Iterator i=list.iterator();
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Search Results</title>
        <link href="../images/styles.css" rel="stylesheet" type="text/css" />
    </head>    
    <body topmargin="0" rightmargin="0" leftmargin="0">
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top"><jsp:include page="include/RgMenu.htm" flush="true"/></td>
                <td valign="top">
                    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr><td colspan="3" height="3"></td></tr>
                        <tr>
                            <td width="8" ><img src="../images/left.gif" height="32" /></td>
                            <td width="992" background="../images/pixi_bg.gif" class="genArlBFont">Emergency : Patient Registeration </td>
                            <td width="9"><img src="../images/right.gif"  height="32" /></td>
                        </tr>
                        <tr><td colspan="3" height="3"></td></tr>
                        <!-- main Dept:SubDepartment Name, heading, 3 row completed -->
                        <tr>
                            <td colspan="3">
                                <table width="100%" cellpadding="0"  cellspacing="0" class="normalBorderTable">

                                        
               

                                    <tr>
                                        <td>
                                            

                  <table width="100%" border="0" align="center" cellpadding="7" cellspacing="0">
                      <tr class="genFont"> 
                      <td colspan="7">Click Record to View Detail</td>
                      </tr>
                      
                    <tr bgcolor="#EFEFEF" class="genBFont"> 
                      <td width="5%">PID</td>
                      <td width="18%">Name</td>
                      <td width="22%">Father/Husband Name</td>
                      <td width="4%">Sex</td>
                      <td width="13%">DOB</td>
                      <td width="13%">Reg. Date</td>
                      <td width="25%">Address</td>
                    </tr>
                    <% 
   while(i.hasNext()){
    Patient pt = (Patient)i.next();
%>
                    <a href="PtActions.jsp?pid=<%=pt.getPid()%>"> 
                    <tr class="genFont" onMouseOver="this.style.backgroundColor='#EBEAE9'" onMouseOut="this.style.backgroundColor='WHITE';"> 
                      <td class="topborder"><%=pt.getPid()%></td>
                      <td class="topborder"><%=pt.getFirstName() +" "+ pt.getLastName()%></td>
                      <td class="topborder"><%=pt.getFatherName()%></td>
                      <td class="topborder">     
                      <%if ("F".equals(pt.getGender())){%>
                            Female
                      <%}else if ("M".equals(pt.getGender())){%>
                            Male
                      <%}%>
                      </td>
                      <td class="topborder"><%=pt.getDob()%></td>
                      <td class="topborder"><%=pt.getRegDate()%></td>
                      <td class="topborder"><%=pt.getStreetAddress()+", "+pt.getTown()+", "+ pt.getCity()%></td>
                    </tr>
                    </a> <!--/a-->
                    <% } %>
                  </table>
                                        </td>
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