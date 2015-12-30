/*
 * Treatment.java
 *
 * Created on June 8, 2006, 10:16 PM
 */

package coshms.servlets.emergency;

import coshms.ejb.emergency.RegistrationMedicationRemote;
import coshms.util.EJBAccessPoint;
import coshms.util.emergency.Medicine;
import java.io.*;
import java.util.ArrayList;

import javax.servlet.*;
import javax.servlet.http.*;

/**
 *
 * @author Asif
 * @version
 */

public class Treatment extends HttpServlet {
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        Medicine med = null;
        Integer empId=new Integer(1);
        
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out     =   response.getWriter();
        
        Integer pid         =   new Integer(request.getParameter("pid"));
        Integer emgEncNo    =   new Integer(request.getParameter("emgEncNo"));
        
        String pComplaints  =   request.getParameter("pComplaints");        
        String[] diseaseArr =   request.getParameterValues("pDiagnosis");
        
        String[] medicine   =   request.getParameterValues("medicine");
        String[] timing     =   request.getParameterValues("timing");
        String[] qty        =   request.getParameterValues("qty");
        String[] period     =   request.getParameterValues("period");
        String[] comments   =   request.getParameterValues("comments");
        
        Integer wardNo      =   new Integer(request.getParameter("refer"));
        
        ArrayList medicineList=new ArrayList();
        for(int i=0; i<medicine.length; i++){
            if(medicine[i].equals("0"))
                continue;
            //////////////////////////////////////////////////////
            int j;
//            int ii=i;
            boolean isDuplicate=false;
            for(j=0; j<=i; j++){
                if(i!=j && medicine[j].equals(medicine[i])){
                    //if(i<medicine.length-1){
                      //  i++;
                        isDuplicate = true;
                        break;
                    //}
                }
            }            
            if(isDuplicate)
                continue;
            ///////////////////////
            med = new Medicine();
            med.setMCode(medicine[i]);
            med.setTiming(new Integer(timing[i]));
            med.setQty(new Integer(qty[i]));
            med.setPeriod(new Integer(period[i]));
            med.setComments(comments[i]);
            medicineList.add(med);
        }
        coshms.util.emergency.Treatment treatment = new coshms.util.emergency.Treatment();
        
        treatment.setPid(pid);
        treatment.setEmgEncNo(emgEncNo);
        treatment.setPComplaints(pComplaints);
        treatment.setDCodeArr(diseaseArr);
        treatment.setMedicineList(medicineList);
        treatment.setWardNo(wardNo);
        treatment.setEmpId(empId);
        
        RegistrationMedicationRemote regMed = new EJBAccessPoint().lookupRegistrationMedicationBean();     
        Integer treatmentNo = regMed.performTreatment(treatment);
        
        if(treatmentNo != null){
            response.sendRedirect("ShowTreatmentRecord.jsp?pid="+pid+"&emgEncNo="+emgEncNo+"&treatmentNo="+treatmentNo);            
        }
        
        out.println("<html>");
        out.println("<head>");
        out.println("<title>Servlet Treatment</title>");
        out.println("</head>");
        out.println("<body>");
        out.println(treatmentNo+"Treatment Record could not save");
        
//        out.println("PERIOD:"+ period.length);        
//        out.println("QTY:"+ qty.length);        
//        out.println("COMMENTS:"+ comments.length);  
//        out.println("TIMINGS:"+ timing.length);        
        
//        for(int i=0; i<qty.length; i++){    
//            out.println(qty[i]);
//            if(qty[i].equals(new String(""))){
//                out.println("Empty"); //this work in case of text boxes
//            }
//                
//        }
//                    out.println("<BR>");
//        
//        for(int i=0; i<medicine.length; i++){    
//            out.println(medicine[i]);
//        }
        
        out.println("</body>");
        out.println("</html>");
        
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
