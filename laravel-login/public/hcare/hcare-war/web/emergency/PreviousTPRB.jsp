<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page 
import="coshms.ejb.emergency.RegistrationMedicationRemote" 
import="coshms.util.EJBAccessPoint"
import="coshms.util.emergency.*"
import="java.util.ArrayList"
import="java.util.Iterator"
%>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Untitled Document</title>
        <link href="../images/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body topmargin="0" rightmargin="0" leftmargin="0">
<%
Integer pid = new Integer(request.getParameter("pid"));
Integer emgEncNo = new Integer(request.getParameter("emgEncNo"));
RegistrationMedicationRemote regMed=new EJBAccessPoint().lookupRegistrationMedicationBean();
ArrayList list = regMed.getAllTPRB(pid,emgEncNo);
Iterator i=list.iterator();
TPRBRecord tprb=null;
%>

<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr bgcolor="#CCCCCC" class="genBFont"> 
    <td width="35%">Date and Time</td>
    <td width="14%">B.P. (mmHg)</td>
    <td width="14%">Pulse (/min)</td>
    <td width="21%">Temperature (f<sup>o</sup>)</td>
    <td width="16%">R.Rate (/min)</td>
  </tr>
  <%
while(i.hasNext()){
                tprb = new TPRBRecord();
                tprb = (TPRBRecord)i.next();
%>
  <tr class="gen9Font"> 
    <td><%=tprb.getDTime().toLocaleString()%></td>
    <td><%=tprb.getMinBp()+"/"+tprb.getMaxBp()%></td>
    <td><%=tprb.getPulse()%></td>
    <td><%=tprb.getTemp()%></td>
    <td><%=tprb.getRRate()%></td>
  </tr>
  <%}%>
</table>
</body>
</html>
        
        
