/*
 * RadTestFeeAddServlet.java
 *
 * Created on June 5, 2006, 11:51 PM
 */

package coshms.servlets.radiology;

import java.io.*;
import java.net.*;

import javax.servlet.*;
import javax.servlet.http.*;
import coshms.util.radiology.*;
/**
 *
 * @author Administrator
 * @version
 */
public class RadTestFeeAddServlet extends HttpServlet {
    
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
       coshms.ejb.radiology.RadiologyRemote radRemoteSB = lookupService.lookupRadiologyBean();
          java.util.ArrayList radTestPayList = new java.util.ArrayList();
         
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
          
             RadTestAccInfo radTestAcc = new RadTestAccInfo(Integer.parseInt(testRId),Integer.parseInt(testId),empId);      
             radTestPayList.add(radTestAcc);
         }
         
         if(radRemoteSB.addRadTestFee(radTestPayList))
           response.sendRedirect("radMessage.jsp?message=Radiology Test Fee Charge Successfully");
         else
            response.sendRedirect("radMessage.jsp?message=Try Again");        
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
