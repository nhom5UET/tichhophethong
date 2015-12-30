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
%>
<%--
The taglib directive below imports the JSTL library. If you uncomment it,
you must also add the JSTL library to the project. The Add Library... action
on Libraries node in Projects view can be used to add the JSTL 1.1 library.
--%>
<html>
<head>
<title>ICD - 10 Disease Set</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="images/styles.css" rel="stylesheet" type="text/css" />
<SCRIPT language="JavaScript" src="scripts/icd10.js" type="text/javascript"></SCRIPT>
<link href="../images/styles.css" rel="stylesheet" type="text/css">
</head>
<% 
String diseaseSubString = new String("%"+request.getParameter("diseaseSubString")+"%");
EJBAccessPoint ejbAP= new EJBAccessPoint();

ArrayList searchResultList = ejbAP.lookupDiseaseBean().getDiseaseLike(diseaseSubString);
ArrayList empDiseaseSetList = ejbAP.lookupEmployeeBean().getDiseaseSet(new Integer(1));

Iterator srItr = searchResultList.iterator();
Iterator edsItr = empDiseaseSetList.iterator();
%>

<body>
<form name="icd10" action="UpdateDiseaseSetAndReturn.jsp" method="post" onSubmit="return isDiseaseSetNull ('icd10')">
<center>
    <table width="810" border="0" cellspacing="1" cellpadding="1" >
      <tr>
    <td  class="topDotedborder"><div class="genHeadingFont">ICD-10 : Disease Selector 
          </div></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="1" >
            <tr> 
              <td width="50%"><span class="genBFont">
              Search Result:</span></td>
              <td width="50%"><span class="genBFont">New Selected Diseases:</span></td>
            </tr>
            <tr> 
              <td align="center"> <select name="diseaseMatched" size="25" class="listBox" style="width:400;" onChange="moveOver();">
                  <% 
Mapping map;
while(srItr.hasNext()){
    map = (Mapping)srItr.next();
%>
                  <option value="<%=map.getKey()%>"><%=map.getValue()%></option>
                  <%}%>
                </select> </td>
              <td><select name="diseaseSet" size="25" multiple="multiple" class="listBox" style="width:400;">
                </select></td>
            </tr>
            <tr> 
              <td align="center"> <input type="button" class="btnLargeFormat"   onClick = "addSelectedItemsToParent()" value="Return to Treatment"/></td>
              <td align="center"><input name="submit" type="submit"   value="Update Disease Set and Return" class="btnLargeFormat" />
                <input name="button" type="button"  onClick="removeMe();" value="Remove" class="btnLargeFormat" /></td>
            </tr>
          </table>
            </td>
  </tr>
</table>
      <select multiple="multiple" name="workingSet" style="width:1;" size="1" class="listBox">
<% while(edsItr.hasNext()){
    map = (Mapping)edsItr.next();
%>
<option value="<%=map.getKey()%>"><%=map.getValue()%></option>
<%}%>
      </select>     
  </center>
  </form>
</body>
</html>