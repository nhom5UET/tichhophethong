/* RegisterPatient.java
 * Created on May 11, 2006, 11:51 AM */
package coshms.servlets.emergency;

import coshms.ejb.domain.RegisterPatientRemote;
import coshms.util.BasicFunction;
import coshms.util.EJBAccessPoint;
import coshms.util.domain.Patient;
import coshms.util.radiology.RadTestResultInfo;
import org.apache.commons.fileupload.*;
import java.io.*;
import java.util.Iterator;
import java.util.List;

import javax.servlet.*;
import javax.servlet.http.*;

/* @author project
 * @version */
public class RegisterPatient extends HttpServlet {
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        EJBAccessPoint ejbAP = new EJBAccessPoint();
//PrintWriter out = response.getWriter();
        Patient pt = new Patient();
/////////////////////////////////////////////
        String fileName = "";
        try{
            FileUpload fup=new FileUpload();
            boolean isMultipart = FileUpload.isMultipartContent(request);
            DiskFileUpload upload = new DiskFileUpload();
            List items = upload.parseRequest(request);
            Iterator iter = items.iterator();
            while (iter.hasNext()){
                FileItem item = (FileItem)iter.next();
                if (item.isFormField()) {
                    if(item.getFieldName().equals(new String("firstName")))
                        pt.setFirstName(item.getString());
                    if(item.getFieldName().equals(new String("lastName")))
                        pt.setLastName(item.getString());
                    if(item.getFieldName().equals(new String("fatherName")))
                        pt.setFatherName(item.getString());
                    if(item.getFieldName().equals(new String("dob")))
                        pt.setDob(new BasicFunction().strToDate(item.getString()));
                    if(item.getFieldName().equals(new String("gender")))
                        pt.setGender(item.getString());
                    if(item.getFieldName().equals(new String("streetAddress")))
                        pt.setStreetAddress(item.getString());
                    if(item.getFieldName().equals(new String("town")))
                        pt.setTown(item.getString());
                    if(item.getFieldName().equals(new String("city")))
                        pt.setCity(item.getString());
                    if (item.getFieldName().equals(new String("cnic")))
                        pt.setCnic(item.getString());
                }else{                    
                    fileName = item.getName();
                    System.out.println(item.getName());
                    if(fileName.equals("")){
                        pt.setPicExist(false);
                    }else{
                        pt.setPicExist(true);
                        pt.setPicture(new File(fileName));
                    }
                }
            }
        } catch(Exception e){
        }
        
/////////////////////////////////////////////
//        pt.setFirstName(request.getParameter("firstName"));
//        pt.setLastName(request.getParameter("lastName"));
//        pt.setFatherName(request.getParameter("fatherName"));
//        pt.setDob(new BasicFunction().strToDate(request.getParameter("dob")));
//        pt.setGender(request.getParameter("gender"));
//        pt.setStreetAddress(request.getParameter("streetAddress"));
//        pt.setTown(request.getParameter("town"));
//        pt.setCity(request.getParameter("city"));        
        pt.setEmpId(new Integer(1));
        RegisterPatientRemote regPtRem = ejbAP.lookupRegisterPatientBean();
        
        Integer pid = regPtRem.registerPatient(pt);
        response.sendRedirect("PtActions.jsp?pid="+pid.toString());
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