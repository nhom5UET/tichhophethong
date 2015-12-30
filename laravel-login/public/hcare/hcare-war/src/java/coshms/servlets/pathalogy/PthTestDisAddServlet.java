/*
 * PthTestDisAddServlet.java
 *
 * Created on May 12, 2006, 11:36 PM
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
public class PthTestDisAddServlet extends HttpServlet {
    
    /** Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
     * @param request servlet request
     * @param response servlet response
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();

         LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        
        java.util.ArrayList pthTestDisList = new java.util.ArrayList();
        
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
              PthTestDisAddInfo pthTestDisInfo = new PthTestDisAddInfo(Integer.parseInt(testReqIds[i]),Integer.parseInt(testIds[i]),empId,Integer.parseInt(discount[i]));
               pthTestDisList.add(pthTestDisInfo);
                }     
          } // end for
         
         if(pthRemoteSB.addPthTestDiscount(pthTestDisList))
            response.sendRedirect("pthMessage.jsp?message=Pathalogy Test Fee Discounted Successfully");
         else
             response.sendRedirect("pthMessage.jsp?message=Try Again For Discount");
        
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
