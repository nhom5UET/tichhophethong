<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Emergecy Home </title>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
    </head>    
    <body topmargin="0" rightmargin="0" leftmargin="0">
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top"><jsp:include page="homeMenue.html" flush="true"/></td>
                <td valign="top">
                    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr><td colspan="3" height="3"></td></tr>
                        <tr>
                            <td width="8" ><img src="images/left.gif" height="32" /></td>
                            
          <td width="992" background="images/pixi_bg.gif" class="genArlBFont">Emergency 
            :: Reports</td>
                            <td width="9"><img src="images/right.gif"  height="32" /></td>
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
                                                    <td class="topDotedborder"><div class="genHeadingFont">Basic 
                          Reports of Emergency Department</div></td>
                                                </tr>
                                            </table>
											
                                            <!-- end of table for interface heading -->
                                        </td>
                                    </tr>
                                    <tr><td width="99%"><br />
                                        <br /><form method="post" action="ViewReport">
                    <table width="100%" border="0" align="center" cellpadding="3" cellspacing="3">
                      <tr> </tr>
                      <tr> </tr>
                      <tr> 
                        <td width="3%"><input name="report" type="radio" value="1" checked="checked" /></td>
                        <td width="97%">Total Patient Registered</td>
                      </tr>
                      <tr> 
                        <td><input type="radio" name="report" value="2" /></td>
                        <td>Number of Emergency Patients Encountered</td>
                      </tr>
                      <tr> 
                        <td><input type="radio" name="report" value="3" /></td>
                        <td>Total Medical Legal Cases (MLC) in Emergency Department 
                          of each type</td>
                      </tr>
                      <tr> 
                        <td><input type="radio" name="report" value="4" /></td>
                        <td>Patient Registered from Each City</td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                        <td>From: 
                          <input name="fromDate" type="text" id="fromDate" />
                          To: 
                          <input name="toDate" type="text" id="toDate" /> <input type="submit" name="Submit" value="View" /></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
				  </form>
                  <br />
                                        <h1>&nbsp;</h1></td>
                                        
                <td width="1%">&nbsp; </td>
                <td width="0%">&nbsp;</td>
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