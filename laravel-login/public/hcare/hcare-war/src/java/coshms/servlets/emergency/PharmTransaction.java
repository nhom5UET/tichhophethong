/*
 * PharmTransaction.java
 *
 * Created on May 14, 2006, 5:32 PM
 */

package coshms.servlets.emergency;

import coshms.ejb.emergency.PharmacyRemote;
import coshms.util.emergency.LookupService;
import java.io.*;
import java.net.*;

import javax.servlet.*;
import javax.servlet.http.*;

/**
 *
 * @author Tahir
 * @version
 */
public class PharmTransaction extends HttpServlet
{    
    /** Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
     * @param request servlet request
     * @param response servlet response
     */
    protected void processRequest (HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException
    {
        LookupService lookupService = new LookupService ();
     
        int empId =     Integer.parseInt (request.getParameter ("empId") );
        char shift =    request.getParameter ("shift").charAt (0);
        int updQty =    Integer.parseInt (request.getParameter ("updQty"));
        String mCode =  request.getParameter ("mCode");
        
        try
        {
            PharmacyRemote remote = lookupService.lookupPharmacyBean ();
            remote.setPhramacyTransac (empId , shift ,  mCode , updQty);
        }
        catch (Exception e)
        {
        response.sendRedirect ("confirmation.jsp?msg=Error has occured"); 
        }
        response.sendRedirect ("updatePharmStock.jsp?empId="+empId); 
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