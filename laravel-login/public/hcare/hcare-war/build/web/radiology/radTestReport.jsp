<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import = "java.util.*"%>
<%@page import = "coshms.util.radiology.*"%>

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
<jsp:useBean id="radData" scope="page" class="coshms.beans.RadAvailableTestsDataBean" />
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Radiology Report Viewer</title>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
    </head>
    <body top>
        <center>
        <img src="images/logo.gif" />

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td colspan="3" height="3"></td>
        </tr>
        <tr>
            <td width="1%" align="right" ><img src="images/left.gif" height="32" /></td>

          <td width="98%" align="center" background="images/pixi_bg.gif" class="genArlBFont">Radiology
            : Report Viewer</td>
            <td width="1%" align="left" ><img src="images/right.gif"  height="32" /></td>
        </tr>
        </table>
        </center>
  <applet code="RadImageViewer.class" width=100% height=100% name="RadiologyViewer" >
  <PARAM NAME = "url" VALUE = "http://localhost:8080/hcare-war/radiology/images/temp.dcm">
  <PARAM NAME = "ptId" VALUE = <%=request.getParameter("pid")%> >
  <PARAM NAME = "ptName" VALUE = <%=radData.getPatientName(Integer.parseInt(request.getParameter("pid")))%> >
  <PARAM NAME = "age" VALUE = <%=request.getParameter("age")%> >
  <PARAM NAME = "testName" VALUE = <%=request.getParameter("testName")%> >
  <PARAM NAME = "empName" VALUE = <%=request.getParameter("empName")%> >
  <PARAM NAME = "resDate" VALUE = <%=request.getParameter("resDate")%> >
   </applet>
        <h3 align="left">Notes : </h3>
   <textarea name="notes" rows="4" cols="80" readonly><%=request.getParameter("notes")%>
   </textarea>
    </body>
</html>
