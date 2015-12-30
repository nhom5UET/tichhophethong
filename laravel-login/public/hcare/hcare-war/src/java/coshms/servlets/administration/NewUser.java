/*
 * NewUser.java
 *
 * Created on July 15, 2006, 5:14 PM
 */

package coshms.servlets.administration;


import coshms.util.administration.LookupService;
import java.io.*;
import java.net.*;

import javax.servlet.*;
import javax.servlet.http.*;
import coshms.ejb.domain.AuthenticationRemote;


/**
 *
 * @author Asif
 * @version
 */
public class NewUser extends HttpServlet {
    
    /** Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
     * @param request servlet request
     * @param response servlet response
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException 
    {
/*        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
  */      
        int result;
        
        int empId = Integer.parseInt(request.getParameter("empId"));
        String userName = request.getParameter("userName");
        String password = request.getParameter("password");
        
        LookupService lookupService = new LookupService ();
        AuthenticationRemote remote = lookupService.lookupAuthenticationBean();
        try 
        {
            result = remote.checkUserNameAvailability(empId , userName);
            if (result == 1)
            {
                response.sendRedirect("newUser.jsp?errorId=un");
            }
            else if (result == 0)
            {
               result = remote.checkUserIdDuplication(empId , userName);
               if (result == 1)
               {
                    response.sendRedirect("newUser.jsp?errorId=id");
               }
               else if (result == 0)
               {
                   if (remote.setNewUserAccount(empId , userName , password))
                       response.sendRedirect("accessControl.jsp?userName="+userName);
                    response.sendRedirect("newUser.jsp?errorId=x");
               }
            }
        }
        catch (Exception e)
        {
            
        }
        
        /* TODO output your page here
        out.println("<html>");
        out.println("<head>");
        out.println("<title>Servlet NewUser</title>");
        out.println("</head>");
        out.println("<body>");
        out.println("<h1>Servlet NewUser at " + request.getContextPath () + "</h1>");
        out.println("</body>");
        out.println("</html>");
         */
        //out.close();
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
