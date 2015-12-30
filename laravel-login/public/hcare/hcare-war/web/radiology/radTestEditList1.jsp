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
        <form  method="POST">
        
        <table class="mainTable">
            <thead class="tableHeader">
                <tr>
                    <th>PATHALOGY TEST LIST</th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                    <td><table border="1" cellspacing="0" cellpadding="0">
                        <thead class="tableHeader2">
                            <tr>
                                <th>TEST NAME</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            
    <% 
        
    RadAvlTestsInfo radTests;
       ArrayList radTestsList = radData.getRadTestAll();
       Iterator radTestsIt = radTestsList.iterator();
       String testId = "";
       while(radTestsIt.hasNext()){
           radTests = (RadAvlTestsInfo)radTestsIt.next();
           testId = Integer.valueOf(radTests.getTestId()).toString();
           
    %>                        
                            <tr>
                                <td><%= radTests.getName() %></td>
                                <td><a href="radTestDomainEdit.jsp?testId=<%=testId %>">Edit This One</a></td>
                            </tr>
                            <%    }     %>                        
                     
                        </tbody>
                    </table>
                    </td>
                </tr>
                       
            </tbody>
        </table>
            </form>
 </center>     
    
    </body>
</html>
