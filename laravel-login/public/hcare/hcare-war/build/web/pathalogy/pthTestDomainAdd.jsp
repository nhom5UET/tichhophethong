<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import = "java.util.*"%>
<%@page import = "coshms.util.pathalogy.*"
import="coshms.ejb.domain.AuthenticationRemote"%>

<%
    int userId = 0;
    boolean authorized = false;
    try{
        userId=Integer.parseInt((String)session.getAttribute("userId"));
    }catch(Exception e){}

    if(userId == 0){
        response.sendRedirect("login.jsp");
    }else if (userId>0){
        String pthAddAndEditTest=(String)session.getAttribute("pthAddAndEditTest");
        if(pthAddAndEditTest==null){
            AuthenticationRemote aRemote = new coshms.util.administration.LookupService().lookupAuthenticationBean();
            authorized=aRemote.isAuthorized(userId,"pthAddAndEditTest");
            if (authorized){
                session.setAttribute("pthAddAndEditTest","yes");
            }else if(!authorized){
                session.setAttribute("pthAddAndEditTest","no");
                response.sendRedirect("login.jsp");
            }
        }else if(pthAddAndEditTest.equals("no")){
            response.sendRedirect("login.jsp");
        }
    }
%>
<jsp:useBean id="pthData" scope="page" class="coshms.beans.PthAvailableTestsDataBean" />
<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Recomend Test</title>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
        <script  type="text/javascript" language="javascript" src="images/dynamic_TestContent.js"></script>
    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0">
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr> 
                <td valign="top"><jsp:include page="menue.html" flush="true"/></td>
                <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                        <td colspan="3" height="3"></td>
                    </tr>
                    <tr> 
                        <td width="8" ><img src="images/left.gif" height="32" /></td>
            
                        <td width="992" background="images/pixi_bg.gif" class="genArlBFont">Pathology 
                        : Test Domain</td>
                        <td width="10"><img src="images/right.gif"  height="32" /></td>
                    </tr>
                    <tr> 
                        <td colspan="3" height="3"></td>
                    </tr>
                    <tr> 
                        <td colspan="3"> <table class="normalBorderTable" width="100%"  cellspacing="0" cellpadding="0">
                            <tr> 
                                <td>
                                    <table width="99%" border="0" cellspacing="2" cellpadding="2">
                                        <tr> 
                                            <td height="25" class="topDotedborder">
                                            <div class="genHeadingFont">Add new Test</div></td>
                                        </tr>
                                        <tr>
                                            <td>
					  
                                                <!------------------>
                                                <form method="POST"   action="PthTestDomainAdd" onSubmit="return validateForm(newTest)" id="newTest">  

                                                    <table width="54%"  cellpadding="1" cellspacing="1" >
                                                        <tr>
                                                            <td width="13%">&nbsp;</td>
                                                            <td width="58%">&nbsp;</td>
                                                            <td width="5%">&nbsp;</td>
                                                            <td width="8%">&nbsp;</td>
                                                            <td width="16%">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="genFont">Test Name</td>
                                                            <td><input name="tname" type="text" class="inputField" size="43" /></td>
                                                            <td><span class="genFont">Cost</span></td>
                                                            <td><input name="tcost" type="text" class="inputField"  maxlength="5" size="6"/></td>
                                                            <td><input type="checkbox" name="status" />
                                                            <span class="genFont">Available</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="genFont">&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp; </td>
                                                        </tr>
                                                        <tr>
                                                            <!-- <td> Test ID  </td> -->
                                                            <td colspan="5"  class="genFont"><table width="100%"  border="0" cellspacing="2" cellpadding="2" id="test">
                                                                <tr>
                                                                    <td class="genBFont">&nbsp;</td>
                                                                    <td><span class="genBFont">Test Contents </span></td>
                                                                    <td>&nbsp;</td>
                                                                    <td>&nbsp;</td>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="genBFont">&nbsp;</td>
                                                                    <td class="genFont">Content Name</td>
                                                                    <td  class="genFont"><div align="center">Min Value </div></td>
                                                                    <td class="genFont"><div align="center">Max Value </div></td>
                                                                    <td class="genFont">Units</td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="3%" class="genBFont">1.</td>
                                                                    <td width="60%"><input name="cname" type="text" class="inputField"  size="50"/></td>
                                                                    <td width="8%"><div align="center">
                                                                        <input name="minvalue" type="text" class="inputField" size="6" maxlength="6"/>
                                                                    </div></td>
                                                                    <td width="8%"><div align="center">
                                                                        <input name="maxvalue" type="text" class="inputField"  size="6" maxlength="6"/>
                                                                    </div></td>
                                                                    <td width="21%"><input name="unit" type="text" class="inputField"  size="6" maxlength="4"/></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5"></td>
                                                                </tr>
                                                            </table>
                                                                <div align="center">
                                                                    <input name="Clear" type="reset" class="btnFormat"   value="Clear"/>
                                                                    <input name="submit2" type="button" class="btnLargeFormat" onClick="addRow('test')"   value="Add Another Content"/>
                                                                    <input name="button" type="submit" class="btnFormat"  value="Done" />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <!-- <td>   <input type="text" name="tid" /></td> -->
                                                            <td colspan="5"> </td>
                                                        </tr>
                                                    </table>
                                                </form>    

                                                <!---------------------------------->
					  
                                            </td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table></td>
                    </tr>
                </table></td>
            </tr>
        </table>
    </body>
</html>
