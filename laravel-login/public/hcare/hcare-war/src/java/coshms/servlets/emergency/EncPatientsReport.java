/*
 * ConsumptionReport.java
 *
 * Created on July 21, 2006, 9:15 AM
 */

package coshms.servlets.emergency;


import javax.servlet.*;
import javax.servlet.http.*;

import java.awt.Graphics2D;
import java.awt.geom.Rectangle2D;

import org.jfree.chart.ChartFactory;
import org.jfree.chart.JFreeChart;
import org.jfree.data.general.DefaultPieDataset;

import com.lowagie.text.Document;
import com.lowagie.text.pdf.DefaultFontMapper;
import com.lowagie.text.pdf.PdfContentByte;
import com.lowagie.text.pdf.PdfTemplate;
import com.lowagie.text.pdf.PdfWriter;
import com.lowagie.text.Rectangle;

import java.sql.Date;
import java.io.*;
import coshms.util.BasicFunction;


import coshms.util.emergency.reports.EncPatients;
import coshms.util.EJBAccessPoint;

/**
 *
 * @author Aden
 * @version
 */
public class EncPatientsReport extends HttpServlet {
    
   
    /** Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
     * @param request servlet request
     * @param response servlet response
     */

        String fromDate = null;
        String toDate = null;
        Date frmDate = null;
        Date tDate = null;
        
    public void convertToPdf(JFreeChart chart, int width, int height, HttpServletRequest request, HttpServletResponse response, String methodGetPost) {
      
        try {  
          
                      
            Document document = new Document(new Rectangle(width, height));
            
            ByteArrayOutputStream baos = new ByteArrayOutputStream();
            PdfWriter writer = PdfWriter.getInstance(document, baos);
            // step 3
            document.open();
            // step 4
            PdfContentByte cb = writer.getDirectContent();
            PdfTemplate tp = cb.createTemplate(width, height);
            Graphics2D g2d = tp.createGraphics(width, height, new DefaultFontMapper());
            Rectangle2D r2d = new Rectangle2D.Double(0, 0, width, height);
            chart.draw(g2d, r2d);
            g2d.dispose();
            cb.addTemplate(tp, 0, 0);
            
            
            
            // step 5
            document.close();
            
            
            //setting some response headers
            response.setHeader("Expires", "0");
            response.setHeader("Cache-Control", "must-revalidate, post-check=0, pre-check=0");
            response.setHeader("Pragma", "public");
            // setting the content type
            response.setContentType("application/pdf");
            // the contentlength is needed for MSIE!!!
            response.setContentLength(baos.size());
            // write ByteArrayOutputStream to the ServletOutputStream
            ServletOutputStream out = response.getOutputStream();
            //out = response.getOutputStream();
            baos.writeTo(out);
            out.flush();
            
        } catch (Exception e2) {
            System.out.println("Error in " + getClass().getName() + "\n" + e2);
        }    
        
        
    }
    
    
    public JFreeChart getBarChart() {
      
        DefaultPieDataset dataset = new DefaultPieDataset();

       try {
           
    EncPatients encPts = new EJBAccessPoint().lookupRepEmgBean().PatientsEncBw(frmDate,tDate);

     
        
       
        dataset.setValue("Males",encPts.getMales());
        dataset.setValue("Females",encPts.getFemales());
            
        } catch (Exception e) {
            System.out.println("Error in " + getClass().getName() + "\n" + e);
        }

        return ChartFactory.createPieChart3D("Emergency Encountered Patients Male & Female \n" + "From: " + fromDate +"   To: " + toDate, dataset,
                                             true, true, false);
        
        
    }
    
    
    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /** Handles the HTTP <code>GET</code> method.
     * @param request servlet request
     * @param response servlet response
     */
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        
        
         fromDate = request.getParameter("fromDate");
         toDate = request.getParameter("toDate");
         
         frmDate = new BasicFunction().strToDate(fromDate);
         tDate = new BasicFunction().strToDate(toDate);
         
        convertToPdf(getBarChart(), 500, 300, request, response, "GET");
    }
    
    /** Handles the HTTP <code>POST</code> method.
     * @param request servlet request
     * @param response servlet response
     */
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        convertToPdf(getBarChart(),500, 300, request, response, "POST");
    }
    
    /** Returns a short description of the servlet.
     */
    public String getServletInfo() {
        return "Short description";
    }
    // </editor-fold>
}
