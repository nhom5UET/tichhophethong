<%@ page language="java" import="java.sql.*" errorPage="" %>
<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%
                                                String isPreviliged = null;
                                                //char shift = 'M';

                                                // try {
                                                isPreviliged = (String)session.getAttribute("regPatient");

                                                //}catch (Exception ex1) {}

                                                if (isPreviliged == null) {
                                                    response.sendRedirect("login.jsp");
                                                } else if (isPreviliged.equals("no")) {
                                                    response.sendRedirect("login.jsp");
                                                } else if (isPreviliged.equals("yes")) {
                                                %>
                                                <!--?xml version="1.0" encoding="iso-8859-1"?-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Enter Patient ID</title>
        <link href="../images/styles.css" rel="stylesheet" type="text/css" />
		<script language="javascript" src="scripts/PidEdit.js"></script>
    </head>    
    <body topmargin="0" rightmargin="0" leftmargin="0">
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top"><jsp:include page="include/RgMenu.htm" flush="true"/></td>
                <td valign="top">
                    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr><td colspan="3" height="3"></td></tr>
                        <tr>
                            <td width="8" ><img src="../images/left.gif" height="32" /></td>
                            
          <td width="992" background="../images/pixi_bg.gif" class="genArlBFont">Emergency 
            : Registration Module</td>
                            <td width="9"><img src="../images/right.gif"  height="32" /></td>
                        </tr>
                        <tr><td colspan="3" height="3"></td></tr>
                        <!-- main Dept:SubDepartment Name, heading, 3 row completed -->
                        <tr>
                            <td colspan="3">
                                <table width="100%" cellpadding="0"  cellspacing="0" class="normalBorderTable">
                                    <tr>
                                        <td height="60" valign="top" colspan="2"> 
                                            <!-- table for interface heading -->
                                            <table width="80%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="1%">&nbsp;</td>
                                                    <td width="99%">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td height="24"></td>
                                                    <td class="topDotedborder"><div class="genHeadingFont">Update 
                          Patient Information:</div></td>
                                                </tr>
                                            </table>
											
                                            <!-- end of table for interface heading -->
                                        </td>
                                    </tr>
                                    <tr><td width="2%">&nbsp;</td>
                                        
                <td width="96%"><form name="updatePt" method="post" action="Edit.jsp" onsubmit="return validateForm (updatePt);"> 
              <table width="60%" border="0" align="center">
                <tr> 
                  <td colspan="2" ></td>
                </tr>
                <tr> 
                  <td width="23%">&nbsp;</td>
                  <td width="77%">&nbsp;</td>
                </tr>
                <tr>
                  <td class="genFont">Enter Patient ID </td>
                  <td class="genFont"><input name="pid" type="text" class="inputField" size="10" maxlength="10"></td>
                </tr>
                <tr> 
                  <td class="genBFont">&nbsp;</td>
                  <td>&nbsp; </td>
                </tr>
                <tr > 
                  <td></td>
                  <td ><input type="submit" name="Submit" value="Submit" class="btnFormat">
                    <input type="reset" name="Reset" value="Clear"  class="btnFormat"/>
                          <br></td>
                </tr>
              </table>
            </form> </td>
                <td width="2%">&nbsp;</td>
                                    </tr>
                                    <tr> 
                                        <td colspan="3">&nbsp; </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
<%}%>