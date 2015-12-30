/*
 * Login.java
 *
 * Created on June 14, 2006, 5:19 PM
 */

package coshms.servlets.pathalogy;

import coshms.util.domain.Employee;
import java.io.*;
import java.net.*;
import java.util.ArrayList;
import java.util.Iterator;

import javax.servlet.*;
import javax.servlet.http.*;

import coshms.ejb.domain.AuthenticationRemote;
import coshms.util.administration.LookupService;

/**
 *
 * @author Tahir
 * @version
 */
public class PthLogin extends HttpServlet {
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        int result = 0;
        String userName = request.getParameter("userName");
        String password = request.getParameter("password");
        
       // System.out.println("USER NAME"+userName+"\n\n\n\nPASSWORD:="+password+" \n\n\n Search FOR" + request.getParameter("searchFor"));
        
        ArrayList list = new ArrayList();
        HttpSession session = request.getSession();
        
        LookupService lookupService = new LookupService();
        AuthenticationRemote remote = lookupService.lookupAuthenticationBean();
        result = remote.authenticatUser(userName , password);
        
        if (result > 0) {
            session.setAttribute("userId", Integer.toString(result));
            list = remote.getEmployeeLoginTag(result);
            Iterator itr = list.iterator();
            System.out.println(itr.hasNext());
            
            Employee employee = new Employee();
            employee = (Employee)itr.next();
            session.setAttribute("empId",String.valueOf(employee.getEmpId()));
            session.setAttribute("empName",employee.getEmployeeName());
            session.setAttribute("designation",employee.getDesignation());
            session.setAttribute("userName",userName);
            
            response.sendRedirect("index.jsp");
        } else if (result == 0) {
            session.setAttribute("login", Integer.toString(0));
            response.sendRedirect("login.jsp");
        }
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
