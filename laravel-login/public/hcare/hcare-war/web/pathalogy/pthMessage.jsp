<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import="java.io.*"%>
<%@page import="java.util.*"%>
<%@page import="coshms.ejb.emergency.PharmacyRemote"%>
<%@page import="coshms.domain.emergency.Patient"%>
<%@page import="coshms.domain.emergency.PatientTprb"%>
<%@page import="coshms.util.emergency.*"%>
<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Message</title>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0">
        <form action="issueBalanceMedicine.jsp">
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
            <td valign="top"><jsp:include page="menue.html" flush="true"/></td>

            <td valign="top">

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td colspan="3" height="3"></td>
                </tr>
                <tr>
                    <td width="8" ><img src="images/left.gif" height="32" /></td>
                    
            <td width="992" background="images/pixi_bg.gif" class="genArlBFont">Pathology 
              : Message </td>
                    <td width="10"><img src="images/right.gif"  height="32" /></td>
                </tr>
                <tr>
                    <td colspan="3" height="3"></td>
                </tr>
                <tr>
                <td colspan="3">
                <table class="normalBorderTable" width="100%"  cellspacing="0" cellpadding="0">
                    <tr><td align="center">
                        <br>
                        <img src="images/info.gif" width="32" height="32" /><br>
                        
             <!--the work begin-->
			                     <div class="genHeadingFont"><%=request.getParameter ("message")%></div>
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
