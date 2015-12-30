/*
 * PthSearchServlet.java
 *
 * Created on May 12, 2006, 6:50 PM
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
public class PthSearchServlet extends HttpServlet {
    
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
        
        String result = request.getParameter("option");
        
        if(result.compareTo("Discount") == 0)
            response.sendRedirect("pthTestDiscount.jsp?pid="+request.getParameter("pid"));
        else if(result.compareTo("Fee") == 0)
            response.sendRedirect("pthTestPayment.jsp?pid="+ request.getParameter("pid"));
        else if(result.compareTo("sample") == 0)
            response.sendRedirect("pthTestSample.jsp?pid="+ request.getParameter("pid"));
        else if(result.compareTo("sampleReject") == 0)
            response.sendRedirect("pthTestSampleReject.jsp?sid="+ request.getParameter("pid"));
        else if(result.compareTo("result") == 0)
            response.sendRedirect("pthTestResult.jsp?sid="+ request.getParameter("pid"));
        else if(result.compareTo("report") == 0)
            response.sendRedirect("pthTestReports.jsp?pid="+ request.getParameter("pid"));
        else if(result.compareTo("TestAppointment") == 0)
            response.sendRedirect("pthCriticalTest.jsp?pid="+ request.getParameter("pid"));
        else if(result.compareTo("TestAudit") == 0)
            response.sendRedirect("pthTestAudit.jsp?pid="+ request.getParameter("pid"));
        
        
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
