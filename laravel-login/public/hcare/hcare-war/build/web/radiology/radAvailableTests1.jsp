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
        <title>JSP Page</title>
        <link href="images/styles.css" rel="stylesheet" type="text/css">
    </head>
    <body>
    <center>
        <form action="RadTestReq" method="POST">
        
        <table class="mainTable">
            <thead class="tableHeader">
                <tr>
                    <th>CURRENTLY AVAILABLE RADIOLOGY TEST LIST</th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                    <td><table border="1" cellspacing="0" cellpadding="0">
                        <thead class="tableHeader2">
                            <tr>
                                <th>TEST NAME</th>
                                <th>RECOMMEND</th>
                                <th>URGENT BASIS</th>
                            </tr>
                        </thead>
                        <tbody>
                            
    <% 
        
    RadAvlTestsInfo radTests;
       ArrayList radTestsList = radData.getRadAvailableTests();
       Iterator radTestsIt = radTestsList.iterator();
       String testId = "";
       while(radTestsIt.hasNext()){
           radTests = (RadAvlTestsInfo)radTestsIt.next();
           testId = Integer.valueOf(radTests.getTestId()).toString();
           
    %>                        
                            <tr>
                                <td><%= radTests.getName() %></td>
                                <td> <input type="checkbox" name="testCB" value= "<%=testId  %>" /></td>
                                <td> <input type="checkbox" name="testUBCB" value= "<%=testId %>" /></td>
                            </tr>
                            <%    }     %>                        
                     
                        </tbody>
                    </table>
                    </td>
                </tr>
                       <tr>
                         <div align="center"><td><input type="submit" value="Request" name="testRequest" class="btnFormat" /></td> </div>
                            </tr>
            </tbody>
        </table>
            </form>
 </center>     
    </body>
</html>
