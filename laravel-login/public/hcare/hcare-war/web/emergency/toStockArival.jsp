
<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import="java.io.*"%>
<%@page import="java.util.*"%>
<%@page import="coshms.ejb.domain.AuthenticationRemote"%>

<%
    //if (session.getAttribute ("login").equals ("no"))
    String authenticated = null;
    int authResult = 0;
    try{
        authResult = Integer.parseInt((String)session.getAttribute("login"));
    }catch (Exception e){}

    if (authResult == 0) 
    {
        response.sendRedirect("login.jsp");
    } else if (authResult > 0) 
    {
        int previlige = 0;
        coshms.util.administration.LookupService lookupService = new coshms.util.administration.LookupService();
        AuthenticationRemote aRemote = lookupService.lookupAuthenticationBean();
        previlige = aRemote.authorizedUser(authResult , "reportPharmInflow");

        if (previlige == 0) {
            session.setAttribute("reportPharmInflow","no");
            response.sendRedirect("login.jsp");
        } else if (previlige > 0) {
            session.setAttribute("reportPharmInflow","yes");
        }
    }

        String empName = null;
        String designation = null;
        String empId = null;
        String login = null;
        String userName = null;

        login = (String)session.getAttribute("login");
        empId = (String)session.getAttribute("empId");
        empName = (String)session.getAttribute("empName");
        designation = (String)session.getAttribute("designation");
        userName = (String)session.getAttribute("userName");

    %>
    <!-- saved from url=(0081)http://webdeveloper.earthweb.com/repository/javascripts/2001/04/39581/PopDemo.htm -->
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
            <title>Stock Arival Report</title>
<link href="images/styles.css" rel="stylesheet" type="text/css" />
    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0">
        <IFRAME 
        id=popFrame 
        style="BORDER-RIGHT: 2px ridge; BORDER-TOP: 2px ridge; Z-INDEX: 65535; VISIBILITY: hidden; BORDER-LEFT: 2px ridge; BORDER-BOTTOM: 2px ridge; POSITION: absolute" 
        name=popFrame 
        src="images/popcjs.htm" 
        frameBorder=0 scrolling=no></IFRAME>
        <SCRIPT>document.onclick=function() {document.getElementById("popFrame").style.visibility="hidden";}</SCRIPT>
        <form  name="stockRemport"  action="stockArival.jsp"  method="post">
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top"><jsp:include page="reportMenue.html" flush="true"/></td>

            
                <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                        <td colspan="4" height="3"></td>
                    </tr>
                    <tr> 
                        <td width="8" rowspan="2" ><img src="images/left.gif" height="32" /></td>
                        <td width="651" rowspan="2" background="images/pixi_bg.gif" class="genArlBFont">Emergency 
                        : Pharmacy Stock Arival </td><%
                        if (userName == null)
                        {
                        userName = "Guest";
                        }
                        %>
                        <td width="323" background="images/pixi_bg.gif"  class="genLoginTag" align="right">Welcome, 
                                                    <%=userName%></td>
                            <td width="11" rowspan="2"><img src="images/right.gif"  height="32" /></td>
                        </tr>
                        <tr>
                        <td  bgcolor="#51A4D8" align="right"> 
                            <%if (empName != null){%>
                            <span class="genLoginTag"><%=empName%> (<%=designation%>) </span>- <a href="Logout" class="small">Logout</a> 
                            <%}%>
                        </td>
                    </tr>
                    <tr> 
                        <td colspan="4" height="3"></td>
                    </tr>
                    <tr> 
                        <td  colspan="4"> <table width="100%"   cellpadding="0"  cellspacing="0" class="normalBorderTable">
                            <tr> 
                                <td height="99" valign="top" align="center"> <table width="70%"  border="0" cellspacing="0" cellpadding="3">
                                    <tr> 
                                        <td  class="genBFont">&nbsp;</td>
                                        <td colspan="2" class="genFrontFont">&nbsp;</td>
                                    </tr>
                                    <tr> 
                                        <td colspan="3"  class="genBFont">Pharmacy Stock Arival</td>
                                    </tr>
                                    <tr> 
                                        <td width="28%" class="genBFont">From</td>
                                        <td width="22%" class="genFrontFont"><input name="fromDate" type="text" class="inputField" id="dc1" size="25" maxlength="20" readonly="" /></td>
                                        <td width="50%" class="genFrontFont"><input name="button" type="button" class="btnSmallFormat" onClick="popFrame.fPopCalendar('dc1','dc1',event);" value=" V " /></td>
                                    </tr>
                                    <tr> 
                                        <td class="genBFont">To</td>
                                        <td class="genFrontFont"><input name="toDate" type="text" class="inputField" id="dc2" size="25" maxlength="20" readonly="" /></td>
                                        <td class="genFrontFont"><input name="button2" type="button" class="btnSmallFormat" onClick="popFrame.fPopCalendar('dc2','dc2',event);" value=" V " /></td>
                                    </tr>
                                    <tr> 
                                        <td class="genBFont">on which Shift </td>
                                        <td colspan="2" class="genFrontFont"><select name="shift"  class="listBox" style="width:198;">
                                            <option value="0"></option>
                                            <option value="M">Morning</option>
                                            <option value="N">Noon</option>
                                            <option value="E">Evening</option>
                                        </select></td>
                                    </tr>
                                    <tr> 
                                        <td class="genBFont">&nbsp;</td>
                                        <td colspan="2" class="genFrontFont"><input type="submit" name="Submit" value="View"  class="btnFormat"/> 
                                        <br> <br></td>
                                    </tr>
                                </table></td>
                            </tr>
                        </table></td>
                    </tr>
                </table></td>
            </tr>
        </table></form>
    </body>
</html>
