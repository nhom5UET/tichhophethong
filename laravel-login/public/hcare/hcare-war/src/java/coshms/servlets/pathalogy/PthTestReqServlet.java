/*
 * PthTestReqServlet.java
 *
 * Created on May 5, 2006, 7:25 PM
 */

package coshms.servlets.pathalogy;

import java.io.*;
import java.net.*;

import javax.servlet.*;
import javax.servlet.http.*;

import java.util.ArrayList;
import java.util.Iterator;


import org.apache.log4j.Logger;
import org.apache.log4j.BasicConfigurator;
import coshms.util.pathalogy.*;
/**
 *
 * @author Administrator
 * @version
 */
public class PthTestReqServlet extends HttpServlet {
    //static Logger logger = Logger.getLogger(PthTestReqServlet.class);        
    String[] testIdsUb;
    /** Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
     * @param request servlet request
     * @param response servlet response
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        
        LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
        try {
        ArrayList pthTestDet = new ArrayList();
        String[] testIds = null;
        boolean ubFlag = false;        
        testIds = request.getParameterValues("testCB");
        int pid = Integer.parseInt(request.getParameter("pid"));
        int emgEncNo = Integer.parseInt(request.getParameter("emgEncNo"));
        
        if(request.getParameterValues("testCB") == null) {
        response.sendRedirect("pathalogy/pthMessage.jsp?message=12No Pathalogy Test Selected For Request");
        }
        
        if(request.getParameterValues("testUBCB") != null) {
        testIdsUb = request.getParameterValues("testUBCB");
        ubFlag = true;
        }
        PthTestReqDetInfo pthReqDet;
        for(int i=0; i< testIds.length; i++)
        {
            if(!ubFlag) {
            pthReqDet = new PthTestReqDetInfo(Integer.parseInt(testIds[i]),false);
            } else {
            pthReqDet = new PthTestReqDetInfo(Integer.parseInt(testIds[i]),isUrgentBasis(Integer.parseInt(testIds[i]),i));
            }
           pthTestDet.add(pthReqDet);
         }
                
//         if(pthRemoteSB.addPthTestRequest(1,1,1, pthTestDet)) //ptId, encNo, empId
        if(pthRemoteSB.addPthTestRequest(pid,emgEncNo,1, pthTestDet)) //ptId, encNo, empId
        response.sendRedirect("pthMessage.jsp?message=Pathalogy Tests Requested Successfully");
        else
        response.sendRedirect("pthMessage.jsp?message=Try Again");
        }catch(Exception ex){
        response.sendRedirect("pthMessage.jsp?message=No Pathalogy Test Selected For Request");
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
