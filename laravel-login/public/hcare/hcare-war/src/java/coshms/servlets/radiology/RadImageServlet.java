/*
 * RadImageServlet.java
 *
 * Created on June 11, 2006, 7:08 AM
 */

package coshms.servlets.radiology;

import java.io.*;
import java.sql.CallableStatement;
import java.sql.Connection;
import java.sql.Blob;
import java.sql.ResultSet;
import java.util.ArrayList;
import java.util.Iterator;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.sql.DataSource;
import org.apache.log4j.Logger;
import org.apache.log4j.BasicConfigurator;
import coshms.util.radiology.*;
/**
 *
 * @author Administrator
 * @version
 */
public class RadImageServlet extends HttpServlet {
    
    /** Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
     * @param request servlet request
     * @param response servlet response
     */
        static Logger logger = Logger.getLogger(RadImageServlet.class);        
        
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        //PrintWriter out = response.getWriter();
          
        int ptId = Integer.parseInt(request.getParameter("ptId"));
        int testId = Integer.parseInt(request.getParameter("testId"));
        int testReqId = Integer.parseInt(request.getParameter("testReqId"));
       
       LookupService lookupService = new LookupService ();
       coshms.ejb.radiology.RadiologyRemote radRemoteSB = lookupService.lookupRadiologyBean();
       logger.info("!!!!!!!!!!!!bt!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " );
        try
        {

        ArrayList imageList  =   radRemoteSB.getRadTestReport(testId,testReqId);
        Iterator imageIt = imageList.iterator();
        
        logger.info("!!!!!!!!!!!!ait!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " );
            // Output the blob to the HttpServletResponse
            //response.setContentType( "image/jpeg" );
            //BufferedOutputStream out = new BufferedOutputStream( response.getOutputStream() );
            
            if(imageIt.hasNext())  {
                RadTestResultInfo radTestRes = (RadTestResultInfo)imageIt.next();
            
            byte by2[] = new byte[ radTestRes.getImageSize()];
            by2 = radTestRes.getBy();
        
            logger.info("!!!!!!!!!!!!aby2!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " );
            //int index = in.read( by, 0, 32768 );
            //logger.info("!!!!!!!!!!!!servlet!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " + Integer.valueOf(by2.length).toString());
            //while ( index != -1 )
            //{
            
            RandomAccessFile f1 = new RandomAccessFile(getServletContext().getRealPath("/")+"radiology/images/temp.dcm","rw");
            f1.write(by2);
            f1.close();

            // out.write( by2, 0, by2.length );
            //out.write( by2);
            //  index = in.read( by, 0, 32768 );
            //}
            //  logger.info("!!!!!!!!!!!!servletar!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " );
            //out.flush();
            //logger.info("!!!!!!!!!!!!servletaf!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " );
            //out.close();
        
            response.sendRedirect("radTestReport.jsp?pid=" + request.getParameter("ptId")+"&testName="+
            radTestRes.getTestName()+"&resDate="+radTestRes.getResDate().toString()+"&empName="+radRemoteSB.getEmployeeName(radTestRes.getEmpId())+"&notes="+radTestRes.getNotes()+"&age="+Integer.valueOf(radRemoteSB.getPatientAge(ptId)).toString());
            }
            
         //}
        
            } catch( IOException e )
                {
                logger.info("!!!!!!!!!!!!servlet ex!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " + e.getMessage());
                //e.printStackTrace();
               // throw new ServletException( e );
                }

        
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
