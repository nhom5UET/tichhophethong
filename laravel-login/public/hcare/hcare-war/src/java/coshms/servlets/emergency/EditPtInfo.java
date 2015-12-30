/*
 * EditPtInfo.java
 *
 * Created on May 21, 2006, 12:52 PM
 */

package coshms.servlets.emergency;

import coshms.ejb.domain.RegisterPatientRemote;
import coshms.util.BasicFunction;
import coshms.util.EJBAccessPoint;
import coshms.util.domain.Patient;

import java.io.*;
import java.net.*;

import javax.servlet.*;
import javax.servlet.http.*;

/**
 *
 * @author Asif
 * @version
 */
public class EditPtInfo extends HttpServlet {
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        EJBAccessPoint ejbAP = new EJBAccessPoint(); 
        Patient pt = new Patient();
        pt.setPid(new Integer(request.getParameter("pid")));
        pt.setFirstName(request.getParameter("firstName"));
        pt.setLastName(request.getParameter("lastName"));
        pt.setFatherName(request.getParameter("fatherName"));       
        pt.setDob(new BasicFunction().strToDate(request.getParameter("dob")));
        pt.setGender(request.getParameter("gender"));
        pt.setStreetAddress(request.getParameter("streetAddress"));
        pt.setTown(request.getParameter("town"));
        pt.setCity(request.getParameter("city"));
        pt.setCnic(request.getParameter("cnic"));
        
        pt.setEmpId(new Integer(1));
        RegisterPatientRemote regPtRem = ejbAP.lookupRegisterPatientBean();
        regPtRem.editPtInfo(pt);
        
        response.sendRedirect("PtActions.jsp?pid="+pt.getPid());
//        PrintWriter out = response.getWriter();
        
        
        
//        out.close();
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
