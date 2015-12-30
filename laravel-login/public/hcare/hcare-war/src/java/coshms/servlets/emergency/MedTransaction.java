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
public class MedTransaction extends HttpServlet
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
        int workForBalance = 0;
       /*
        response.setContentType ("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter ();
        */
        String[] mCode ;
        String[] issueQty;
        String[] actQty ;
        
        LookupService lookupService = new LookupService ();
        PharmacyRemote remote = lookupService.lookupPharmacyBean ();
        
        pid = Integer.parseInt          (request.getParameter ("pid"));
        emgEncNo = Integer.parseInt     (request.getParameter ("emgEncNo"));
        treatmentNo = Integer.parseInt  (request.getParameter ("treatmentNo"));
        
        mCode = request.getParameterValues ("mCode");
        issueQty = request.getParameterValues ("issueQty");
        actQty = request.getParameterValues ("actQty");
        
        if (mCode != null && issueQty != null && actQty != null)
        {
            if (mCode.length == issueQty.length && issueQty.length == actQty.length)
            {
                for (int i = 0 ; i < mCode.length ; i++)
                {
                    try
                    {
                        if (remote.setMedicineTransac ( pid , emgEncNo , mCode[i].toString () , Integer.parseInt (issueQty[i]) , Integer.parseInt (actQty[i]), empId , shift , treatmentNo , workForBalance))
                        {
                            response.sendRedirect ("confirmation.jsp?msg=Medicine has been issued");
                        }
                        else
                        {
                            response.sendRedirect ("confirmation.jsp?msg=Error: There is a problem regarding your request, Please Enter valid information or try later");
                        }
                                
                    }
                    catch (Exception e)
                    {
                    }
                }
            }
            else
            {
                //response.sendRedirect ("confirmation.jsp?msg=Error: It might possible that you enter invalid information");
            }
        }
        else
        {
        }
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
