/*
 * PthTestResultAddServlet.java
 *
 * Created on May 14, 2006, 6:53 AM
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
public class PthTestResultAddServlet extends HttpServlet {
    
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
        
          java.util.ArrayList pthTestResList = new java.util.ArrayList();
        
        String[] result = request.getParameterValues("result");
        String[] cNotes = request.getParameterValues("cNotes");
        String[] cid = request.getParameterValues("cid");
        
        for(int i=0; i<cid.length; i++)
        {
        out.println(result[i]);
        out.println(cNotes[i]);
        out.println(cid[i]);
        out.println(request.getParameter("sid"));
        
           PthTestContentsInfo pthTestDisInfo = new PthTestContentsInfo(Integer.parseInt(cid[i]),Double.parseDouble(result[i]),cNotes[i]);
           pthTestResList.add(pthTestDisInfo);
        
        }
        int empId = 1;  
        
        if(pthRemoteSB.PthTestResultAdd(Integer.parseInt(request.getParameter("sid")),empId,pthTestResList))
        response.sendRedirect("pthMessage.jsp?message=Pathalogy Test Result Submit Successfully");
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
