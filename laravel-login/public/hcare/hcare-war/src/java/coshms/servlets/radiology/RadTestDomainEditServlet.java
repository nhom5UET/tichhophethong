/*
 * RadTestDomainEditServlet.java
 *
 * Created on June 6, 2006, 1:48 AM
 */

package coshms.servlets.radiology;

import java.io.*;
import java.net.*;

import javax.servlet.*;
import javax.servlet.http.*;
import coshms.util.radiology.*;
/**
 *
 * @author Administrator
 * @version
 */
public class RadTestDomainEditServlet extends HttpServlet {
    
    /** Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
     * @param request servlet request
     * @param response servlet response
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
         LookupService lookupService = new LookupService ();
       coshms.ejb.radiology.RadiologyRemote radRemoteSB = lookupService.lookupRadiologyBean();
        
        java.util.ArrayList pthTestDomainList = new java.util.ArrayList();
        int tStatus = 0;
        
        if(request.getParameter("status") != null)
        {
        tStatus = 1;
        }
        int empId = 1;
       
        if(radRemoteSB.radTestDomainEdit(request.getParameter("tname"),tStatus,Integer.parseInt(request.getParameter("tcost")),empId,Integer.parseInt(request.getParameter("testId"))))
        response.sendRedirect("radMessage.jsp?message=Radiology Test Edit Successfully");
        else
        response.sendRedirect("radMessage.jsp?message=Try Again");    
        out.close();
    }
    
    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /** Handles the HTTP <code>GET</code> method.
     * @param request servlet request
     * @param response servlet response
     */
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        processRequest(request, response);
    }
    
    /** Handles the HTTP <code>POST</code> method.
     * @param request servlet request
     * @param response servlet response
     */
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        processRequest(request, response);
    }
    
    /** Returns a short description of the servlet.
     */
    public String getServletInfo() {
        return "Short description";
    }
    // </editor-fold>

  

}
