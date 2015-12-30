/*
 * SearchPatient.java
 *
 * Created on May 22, 2006, 11:46 PM
 */

package coshms.servlets.emergency;

import coshms.ejb.domain.RegisterPatientRemote;
import coshms.util.BasicFunction;
import coshms.util.EJBAccessPoint;
import coshms.util.domain.Patient;
import java.io.*;
import java.util.ArrayList;

import javax.servlet.*;
import javax.servlet.http.*;

/**
 *
 * @author Asif
 * @version
 */

public class SearchPatient extends HttpServlet {
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        EJBAccessPoint ejbAP = new EJBAccessPoint(); 
        Patient pt = new Patient();
        
        if(request.getParameter("firstName").equals(""))
            pt.setFirstName("%");
        else   
            pt.setFirstName(request.getParameter("firstName"));
        
        
        if(request.getParameter("lastName").equals("")) 
            pt.setLastName("%");
        else
            pt.setLastName(request.getParameter("lastName"));
        
                
        if(request.getParameter("fatherName").equals(""))
            pt.setFatherName("%");
        else
            pt.setFatherName(request.getParameter("fatherName"));       
        
        
        if(request.getParameter("dob").equals(""))
            pt.setDob(null);
        else
            pt.setDob(new BasicFunction().strToDate(request.getParameter("dob")));
        
        
        if(request.getParameter("regDate").equals(""))
            pt.setRegDate(null);
        else
            pt.setRegDate(new BasicFunction().strToDate(request.getParameter("regDate")));
        
        
        if(request.getParameter("gender").equals(""))
            pt.setGender("%");
        else
            pt.setGender(request.getParameter("gender"));
        
        
        if(request.getParameter("streetAddress").equals(""))
            pt.setStreetAddress("%");
        else
            pt.setStreetAddress(request.getParameter("streetAddress"));
        
        
        if(request.getParameter("town").equals(""))
            pt.setTown("%");
        else
            pt.setTown(request.getParameter("town"));
        
        
        if(request.getParameter("city").equals(""))
            pt.setCity("%");
        else
            pt.setCity(request.getParameter("city"));
        
        pt.setEmpId(new Integer(1));
        
        RequestDispatcher dispatcher = request.getRequestDispatcher("SearchResults.jsp");
        request.setAttribute("patient",pt);
        dispatcher.forward(request,response);
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
