<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Select Patient to Issue Medicine</title>
        <link href="images/styles.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <center>
            <form action="getTreatments.jsp" method="GET">
                <table width="30%"  border="0" cellspacing="1" cellpadding="1" class="mainTable">
                    <tr>
                        <td colspan="2" align="left" class="tableHeader">Select Patient to Issue Medicine</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="36%"  class="genFont"><div align="center">Enter PID</div></td>
                        <td width="64%" align="left"><input type="text" name="pid" class="inputField"/></td>
                    </tr>
                    <tr>
                    <td colspan="2" align="center"><br>
                    <input type="hidden" name="workForBalanceTransc" value="1"/>
                    <input type="submit" name="Submit" value="Submit" class="btnFormat"></td></tr>
                </table>

            </form>
        </center>
    </body>
</html>
