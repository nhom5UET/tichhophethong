/*
 * PthTestPaymentAddServlet.java
 *
 * Created on May 13, 2006, 7:14 AM
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
public class PthTestPaymentAddServlet extends HttpServlet {
    
    /** Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
     * @param request servlet request
     * @param response servlet response
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
        
          String[] testIds;
          testIds = request.getParameterValues("payStatusCB");
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        
          java.util.ArrayList pthTestPayList = new java.util.ArrayList();
         
         int a =0;
         int z=0;
         String testId = "";
         String testRId  = "";
         int empId = 1;
         
         for(int i =0 ; i<testIds.length;i++)
         {
             a = testIds[i].indexOf('a');
             testId = testIds[i].substring(0, a);
             z = testIds[i].indexOf('z');
             testRId = testIds[i].substring(++a,z);
          
             PthTestAccInfo pthTestAcc = new PthTestAccInfo(Integer.parseInt(testRId),Integer.parseInt(testId),empId);      
             pthTestPayList.add(pthTestAcc);
         }
         
         if(pthRemoteSB.addPthTestPayment(pthTestPayList))
           response.sendRedirect("pthMessage.jsp?message=Pathalogy Test Fee Charge Successfully");
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
