<%@page contentType="text/html"
import="java.util.*"
import="java.lang.*"
import="coshms.util.EJBAccessPoint"
import="coshms.util.domain.Mapping"
%>
<%@page pageEncoding="UTF-8"%>
<!-- saved from url=(0081)http://webdeveloper.earthweb.com/repository/javascripts/2001/04/39581/PopDemo.htm -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Emergecy Home </title>
        <link href="../images/styles.css" rel="stylesheet" type="text/css" />
    </head>    
    <body topmargin="0" rightmargin="0" leftmargin="0">
	<IFRAME 
id=popFrame 
style="BORDER-RIGHT: 2px ridge; BORDER-TOP: 2px ridge; Z-INDEX: 65535; VISIBILITY: hidden; BORDER-LEFT: 2px ridge; BORDER-BOTTOM: 2px ridge; POSITION: absolute" 
name=popFrame 
src="../images/popcjs.htm" 
frameBorder=0 scrolling=no></IFRAME>
<SCRIPT>document.onclick=function() {document.getElementById("popFrame").style.visibility="hidden";}</SCRIPT>
<%
int id = Integer.parseInt(request.getParameter("id"));
System.out.println("\n\n REPORT ID :: " + id );
%>
<table  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><jsp:include page="menu.html" flush="true"/></td>
    <td valign="top">
      <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3" height="3"></td>
        </tr>
        <tr>
          <td width="8" ><img src="../images/left.gif" height="32" /></td>
          <td width="992" background="../images/pixi_bg.gif" class="genArlBFont">Emergency :: Reports</td>
          <td width="9"><img src="../images/right.gif"  height="32" /></td>
        </tr>
        <tr>
          <td colspan="3" height="3"></td>
        </tr>
        <!-- main Dept:SubDepartment Name, heading, 3 row completed -->
        <tr>
          <td colspan="3">
            <table width="100%" cellpadding="0"  cellspacing="0" class="normalBorderTable">
              <tr>
                <td width="99%"><form method="post" action="ViewReport">
                    <input type="hidden" name="id" value="<%=id%>"/><BR>
                    <table width="100%" border="0" align="center" cellpadding="3" cellspacing="3">
                      <% 
   String reportTitle = "";
   switch(id){
       case 1:
           reportTitle = "Total Patient Registered";
           break;
       case 2:
           reportTitle = "Patient Registered from Each City";
            break;
       case 3:
           reportTitle = "Number of Emergency Patients Encountered";
           break;
       case 4:
           reportTitle = "Total Medical Legal Cases (MLC) in Emergency Department of each type";
           break;
       case 5:
           reportTitle = "How many time each disease is diagnosed";
           break;
       default:
           ;
   }   
%>
                      <tr>
                        <td width="15%" class="genBFont" valign="bottom"><br />
                          <br />
                        Show Report </td>
                        <td colspan="2" class="genFont" valign="bottom"> <%=reportTitle%></td>
                      </tr>
                      <tr>
                        <td class="genBFont">From</td>
                        <td width="15%"><input  class="inputField" name="fromDate" type="text"  id="dc1" readonly="" />                        </td>
                        <td width="70%"><input type="button" name="Submit2" value="V"  class="btnSmallFormat"  onClick="popFrame.fPopCalendar('dc1','dc1',event);"/></td>
                      </tr>
                      <tr>
                        <td><span class="genBFont">To</span></td> 
                        <td><input name="toDate" type="text" id="dc2" readonly=""  class="inputField" /></td>
                        <td><input type="button" name="Submit3" value="V" class="btnSmallFormat"   onClick="popFrame.fPopCalendar('dc2','dc2',event);"/></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="genBFont">Select Diseases </td>
                        <td colspan="2"><select name="diseaseList" size="15" multiple="multiple" id="diseaseList">
                            <%
                              Mapping map = null;
                               ArrayList disList = new EJBAccessPoint().lookupDiseaseBean().getAllDiseases();
                               Iterator disItr = disList.iterator();
                               while(disItr.hasNext()){
                                   map = (Mapping)disItr.next();
                            %><option value="<%=map.getKey()%>"><%=map.getValue()%></option><%}%>
                        </select></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><input type="submit" name="Submit" value="View" class="btnFormat" /></td>
                      </tr>
                    </table>
                </form></td>
                <td width="1%">&nbsp; </td>
                <td width="0%">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
</table>
    </body>
</html>