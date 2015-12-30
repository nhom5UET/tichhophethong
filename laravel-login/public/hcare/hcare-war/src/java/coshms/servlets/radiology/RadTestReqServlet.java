/*
 * RadTestReqServlet.java
 *
 * Created on June 4, 2006, 10:15 PM
 */

package coshms.servlets.radiology;

import java.io.*;
import java.net.*;

import javax.servlet.*;
import javax.servlet.http.*;

import java.util.ArrayList;
import java.util.Iterator;

import coshms.util.radiology.*;
/**
 *
 * @author Administrator
 * @version
 */
public class RadTestReqServlet extends HttpServlet {
  
    String[] testIdsUb;
    /** Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
     * @param request servlet request
     * @param response servlet response
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
         LookupService lookupService = new LookupService ();
        
         int pid = Integer.parseInt(request.getParameter("pid"));
        int emgEncNo = Integer.parseInt(request.getParameter("emgEncNo"));
        
       coshms.ejb.radiology.RadiologyRemote radRemoteSB = lookupService.lookupRadiologyBean();
        
        try {
        ArrayList radTestDet = new ArrayList();
        String[] testIds = null;
        boolean ubFlag = false;        
        testIds = request.getParameterValues("testCB");

        if(request.getParameterValues("testCB") == null) {
        response.sendRedirect("radMessage.jsp?message=12No Pathalogy Test Selected For Request");
        }
        
        if(request.getParameterValues("testUBCB") != null) {
        testIdsUb = request.getParameterValues("testUBCB");
        ubFlag = true;
        }
        RadTestReqDetInfo radReqDet;
        for(int i=0; i< testIds.length; i++)
        {
            if(!ubFlag) {
            radReqDet = new RadTestReqDetInfo(Integer.parseInt(testIds[i]),false);
            } else {
            radReqDet = new RadTestReqDetInfo(Integer.parseInt(testIds[i]),isUrgentBasis(Integer.parseInt(testIds[i]),i));
            }
           radTestDet.add(radReqDet);
         }
                
         if(radRemoteSB.addRadTestRequest(pid,emgEncNo,1, radTestDet)) //ptId, encNo, empId
        response.sendRedirect("radMessage.jsp?message=Radiology Tests Requested Successfully");
        else
        response.sendRedirect("radMessage.jsp?message=Try Again");
        }catch(Exception ex){
        response.sendRedirect("radMessage.jsp?message=No Radiology Test Selected For Request");
        out.println(ex.getMessage());
        } 
        out.close();
    }

    //////////////////////////////////////////////    
    public boolean isUrgentBasis(int testId,int loc)
    {
        
        for(int i=0; i < testIdsUb.length; i++) {
        if(Integer.parseInt(testIdsUb[i]) == testId) {
                  //logger.info("============================tub=" +  testIdsUb[i] + " tid=" + testId);
        return true;    
        }
        }
        
    return false;
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
