/*
 * PthTestDomainEditServlet.java
 *
 * Created on May 18, 2006, 3:29 AM
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
public class PthTestDomainEditServlet extends HttpServlet {
    
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
       
        java.util.ArrayList pthTestDomainList = new java.util.ArrayList();
        int tStatus = 0;
        
        if(request.getParameter("status") != null)
        {
        tStatus = 1;
        }
        String[] cid = request.getParameterValues("contentId");
        String[] cname = request.getParameterValues("cname");
        String[] unit = request.getParameterValues("unit");
        String[] minvalue = request.getParameterValues("minvalue");
        String[] maxvalue = request.getParameterValues("maxvalue");
        
        for(int i=0;i<cname.length;i++)
        {
        PthTestContentsInfo pthTestCon = new PthTestContentsInfo("",Integer.parseInt(cid[i]),cname[i],Double.parseDouble(minvalue[i]),Double.parseDouble(maxvalue[i]),unit[i]);
        pthTestDomainList.add(pthTestCon);
        }
        int empId = 1;
       
        if(pthRemoteSB.pthTestDomainEdit(pthTestDomainList,request.getParameter("tname"),tStatus,Integer.parseInt(request.getParameter("tcost")),empId,Integer.parseInt(request.getParameter("testId"))))
        response.sendRedirect("pthMessage.jsp?message=Pathalogy Test Edit Successfully");
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
