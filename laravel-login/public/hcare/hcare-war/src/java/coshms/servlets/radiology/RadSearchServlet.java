/*
 * RadSearchServlet.java
 *
 * Created on June 5, 2006, 10:30 PM
 */

package coshms.servlets.radiology;

import java.io.*;
import java.net.*;

import javax.servlet.*;
import javax.servlet.http.*;

/**
 *
 * @author Administrator
 * @version
 */
public class RadSearchServlet extends HttpServlet {
    
    /** Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
     * @param request servlet request
     * @param response servlet response
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
        String result = request.getParameter("option");
        
        if(result.compareTo("Discount") == 0)
            response.sendRedirect("radTestDiscount.jsp?pid="+ request.getParameter("pid"));
        else if(result.compareTo("Fee") == 0)
            response.sendRedirect("radTestPayment.jsp?pid="+ request.getParameter("pid"));
        else if(result.compareTo("result") == 0)
            response.sendRedirect("radTestResultPending.jsp?pid="+ request.getParameter("pid"));
        else if(result.compareTo("report") == 0)
            response.sendRedirect("radTestReportsList.jsp?pid="+ request.getParameter("pid"));
        else if(result.compareTo("TestAudit") == 0)
            response.sendRedirect("radTestAudit.jsp?pid="+ request.getParameter("pid"));
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
