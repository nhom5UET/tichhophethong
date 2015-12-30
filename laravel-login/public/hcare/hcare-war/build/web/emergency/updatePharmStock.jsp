<%@page contentType="text/html"%>
<%@page pageEncoding="UTF-8"%>
<%@page import="java.io.*"%>
<%@page import="java.util.*"%>
<%@page import="coshms.ejb.emergency.PharmacyRemote"%>
<%@page import="coshms.domain.emergency.Patient"%>
<%@page import="coshms.domain.emergency.PatientTprb"%>
<%@page import="coshms.ejb.domain.AuthenticationRemote"%>
<%@page import="coshms.util.emergency.MedicineStock"%>

 <%
                                                //if (session.getAttribute ("login").equals ("no"))
                                                String authenticated = null;
                                                int authResult = 0;
                                          //      System.out.println((String)session.getAttribute("login"));
                                                try 
                                                {
                                                    authResult = Integer.parseInt((String)session.getAttribute("login"));
                                                }catch (Exception e){}


                                                if (authResult == 0) {
                                                    //System.out.println(authResult+" ####################");
                                                    response.sendRedirect("login.jsp");
                                                } 
                                                else if (authResult > 0) 
                                                {
                                                    int previlige = 0;
                                                    coshms.util.administration.LookupService lookupService = new coshms.util.administration.LookupService();
                                                    AuthenticationRemote aRemote = lookupService.lookupAuthenticationBean();
                                                    previlige = aRemote.authorizedUser(authResult , "toUpdateStock");

                                                    if (previlige == 0) {
                                                        session.setAttribute("toUpdateStock","no");
                                                        response.sendRedirect("login.jsp");
                                                    } else if (previlige > 0) {
                                                        session.setAttribute("toUpdateStock","yes");
                                                        // response.sendRedirect ("pharmacy.jsp");
                                                    }

                                                
                                                
                                                String isPreviliged = null;
                                                char shift = 'M';
                                                System.out.println(session.getAttribute("empId").toString());
                                                int empId = Integer.parseInt(session.getAttribute("empId").toString());
                                                isPreviliged = (String)session.getAttribute("toUpdateStock");
                                                System.out.println("$$$$$$$$$$$$$$$$$$$"+isPreviliged);
                                                if (isPreviliged == null) {
                                                    response.sendRedirect("login.jsp");
                                                } else if (isPreviliged.equals("no")) {
                                                    response.sendRedirect("login.jsp");
                                                } else if (isPreviliged.equals("yes")) {
                                                    //empId = Integer.parseInt(request.getParameter("empId"));
                                                    coshms.util.emergency.LookupService lookupService1 = new coshms.util.emergency.LookupService();
                                                    PharmacyRemote remote = lookupService1.lookupPharmacyBean();
                                                                                               %>
                                               
                                               
                                               <html>
 <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Update Pharmacy Stock</title>
        <script language="javascript" src="scripts/updatePharmStock.js"></script>
        <link href="images/styles.css" rel="stylesheet" type="text/css" />
    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0">
        <form  name="pharmacyUpdate" action="PharmTransaction" onsubmit="return validateForm (pharmacyUpdate);">
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
                                <td width="992" background="images/pixi_bg.gif" class="genArlBFont">Emergency : Issue Medicine </td>
                                <td width="10"><img src="images/right.gif"  height="32" /></td>
                            </tr>
                            <tr>
                                <td colspan="3" height="3"></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <table class="normalBorderTable" width="100%"  cellspacing="0" cellpadding="0">
                                        <tr><td height="100%" valign="top">
                        
                                           

                                            <table width="100%"  border="0" cellspacing="1" cellpadding="1">
                                                <tr>
                                                    <td colspan="2"  align="left"><span  class="genBFont" >Emp Name: </span><span  class="genFont" ><%=empId%>Ehsan Ali</span></td>
                                                    <td width="12%"  align="right"><span  class="genBFont" >Shift: </span><span  class="genFont" ><%=shift%></span></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" align="center"><span  class="genBFont" >Medicines in stock </span>
                                                        <br>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" align="center">
                                                        <select name="availableStock" size="15" style="width:780;" class="listBox"  onChange="selectMeds();">
                                                            <%
                                                            ArrayList list = new ArrayList();


                                                            try {
                                                                    list = remote.getMedicineInStock(shift);
                                                                    Iterator iterator = list.iterator();
                                                                    Iterator iterator2 = list.iterator();
                                                                    while (iterator.hasNext()) {
                                                                        MedicineStock medicineStock = new MedicineStock();
                                                                        medicineStock = (MedicineStock)iterator.next();%>


                                                                <option value="<%=medicineStock.getMCode ()%>"><%=medicineStock.getName ()%></option>

                                                            
                                                            <%}%>
                                                        </select>
                                                        <%
                                                        while (iterator2.hasNext()) {
                                                        MedicineStock medicineStock = new MedicineStock();
                                                        medicineStock = (MedicineStock)iterator2.next();%>
                                                        <input type="hidden" id="<%=medicineStock.getMCode ()%>"  value="<%=medicineStock.getQty ()%>" />       
                                                                                                                    <%}
                                                            } catch (Exception e) {
                                                            }%>
                                                        
                                                        <!--input name="qty" type="text" id="1" value="sasasas" /-->
                                                                                                                </td>
                                                    </tr>
                                                        <tr>
                                                    <td width="74%"><span  class="genBFont" >          Medicine Name</span></td>
                                                    <td width="14%" align="center"><span  class="genBFont" >Availabe Qty </span></td>
                                                    <td width="12%" align="center"><span  class="genBFont">Update Qty</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        &nbsp;<input type="text" name="mName" class="inputField" size="90" readOnly/>
                                                    </td>
                                                    <td align="center"><input type="text" name="avlQty" class="inputField" size="5"/ readOnly></td>
                                                    <td align="center"><input type="text" name="updQty" class="inputField" size="5"/>
                                                    </td>
                                                    <input type="hidden" name="mCode"/>
                                                    <input type="hidden" name="shift" value = "<%=shift%>"/>
                                                    <input type="hidden" name="empId" value = "<%=empId%>"/>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" align="center"><br>
                                                    <input name="Submit" type="submit"  class="btnLargeFormat" value="    Update    "></td>
                                                </tr>
                                            </table>
        
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
<%}}%>