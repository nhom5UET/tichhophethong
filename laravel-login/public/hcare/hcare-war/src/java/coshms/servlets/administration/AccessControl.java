/*
 * AccessControl.java
 *
 * Created on July 15, 2006, 9:49 AM
 */

package coshms.servlets.administration;

import coshms.ejb.domain.AuthenticationRemote;
import coshms.util.administration.LookupService;
import java.io.*;
import java.net.*;

import javax.servlet.*;
import javax.servlet.http.*;


/**
 *
 * @author Asif
 * @version
 */
public class AccessControl extends HttpServlet {
    
    /** Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
     * @param request servlet request
     * @param response servlet response
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        /*
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
        */
        String[] assignedPrev = request.getParameterValues("assigned");
        String[] oldAssigned = request.getParameterValues("oldA");
        
        int empId = Integer.parseInt(request.getParameter("empId"));
        String userName = request.getParameter("userName");
        
        LookupService lookupService = new LookupService ();
        AuthenticationRemote remote = lookupService.lookupAuthenticationBean();
        System.out.println(oldAssigned);
        if (oldAssigned != null)
        {
            for (int count = 0 ; count < oldAssigned.length ; count++)
            {
        
                if (remote.removePrevileges(userName,Integer.parseInt(oldAssigned[count])))
                {
                  System.out.println(oldAssigned[count]+": disassigned<br>");
                //    System.out.println("disassigned");
                    
                }
            }
        }
        else
        {
                    //out.println("err");
        }
        if (assignedPrev != null)
        {
            for (int i = 0 ; i < assignedPrev.length ; i++)
            {
               
                if (remote.assignPrevileges(userName,Integer.parseInt(assignedPrev[i])))
                {
                    System.out.println(assignedPrev[i]+ " :assihned0");
                }
            }
            response.sendRedirect("confirmation.jsp?msg=Previleges has been assigned to "+userName);
        }
        else if (userName != null)
        {
            if (remote.flushAllPrevileges(userName))
            {
                response.sendRedirect("confirmation.jsp?msg=All preveliges has been removed from "+userName);
            }
        }
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
