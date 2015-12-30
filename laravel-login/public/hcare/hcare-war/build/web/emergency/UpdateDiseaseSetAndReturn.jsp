<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page 
import="coshms.ejb.emergency.RegistrationMedicationRemote" 
import="coshms.ejb.domain.EmployeeRemote"
import="coshms.util.EJBAccessPoint"
import="coshms.util.emergency.*"
import="java.util.Iterator"
import="java.util.ArrayList"
import="coshms.util.domain.Mapping"
%>
<html>
   <head>
<title>ICD - 10 Disease Set</title>
<link href="images/styles.css" rel="stylesheet" type="text/css" />
<SCRIPT language="JavaScript" src="scripts/icd10.js" type="text/javascript"></SCRIPT>
   <link href="../images/styles.css" rel="stylesheet" type="text/css">
   </head>
       
<%
Integer empId =  new Integer(1);   
String[] diseaseArr = request.getParameterValues("diseaseSet");
EJBAccessPoint ejbAP = new EJBAccessPoint();
ejbAP.lookupEmployeeBean().addToDiseaseSet(empId,diseaseArr);
ArrayList diseaseSetList = ejbAP.lookupEmployeeBean().getDiseaseSet(empId);
Iterator itr = diseaseSetList.iterator();
%>

<body>
              <form name="icd10" action="DiseaseSearch" method="POST">
<center>
    <table width="810" border="0" cellspacing="1" cellpadding="1" class="mainTable">
      <tr>
        <td class="topDotedborder"  ><div class="genHeadingFont">Your Current Disease Set</div></td>
  </tr>
  <tr>
    <td align="center" valign="middle">
<select name="workingSet" size="25" multiple="MULTIPLE" style="width:400;" class="listBox">
<% Mapping map;
   
while(itr.hasNext()) {
    map = (Mapping)itr.next();
%>
<option value="<%=map.getKey()%>"><%=map.getValue()%></option>
<%}%>
</select>
          <table width="100%" border="0" cellspacing="1" cellpadding="1" >
            <tr> 
              <td colspan="2" class="genFont" align="center"></td>
            </tr>
              <tr> 
              <td width="43%"></td>
              <td width="38%"></td>
            </tr>
            <tr valign="middle"> 
              <td colspan="2" align="center"><input name="button2" type="button" class="btnLargeFormat"   onClick = "addSelectedItemsToParent()" value="Return to OPD Zone"/></td> 
              <td width="19%" align="center" class = "genFont"> <a href="ICD10.htm">Search 
                  and Add More</a>
                </td>
            </tr>
          </table></td>
  </tr>
</table>
      </center>
</form>
    </body>
</html>