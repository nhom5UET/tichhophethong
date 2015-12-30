/*
 * PthTestResultVerifyServlet.java
 *
 * Created on May 19, 2006, 10:05 PM
 */

package coshms.servlets.pathalogy;

import java.io.*;
import java.net.*;

import javax.servlet.*;
import javax.servlet.http.*;
import coshms.util.pathalogy.*;
/**
 *
 * @author Administrator
 * @version
 */
public class PthTestResultVerifyServlet extends HttpServlet {
    
    /** Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
     * @param request servlet request
     * @param response servlet response
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
       
        int empId = 1;
        int testId = Integer.parseInt(request.getParameter("testId"));
        int testReqId = Integer.parseInt(request.getParameter("testReqId"));
        String overAllNotes = request.getParameter("overallNotes");
        
        if(pthRemoteSB.pthResultVerifyAdd(testId,testReqId,overAllNotes,empId))
           response.sendRedirect("pthMessage.jsp?message=Pathalogy Test Verify Successfully");
         else
            response.sendRedirect("pthMessage.jsp?message=Try Again");
        
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
