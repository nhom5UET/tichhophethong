<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Login Page</title>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
    </head>
    <body topmargin="0" leftmargin="0" rightmargin="0">
        <!--	onsubmit="return validateForm (login);"-->
        <form action="PthLogin"   name = "login" method="post">
            <table  border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="top"><jsp:include page="menue.html" flush="true"/></td>

                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                            <td colspan="4" height="3"></td>
                        </tr>
                        <tr> 
                            <td width="8" rowspan="2" ><img src="../images/left.gif" height="32" /></td>
                            <td width="710" rowspan="2" background="../images/pixi_bg.gif" class="genArlBFont">Emergency 
                            : Authentication </td>
                            <%/*
                            String empName = null, designation = null, empId = null , login = null, userName = null;
                            login = (String)session.getAttribute("userId");
                            empId = (String)session.getAttribute("empId");
                            empName = (String)session.getAttribute("empName");
                            designation = (String)session.getAttribute("designation");
                            userName = (String)session.getAttribute("userName");
                            if (userName == null) {
                                userName = "Guest";
                            }*/
                            %>
                            <td width="264" background="../images/pixi_bg.gif"  align="right"><div class="genLoginTag">Welcome</div></td>
                            <td width="10" rowspan="2"><img src="../images/right.gif"  height="32" /></td>
                        </tr>
                        <tr>
                            <td height="14" align="right"  bgcolor="#51A4D8"><div class="genLoginTag">
                                
                            </div></td>
                        </tr>
                        <tr> 
                            <td colspan="4" height="4"></td>
                        </tr>
                        <tr> 
                            <td colspan="4"><table class="normalBorderTable" width="100%" cellpadding="0">
                                <tr> 
                                    <td align="center"> 
                                        <!-------working table---------->
                                        <br> <table  width="75%"  cellspacing="2" cellpadding="2">
                                            <tr> 
                                                <td width="34%" class="genFont" align=""> Enter your username 
                                                </td>
                                                <td width="26%"  ><input  class="inputField" name="userName" type="text" size="22"/></td>
                                                <td width="40%" rowspan="3"   valign="top"><img src="../images/keys.jpg"/></td>
                                            </tr>
                                            <tr> 
                                                <td height="100%"  class="genFont"> Enter password </td>
                                                <td height="100%" ><input name="password" class="inputField" type="password" size="22"/></td>
                                            </tr>
                                            <tr> 
                                                <td height="100%"  class="genFont">&nbsp;</td>
                                                <td height="100%"  > <input name="Submit2" type="reset" class="btnFormat" value="Clear" />                                                 
                                                <input name="Submit" type="submit" class="btnFormat" value="Login" /></td>
                                            </tr>
                                        </table>
                                        <br/> 
                                        <!-------end working table---------->
                                    </td>
                                </tr>
                            </table></td>
                        </tr>
                    </table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>