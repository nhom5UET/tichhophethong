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
<!-- saved from url=(0081)http://webdeveloper.earthweb.com/repository/javascripts/2001/04/39581/PopDemo.htm -->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Search Patient</title>
        <link href="../images/styles.css" rel="stylesheet" type="text/css" />
		<!--script language="javascript" src="scripts/SearchPt.js"></script-->
    </head>    
    <body topmargin="0" rightmargin="0" leftmargin="0">
	<IFRAME 
id=popFrame 
style="BORDER-RIGHT: 2px ridge; BORDER-TOP: 2px ridge; Z-INDEX: 65535; VISIBILITY: hidden; BORDER-LEFT: 2px ridge; BORDER-BOTTOM: 2px ridge; POSITION: absolute" 
name=popFrame 
src="../images/popcjs.htm" 
frameBorder=0 scrolling=no></IFRAME>
<SCRIPT>document.onclick=function() {document.getElementById("popFrame").style.visibility="hidden";}</SCRIPT>

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
                                                    <td class="topDotedborder"><div class="genHeadingFont">Search 
                          Patient:</div></td>
                                                </tr>
                                            </table>
											
                                            <!-- end of table for interface heading -->
                                        </td>
                                    </tr>
                                    <tr><td width="2%">&nbsp;</td>
                                        
                <td width="96%"><!--onsubmit="return validateForm (SearchPt);"-->
				<form name="SearchPt" method="post" action="SearchPatient" >
                    <table width="80%" border="0" align="center" cellpadding="4" >
                      <tr> 
                        <td colspan="3" ><strong>Enter Known 
                          Facts:</strong></td>
                      </tr>
                      <tr> 
                        <td colspan="3" class="genBFont">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td width="40%" class="genBFont">First Name:</td>
                        <td colspan="2"><input name="firstName" type="text" class="inputField" id="firstName4" size="35" maxlength="20"></td>
                      </tr>
                      <tr> 
                        <td height="24" class="genBFont">Last Name:</td>
                        <td colspan="2"><input name="lastName" type="text" class="inputField" id="lastName" size="35" maxlength="20"></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Father/Husband Name:</td>
                        <td colspan="2"><input name="fatherName" type="text" class="inputField" id="fatherName" size="35" maxlength="20"></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Date of Birth:</td>
                        <td width="33%"><input name="dob" type="text" class="inputField" id=dc1 size="31" maxlength="20"></td>
                        <td width="27%"><INPUT onClick="popFrame.fPopCalendar('dc1','dc1',event);" type=button value=" V " class="btnSmallFormat">      </td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Date of Registration:</td>
                        <td><input name="regDate" type="text" class="inputField" id=dc2 size="31" maxlength="20"></td>
                        <td><INPUT onClick="popFrame.fPopCalendar('dc2','dc2',event);" type=button value=" V " class="btnSmallFormat">      </td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Gender:</td>
                        <td colspan="2">

                                <select name="gender" class="menuFormat">
                          <option value="" selected >Select Gender</option>
                          <option value="M"  >Male</option>
                          <option value="F"  >Female</option>
                        </select>


                        </td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Street Address:</td>
                        <td colspan="2"><input name="streetAddress" type="text" class="inputField" id="firstName422" size="35" maxlength="20"></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">Town:</td>
                        <td colspan="2"><input name="town" type="text" class="inputField" id="town" size="35" maxlength="20"></td>
                      </tr>
                      <tr> 
                        <td class="genBFont">City:</td>
                        <td colspan="2" class="genFont"><select name="city" class="menuFormat">
                          <option value="" selected >Select City</option>
                          <option value="Lahore"  >Lahore</option>
                          <option value="Faisalabad"  >Faisalabad</option>
                          <option value="Kasur"  >Kasur</option>
                          <option value="Islamabad"  >Islamabad</option>
                          <option value="Multan"  >Multan</option>
                        </select></td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td ><div align="right"></div></td>
                        <td colspan="2"><input name="Submit2" type="submit" class="btnFormat" value="Find">
                        <input name="Clear" type="reset" class="btnFormat" value="Clear" /></td>
                      </tr>
                    </table>
            </form></td>
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