/*
 * TakeTPRB.java
 *
 * Created on May 26, 2006, 6:15 PM
 */

package coshms.servlets.emergency;

import coshms.ejb.emergency.RegistrationMedicationRemote;
import coshms.util.EJBAccessPoint;
import coshms.util.emergency.TPRBRecord;
import java.io.*;

import javax.servlet.*;
import javax.servlet.http.*;

/**
 *
 * @author Asif
 * @version
 */
public class TakeTPRB extends HttpServlet {
    
    /** Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
     * @param request servlet request
     * @param response servlet response
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
        
        TPRBRecord tprb=new TPRBRecord();
        
        tprb.setPid(new Integer(request.getParameter("pid")));
        tprb.setEmgEncNo(new Integer(request.getParameter("emgEncNo")));

        tprb.setMinBp(new Integer(request.getParameter("minBp")));
        tprb.setMaxBp(new Integer(request.getParameter("maxBp")));
        tprb.setPulse(new Integer(request.getParameter("pulse")));
        tprb.setTemp(new Integer(request.getParameter("temp")));
        tprb.setRRate(new Integer(request.getParameter("rRate")));
        tprb.setEmpId(new Integer(1));
                        
        RegistrationMedicationRemote regMed= new EJBAccessPoint().lookupRegistrationMedicationBean();
        regMed.setTPRB(tprb);
        
        response.sendRedirect("Info.jsp?msg= TPRB Record Inserted ! ");
        
        out.println("<html>");
        out.println("<head>");
        out.println("<title>Servlet TakeTPRB</title>");
        out.println("</head>");
        out.println("<body>");
        out.println("<h1>Servlet TakeTPRB at " + request.getContextPath () + " TPRB INSERTED </h1>");
        out.println("</body>");
        out.println("</html>");
        
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
