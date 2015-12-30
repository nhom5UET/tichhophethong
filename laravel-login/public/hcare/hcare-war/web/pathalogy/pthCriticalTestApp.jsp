<%@page import = "java.util.*"%>
<%@page import = "coshms.util.pathalogy.*"%>
<jsp:useBean id="pthData" scope="page" class="coshms.beans.PthAvailableTestsDataBean" />
<!-- saved from url=(0081)http://webdeveloper.earthweb.com/repository/javascripts/2001/04/39581/PopDemo.htm -->
<html>
 <head>
     <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
     <title>Recomend Test</title>
     <link href="images/styles.css" rel="stylesheet" type="text/css" />
	 <script language="javascript" src="scripts/pthCriticalTestApp.js"></script>
 </head>

    <body topmargin="0" leftmargin="0" rightmargin="0">
	<IFRAME 
id=popFrame 
style="BORDER-RIGHT: 2px ridge; BORDER-TOP: 2px ridge; Z-INDEX: 65535; VISIBILITY: hidden; BORDER-LEFT: 2px ridge; BORDER-BOTTOM: 2px ridge; POSITION: absolute" 
name=popFrame 
src="scripts/popcjs.htm" 
frameBorder=0 scrolling=no></IFRAME>
<SCRIPT>document.onclick=function() {document.getElementById("popFrame").style.visibility="hidden";}</SCRIPT>

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
            : Test Critical</td>
            <td width="10"><img src="images/right.gif"  height="32" /></td>
        </tr>
        <tr> 
            <td colspan="3" height="3"></td>
        </tr>
        <tr> 
          <td colspan="3"> <table class="normalBorderTable" width="100%"  cellspacing="0" cellpadding="0">
              <tr> 
			  <td>
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
                    
                    <tr>
                      <td>
					  
					
					   <form action="PthCriticalTestSchAdd" method="POST" name = "appointment" onsubmit="return validateForm(appointment)">

      
                          <table  cellpadding="5" cellspacing="0">
                            <tr> 
                              <td width="83" class="genBFont">Patient ID</td>
                              <td width="103" class="genFont"><%=request.getParameter("pid")%></td>
                              <td width="104" class="genBFont">Patient Name</td>
                              <td colspan="3" class="genFont"><%=pthData.getPatientName(Integer.parseInt(request.getParameter("pid")))%></td>
                            </tr>
                            <tr> 
                              <td colspan="3" class="genBFont">Test Name</td>
                              <td colspan="2" class="genBFont">Appointment 
                                Date</td>
                              <td width="110" class="genBFont">Time</td>
                            </tr>
                            <tr> 
                              <input type="hidden" name="testId" value=<%=request.getParameter("tid")%> />
                              <input type="hidden" name="testReqId" value=<%=request.getParameter("trid")%> />
                            <tr> 
                              <td colspan="3"><span class="genFont"><%=request.getParameter("tName") %></span> 
                              </td>
                              <td width="156"> <input name="dateOfApp" type="text" class="inputField" size="26" maxlength="15" id=dc1 readOnly>
                              </td>
                              <td width="74"><input name="dt" type=button class="btnSmallFormat" onclick="popFrame.fPopCalendar('dc1','dc1',event);" value=" V " /></td>
                              <td> <select name="shift" class="menuFormat">
                                  <option>morning</option>
                                  <option>evening</option>
                                  <option>night</option>
                                </select> </td>
                            </tr>
                            <tr> 
                              <td colspan="6" align="center"><input type="reset" value="Reset" class="btnFormat"/> 
                                <input type="submit" value="Done"  class="btnFormat"/> 
                                <input name="submit" type="submit"  class="btnFormat" value="Cancel"/> 
                              </td>
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
