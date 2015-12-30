/*
 * RadTestResultServlet.java
 *
 * Created on June 6, 2006, 11:17 PM
 */

package coshms.servlets.radiology;

import java.io.*;
import java.net.*;
import java.util.*;
import javax.servlet.*;
import javax.servlet.http.*;

// Import the fileupload classes
import org.apache.commons.fileupload.*;
import coshms.util.radiology.*;
/**
 *
 * @author Administrator
 * @version
 */
public class RadTestResultServlet extends HttpServlet {
    
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
        String fileName  = "";
        String notes = "";
        String testId = "";
        String testReqId = "";
        java.util.ArrayList imageList = new java.util.ArrayList();
        
        try{
            FileUpload fup=new FileUpload();
            boolean isMultipart = FileUpload.isMultipartContent(request);
            System.out.println(isMultipart);
            DiskFileUpload upload = new DiskFileUpload();
            List items = upload.parseRequest(request);
            Iterator iter = items.iterator();
            
            
            while (iter.hasNext()) {                
                FileItem item = (FileItem)iter.next();
                
                if (item.isFormField()) {
                    if(item.getFieldName().equals(new String("notes")))
                        notes = item.getString();
                    if(item.getFieldName().equals(new String("testId")))
                        testId = item.getString();
                    if(item.getFieldName().equals(new String("testReqId")))
                        testReqId = item.getString();
                }else {
                    fileName = item.getName();
                    //out.println(item.getName());
                    RadTestResultInfo radTestRes = new RadTestResultInfo(fileName);
                    imageList.add(radTestRes);
                }
            }
        
       int empId = 1;
        
       if(radRemoteSB.radTestResultAdd(Integer.parseInt(testId),Integer.parseInt(testReqId),empId,notes,imageList))
       response.sendRedirect("radMessage.jsp?message=Radiology Test Result Submitted Successfully");
       else
       response.sendRedirect("radMessage.jsp?message=Try Again " + testId + " " + testReqId); 
        
               } catch(Exception e){
            out.print(e);
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

  

}
