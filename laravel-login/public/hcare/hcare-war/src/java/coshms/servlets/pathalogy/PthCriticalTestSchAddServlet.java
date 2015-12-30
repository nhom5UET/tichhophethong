/*
 * PthCriticalTestSchAddServlet.java
 *
 * Created on May 15, 2006, 9:32 AM
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
public class PthCriticalTestSchAddServlet extends HttpServlet {
    
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
        
        try
        {
//            int year = 106;
  //          int month = 5;
    //        int day = 18;
            
            String tDate = request.getParameter("dateOfApp");
            
            java.sql.Date testDate = getDateFromString(tDate);
            
        int empId = 1;
        PthCriTestSchInfo pthCriticalSch = new PthCriTestSchInfo(Integer.parseInt(request.getParameter("testReqId")),Integer.parseInt(request.getParameter("testId")),testDate,request.getParameter("shift"));
        
        if(pthRemoteSB.pthCriticalTestSchAdd(empId,pthCriticalSch))
        response.sendRedirect("pthMessage.jsp?message=Pathalogy Test Appointment Ok");
        else
        response.sendRedirect("pthMessage.jsp?message=Try Again");

        }catch(Exception ex)
        {
        out.println(ex.getMessage());
        } 
        
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

   
private java.sql.Date getDateFromString(String dob){
        String[] strMonths = {"January","February","March","April","May","June","July","August","September","October","November","December"};
        int i, j=-10;
        for(i=0; i<=11; i++){
            j = dob.indexOf(strMonths[i]);
            if(j>=0)
            {
                j = i;
                break;
            }
        }
        String strDay = dob.substring(0,dob.indexOf( new String("/")));
        String strYear = dob.substring(dob.length()-4, dob.length());
        return new java.sql.Date(Integer.parseInt(strYear)-1900, j, Integer.parseInt(strDay));
    }
    
}
