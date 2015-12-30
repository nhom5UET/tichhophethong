/*
 * MedTransaction.java
 *
 * Created on May 12, 2006, 1:17 PM
 */

package coshms.servlets.emergency;

import java.io.*;
import java.net.*;

import javax.servlet.*;
import javax.servlet.http.*;

import coshms.util.emergency.LookupService;
import coshms.ejb.emergency.PharmacyRemote;

/**
 *
 * @author Tahir
 * @version
 */
public class BalncMedsTransaction extends HttpServlet
{
    
    /** Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
     * @param request servlet request
     * @param response servlet response
     */
    protected void processRequest (HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException
    {        
        char shift = 'M';
        int empId = 1;
        int pid = 0;
        int emgEncNo = 0;
        int treatmentNo = 0;
        int workForBalance = 1;
        
        response.setContentType ("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter ();
       
        String[] mCode ;
        String[] issueQty;
        String[] actQty ;
        String[] acBalncQty;
        
        LookupService lookupService = new LookupService ();
        PharmacyRemote remote = lookupService.lookupPharmacyBean ();
        
        pid = Integer.parseInt          (request.getParameter ("pid"));
        emgEncNo = Integer.parseInt     (request.getParameter ("emgEncNo"));
        treatmentNo = Integer.parseInt  (request.getParameter ("treatmentNo"));
        
        mCode = request.getParameterValues      ("mCode");
        issueQty = request.getParameterValues   ("issueQty");
        acBalncQty = request.getParameterValues ("balncQty");
        
       // out.println ("<html><head><title>Servlet MedTransaction</title></head><body>");
    
        
        if (mCode != null && issueQty != null && acBalncQty != null)
        {
            if (mCode.length == issueQty.length && issueQty.length == acBalncQty.length)
            {
                for (int i = 0 ; i < mCode.length ; i++)
                {
                    try
                    {
                        remote.setMedicineTransac ( pid , emgEncNo , mCode[i].toString () , Integer.parseInt (issueQty[i]) , Integer.parseInt (acBalncQty[i]), empId , shift , treatmentNo , workForBalance);
                        response.sendRedirect ("confirmation.jsp?msg=Medicine in balance has been issued");
                        //out.println ("<h3>PID: "+pid+" EncNo: "+emgEncNo+" mCode: "+mCode[i].toString ()+" issueQty: "+Integer.parseInt (issueQty[i])+" acBalncQty: "+ Integer.parseInt (acBalncQty[i])+" empId: "+empId +" shift: "+ shift+" treatmentNo: "+ treatmentNo+"</h3><br>");   
                    }
                    catch (Exception e)
                    {//out.println (e.toString ());
                    }
                }
            }
            else
            {//   out.println ("ERROR");
                response.sendRedirect ("confirmation.jsp?msg=Error: Medicines can't be issued");
            }
        }
        else
        {  // out.println ("ERROR: ty again");
        }        
       // out.println ("</body>");out.println ("</html>");out.close ();
    }
    
    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /** Handles the HTTP <code>GET</code> method.
     * @param request servlet request
     * @param response servlet response
     */
    protected void doGet (HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException
    {
        processRequest (request, response);
    }
    
    /** Handles the HTTP <code>POST</code> method.
     * @param request servlet request
     * @param response servlet response
     */
    protected void doPost (HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException
    {
        processRequest (request, response);
    }
    
    /** Returns a short description of the servlet.
     */
    public String getServletInfo ()
    {
        return "Short description";
    }
    // </editor-fold>
}
