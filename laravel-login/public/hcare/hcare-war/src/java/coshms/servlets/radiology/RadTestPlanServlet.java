/*
 * RadTestPlanServlet.java
 *
 * Created on June 14, 2006, 9:15 AM
 */

package coshms.servlets.radiology;


import javax.servlet.*;
import javax.servlet.http.*;

import com.lowagie.text.Document;
import com.lowagie.text.Element;
import com.lowagie.text.Font;
import com.lowagie.text.FontFactory;
import com.lowagie.text.PageSize;
import com.lowagie.text.Paragraph;
import com.lowagie.text.pdf.PdfPTable;
import com.lowagie.text.pdf.PdfWriter;
import coshms.ejb.domain.AuthenticationRemote;
import java.io.*;

import coshms.util.radiology.*;

/**
 *
 * @author Administrator
 * @version
 */
public class RadTestPlanServlet extends HttpServlet {
    
    /** Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
     * @param request servlet request
     * @param response servlet response
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        HttpSession session = request.getSession();        
        int userId = 0;
        boolean authorized = false;
        try{
            userId=Integer.parseInt((String)session.getAttribute("userId"));
        }catch(Exception e){}
        
        if(userId == 0){
            response.sendRedirect("login.jsp");
        }else if (userId>0){
            String radPlan=(String)session.getAttribute("radPlan");
            if(radPlan==null){
                AuthenticationRemote aRemote = new coshms.util.administration.LookupService().lookupAuthenticationBean();
                authorized=aRemote.isAuthorized(userId,"radPlan");
                if (authorized){
                    session.setAttribute("radPlan","yes");
                }else if(!authorized){
                    session.setAttribute("radPlan","no");
                    response.sendRedirect("login.jsp");
                }
            }else if(radPlan.equals("no")){
                response.sendRedirect("login.jsp");
            }
        }
        
       LookupService lookupService = new LookupService ();
       coshms.ejb.radiology.RadiologyRemote radRemoteSB = lookupService.lookupRadiologyBean();
        
        try {
                       RadTestPlanInfo radTestPlan = (RadTestPlanInfo)radRemoteSB.getRadTestPlan();
                        
                        Font font8 = FontFactory.getFont(FontFactory.COURIER,11);
                        Font font9 = FontFactory.getFont(FontFactory.HELVETICA_BOLD,26,Font.UNDERLINE);
                        Font font10 = FontFactory.getFont(FontFactory.TIMES_BOLD,26);
                        Font font12 = FontFactory.getFont(FontFactory.TIMES_BOLD,18);
                        Font font11 = FontFactory.getFont(FontFactory.TIMES_ROMAN,13);
                        Font fonth = FontFactory.getFont(FontFactory.TIMES_BOLD,30); 
                        
                        
                        // step 1

                         Document document = new Document(PageSize.A4, 0, 0, 20, 20);

                         
			 // step 2
                         float widthp = document.getPageSize().width();
//			 float height = document.getPageSize().height();
			 ByteArrayOutputStream baos = new ByteArrayOutputStream();
			 PdfWriter writer = PdfWriter.getInstance(document, baos);
			
			 // step 3
			 document.open();


                          float[] widths = {8f};
                          PdfPTable table = new PdfPTable(widths);
                          table.getDefaultCell().setBorder(0);
                          table.setHorizontalAlignment(Element.ALIGN_CENTER);
                          table.setTotalWidth(widthp);
                          
                          
                          table.addCell(new Paragraph("DEPARTMENT OF RADIOLOGY", fonth));
			  table.addCell("");
                          table.setHorizontalAlignment(Element.ALIGN_CENTER);
                          table.addCell(new Paragraph("Test Plan", font9));
                          
                          document.add(table);
                          

                          float[] widthss = {10f,10f};
                          PdfPTable table2 = new PdfPTable(widthss);
                          table2.getDefaultCell().setBorder(0);
                          table2.setHorizontalAlignment(Element.ALIGN_JUSTIFIED);
                          table2.setTotalWidth(widthp);
                          
                          java.util.Date sampleDate = new java.util.Date();
                          
                          table2.addCell(new Paragraph("", font8));
                          table2.addCell(new Paragraph("Date : " + sampleDate.toString(), font8));
                          
                          table2.setSpacingBefore(50f);
                          document.add(table2);

                          
                          float[] widthr = {5f,5f};
                          int NumColumns = 6;
                          PdfPTable table3 = new PdfPTable(widthr);
                          table3.getDefaultCell().setBorderWidth(1.1f);
                          table3.getDefaultCell().setPadding(2f);
                          table2.setHorizontalAlignment(Element.ALIGN_JUSTIFIED);
                          table3.setTotalWidth(widthr);
                          
                          
                         
                          table3.addCell(new Paragraph("Test Requested ", font8));
                          table3.addCell(new Paragraph(Integer.valueOf(radTestPlan.getTestRequested()).toString(), font8));
                          table3.addCell(new Paragraph("Urgent Tests ", font8));
                          table3.addCell(new Paragraph(Integer.valueOf(radTestPlan.getUrgentTest()).toString(), font8));
                          table3.addCell(new Paragraph("Regular Tests ", font8));
                          table3.addCell(new Paragraph(Integer.valueOf(radTestPlan.getRegularTest()).toString(), font8));
//                          table3.addCell(new Paragraph("Critical Tests ", font8));
  //                        table3.addCell(new Paragraph(Integer.valueOf(pthTestPlan.getCriticalTest()).toString(), font8));
    //                      table3.addCell(new Paragraph("Sample Collected ", font8));
      //                    table3.addCell(new Paragraph(Integer.valueOf(pthTestPlan.getSampleCollected()).toString(), font8));
                          
                          table3.setSpacingBefore(50f);
                          document.add(table3);
                          
                          
                        
                        //step 5
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
			baos.writeTo(out);
			out.flush();			    
                    

		} catch (Exception e2) {
			System.out.println("Error in " + getClass().getName() + "\n" + e2);
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
