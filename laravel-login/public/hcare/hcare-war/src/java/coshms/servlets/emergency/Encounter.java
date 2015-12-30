/*
 * Encounter.java
 *
 * Created on May 20, 2006, 4:49 PM
 */

package coshms.servlets.emergency;

import coshms.ejb.emergency.RegistrationMedicationRemote;
import coshms.util.EJBAccessPoint;
import coshms.util.emergency.EmgEnc;
import java.io.*;

import javax.servlet.*;
import javax.servlet.http.*;

/**
 *
 * @author Asif
 * @version
 */
public class Encounter extends HttpServlet {
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        Integer fileId=null;        
        EmgEnc enc = new EmgEnc();
        
        Integer pid = new Integer(request.getParameter("pid"));
        Integer mlc=new Integer(request.getParameter("MLC"));
        String broughtBy= request.getParameter("broughtBy");    if(broughtBy.equals(""))broughtBy=null;
        String phNo = request.getParameter("phNo");             if(phNo.equals(""))phNo=null;
        String isRefered = request.getParameter("isRefered");
        
        String refGenFileId = "0";
        if(isRefered.equals("1")){
            String refName= request.getParameter("refName");        if(refName.equals(""))refName=null;
            String refNotes = request.getParameter("refNotes");
            String refPhNo = request.getParameter("refPhNo");       if(refPhNo.equals(""))refPhNo=null;
            refGenFileId = request.getParameter("refGenFileId");
            enc.setRefName(refName);
            enc.setRefNotes(refNotes);
            enc.setRefPhNo(refPhNo);
        }
        
        enc.setEmpId(new Integer(1));
        
        enc.setPid(pid);
        enc.setMlc(mlc);
        enc.setBroughtBy(broughtBy);
        enc.setPhNo(phNo);
        
        if(isRefered.equals("0"))
            enc.setIsRefered(new Boolean(false));
        else
            enc.setIsRefered(new Boolean(true));
        
        
        
        EJBAccessPoint ejbAP= new EJBAccessPoint();
        RegistrationMedicationRemote regMedRem = ejbAP.lookupRegistrationMedicationBean();
        
        fileId=new Integer(-1);
        
        if(refGenFileId.equals("1") && enc.getIsRefered().booleanValue()){
            fileId = regMedRem.emgEncounterFileId(enc);} else
                regMedRem.emgEncounter(enc);
        
        response.sendRedirect("EncSuccess.jsp?fileId="+fileId.toString());
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
