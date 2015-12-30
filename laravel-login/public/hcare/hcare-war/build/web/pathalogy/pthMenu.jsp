<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%--
The taglib directive below imports the JSTL library. If you uncomment it,
you must also add the JSTL library to the project. The Add Library... action
on Libraries node in Projects view can be used to add the JSTL 1.1 library.
--%>
<%--
<%@taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%> 
--%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>JSP Page</title>
        <link href="images/styles.css" rel="stylesheet" type="text/css">
    </head>
<body  topmargin="0" rightmargin="0" leftmargin="0" > 

<table width="100%"  border="0" cellspacing="0" cellpadding="0"  height="100%"  bgcolor="#F1F1F1">
<tr>
    <td valign="top">
	<table width="100%"  border="0" cellspacing="0" cellpadding="5" height="281">
        <tr>
          <td>
		  <img src="images/cos-hms.gif" >
		  </td>
        </tr>

        <TR class=hand onmouseover="this.style.backgroundColor='#ffffff'" 
              onclick="location.href='main.jsp';" 
              onmouseout="this.style.backgroundColor='#F1F1F1';">
          <td width="126"  class=topborder ><span class="genFont"><a href="index.jsp.html" target="mainFrame" onClick="top.frames['topFrame'].location.href='homeHeader.html'">Home</a></span></td>
        </tr>

        <TR class=hand onmouseover="this.style.backgroundColor='#ffffff'" 
              onclick="location.href='main.jsp';" 
              onmouseout="this.style.backgroundColor='#F1F1F1';">
          <td height="19"  class=topborder ><span class="genFont"><a href="pthAvailableTests.jsp" target="mainFrame"  >Test Request </a></span></td>
        </tr>

        <TR class=hand onmouseover="this.style.backgroundColor='#ffffff'" 
              onclick="location.href='main.jsp';" 
              onmouseout="this.style.backgroundColor='#F1F1F1';">
          <td height="19"  class=topborder ><span class="genFont">
          <a href="pthSearch.jsp?searchFor=Discount" target="mainFrame" >Discount </a></span></td>
        </tr>

        <TR class=hand onmouseover="this.style.backgroundColor='#ffffff'" 
              onclick="location.href='main.jsp';" 
              onmouseout="this.style.backgroundColor='#F1F1F1';">
          <td height="19"  class=topborder ><span class="genFont">
        <a href="pthSearch.jsp?searchFor=Fee" target="mainFrame" >Fee</span></td>
        </tr>

        <TR class=hand onmouseover="this.style.backgroundColor='#ffffff'" 
              onclick="location.href='main.jsp';" 
              onmouseout="this.style.backgroundColor='#F1F1F1';">
          <td height="19"  class=topborder ><span class="genFont">
          <a href="pthSearch.jsp?searchFor=sample" target="mainFrame" >Sample</span></td>
        </tr>

        <TR class=hand onmouseover="this.style.backgroundColor='#ffffff'" 
              onclick="location.href='main.jsp';" 
              onmouseout="this.style.backgroundColor='#F1F1F1';">
        <td height="19"  class=topborder ><span class="genFont">
        <a href="pthSearch.jsp?searchFor=sampleReject" target="mainFrame" >Sample Reject</span></td>
        </tr>
        
        <TR class=hand onmouseover="this.style.backgroundColor='#ffffff'" 
              onclick="location.href='main.jsp';" 
              onmouseout="this.style.backgroundColor='#F1F1F1';">
        <td height="19"  class=topborder ><span class="genFont">
        <a href="pthSearch.jsp?searchFor=result" target="mainFrame" >Results</span></td>
        </tr>

        <TR class=hand onmouseover="this.style.backgroundColor='#ffffff'" 
              onclick="location.href='main.jsp';" 
              onmouseout="this.style.backgroundColor='#F1F1F1';">
        <td height="19"  class=topborder ><span class="genFont">
        <a href="pthSearch.jsp?searchFor=report" target="mainFrame" >Reports</span></td>
        </tr>

            
        <TR class=hand onmouseover="this.style.backgroundColor='#ffffff'" 
              onclick="location.href='main.jsp';" 
              onmouseout="this.style.backgroundColor='#F1F1F1';">
        <td height="19"  class=topborder ><span class="genFont">
        <a href="pthTestDomainAdd.jsp" target="mainFrame" >Add New Test</span></td>
        </tr>
        
            <TR class=hand onmouseover="this.style.backgroundColor='#ffffff'" 
              onclick="location.href='main.jsp';" 
              onmouseout="this.style.backgroundColor='#F1F1F1';">
        <td height="19"  class=topborder ><span class="genFont">
        <a href="pthTestEditList.jsp" target="mainFrame" >Edit Test</span></td>
        </tr>
            
            <TR class=hand onmouseover="this.style.backgroundColor='#ffffff'" 
              onclick="location.href='main.jsp';" 
              onmouseout="this.style.backgroundColor='#F1F1F1';">
        <td height="19"  class=topborder ><span class="genFont">
        <a href="pthSearch.jsp?searchFor=TestAudit" target="mainFrame" >Test Audit</span></td>
        </tr>

            <TR class=hand onmouseover="this.style.backgroundColor='#ffffff'" 
              onclick="location.href='main.jsp';" 
              onmouseout="this.style.backgroundColor='#F1F1F1';">
        <td height="19"  class=topborder ><span class="genFont">
        <a href="/Pathalogy-WebModule/PthTestPlan" target="mainFrame" >Test Plan</span></td>
        </tr>
            
        <TR class=hand onmouseover="this.style.backgroundColor='#ffffff'" 
              onclick="location.href='main.jsp';" 
              onmouseout="this.style.backgroundColor='#F1F1F1';">
        <td height="19"  class=topborder ><span class="genFont">
        <a href="pthVerifyResult.jsp" target="mainFrame" >Verify Result</span></td>
        </tr>
            
        <TR class=hand onmouseover="this.style.backgroundColor='#ffffff'" 
              onclick="location.href='main.jsp';" 
              onmouseout="this.style.backgroundColor='#F1F1F1';">
        <td height="19"  class=topborder ><span class="genFont">
        <a href="pthSearch.jsp?searchFor=TestAppointment" target="mainFrame" >Test Appointment</span></td>
        </tr>
        
    <tr> 
          <td  class=topborder  colspan="2" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" align="center"><br>
          <br>
          <br>
          <br>
          <br>
          <br>
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center"><img src="images/best_resolution.gif" width="128" height="24"></td>
        </tr>
      </table>

<center>
	  </center>
    </td>
	  
    <td width="1" bgcolor="#999999">

	</td>
  </tr>
</table>
</body>
    
</html>
