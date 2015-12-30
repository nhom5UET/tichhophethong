/*
 * PthTestSampleAddServlet.java
 *
 * Created on May 13, 2006, 7:34 PM
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
public class PthTestSampleAddServlet extends HttpServlet {
    
    /** Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
     * @param request servlet request
     * @param response servlet response
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
        
        
        int empId = 1;
       LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
          java.util.ArrayList l = new java.util.ArrayList();
        int sampleId =   pthRemoteSB.pthTestSampleAdd(Integer.parseInt(request.getParameter("tRId")),Integer.parseInt(request.getParameter("tId")),empId);
       
         //out.println("Your Sample Id  ");
         //out.println(sampleId);
        
         if(sampleId >= 1)
        response.sendRedirect("PthTestSampleCard?sampleId=" + Integer.valueOf(sampleId).toString() + "&testId=" + request.getParameter("tId") + "&testReqId=" + request.getParameter("tRId"));
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
