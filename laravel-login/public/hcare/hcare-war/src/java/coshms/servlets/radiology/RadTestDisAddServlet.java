/*
 * RadTestDisAddServlet.java
 *
 * Created on June 5, 2006, 10:43 PM
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
public class RadTestDisAddServlet extends HttpServlet {
    
    /** Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
     * @param request servlet request
     * @param response servlet response
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
        LookupService lookupService = new LookupService ();
       coshms.ejb.radiology.RadiologyRemote radRemoteSB = lookupService.lookupRadiologyBean();
       
        java.util.ArrayList radTestDisList = new java.util.ArrayList();
        
        int empId = 1;     ///////////////         
        
         String[] testReqIds;
         testReqIds = request.getParameterValues("testReqId");
         String[] testIds;
         testIds = request.getParameterValues("testId");
         String[] discount;
         discount = request.getParameterValues("select");

         int dis = 0; 
         for(int i =0 ; i<testIds.length;i++)
         {
           dis = Integer.parseInt(discount[i]);
           
                if(dis != 0 )
                {
               RadTestDisAddInfo radTestDisInfo = new RadTestDisAddInfo(Integer.parseInt(testReqIds[i]),Integer.parseInt(testIds[i]),empId,Integer.parseInt(discount[i]));
               radTestDisList.add(radTestDisInfo);
                }     
          } // end for
         
         if(radRemoteSB.addRadTestDiscount(radTestDisList))
            response.sendRedirect("radMessage.jsp?message=Radiology Test Fee Discounted Successfully");
         else
             response.sendRedirect("radMessage.jsp?message=Try Again For Radiology Discount");        
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
