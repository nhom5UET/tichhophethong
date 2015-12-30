<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Message</title>
        <link href="../images/styles.css" rel="stylesheet" type="text/css" />
    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0">
        <form action="issueBalanceMedicine.jsp">
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
            <td valign="top"><jsp:include page="include/RgMenu.htm" flush="true"/></td>

            <td valign="top">

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td colspan="3" height="3"></td>
                </tr>
                <tr>
                    <td width="8" ><img src="../images/left.gif" height="32" /></td>
                    <td width="992" background="../images/pixi_bg.gif" class="genArlBFont">Emergency : Message </td>
                    <td width="10"><img src="../images/right.gif"  height="32" /></td>
                </tr>
                <tr>
                    <td colspan="3" height="3"></td>
                </tr>
                <tr>
                <td colspan="3">
                <table class="normalBorderTable" width="100%"  cellspacing="0" cellpadding="0">
                    <tr><td align="center">
                        <br>
                        <img src="../images/info.gif" width="32" height="32" /><br>
                        
             <!--the work begin-->
                    <div class="genHeadingFont">
					<%  if ( request.getParameter("fileId").equals("-1") )
									{ %> Patient Successfuly Encountered in Emergency <%
									}
									else
									{%>  Patient Successfully Encountered in Emergency <BR/>
									 File Id is :<%=request.getParameter("fileId")%> 
									 
									 <%}%>
					
					</div>
                                            <br><br>
                    </td></tr>
                </table>
                </td>
                </tr>
            </table>

                </td>
            </tr>
        </table>
                        </form>
    </body>
</html>
