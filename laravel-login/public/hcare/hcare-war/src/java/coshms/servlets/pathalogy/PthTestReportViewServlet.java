/*
 * PthTestReportViewServlet.java
 *
 * Created on May 19, 2006, 7:54 AM
 */

package coshms.servlets.pathalogy;


import javax.servlet.*;
import javax.servlet.http.*;


import com.lowagie.text.Document;
import com.lowagie.text.Element;
import com.lowagie.text.Font;
import com.lowagie.text.FontFactory;
import com.lowagie.text.Image;
import com.lowagie.text.PageSize;
import com.lowagie.text.Paragraph;
import com.lowagie.text.pdf.Barcode39;
import com.lowagie.text.pdf.PdfContentByte;
import com.lowagie.text.pdf.PdfPTable;
import com.lowagie.text.pdf.PdfWriter;
import coshms.ejb.domain.AuthenticationRemote;
import java.awt.Color;
import java.io.*;
import coshms.util.pathalogy.*;
/**
 *
 * @author Administrator
 * @version
 */
public class PthTestReportViewServlet extends HttpServlet {
    
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
            String pthReports=(String)session.getAttribute("pthReports");
            if(pthReports==null){
                AuthenticationRemote aRemote = new coshms.util.administration.LookupService().lookupAuthenticationBean();
                authorized=aRemote.isAuthorized(userId,"pthReports");
                if (authorized){
                    session.setAttribute("pthReports","yes");
                }else if(!authorized){
                    session.setAttribute("pthReports","no");
                    response.sendRedirect("login.jsp");
                }
            }else if(pthReports.equals("no")){
                response.sendRedirect("login.jsp");
            }
        }
        
        
        
      LookupService lookupService = new LookupService ();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();
        
        try {
                      java.util.ArrayList ResultList = new java.util.ArrayList();
                      java.util.Iterator ResultIt = null;
                        
                        int empId = 1;              
                        int testId = Integer.parseInt(request.getParameter("testId"));
                        int testReqId = Integer.parseInt(request.getParameter("testReqId"));
                        String pid = request.getParameter("pid");
                        int ptId = Integer.parseInt(request.getParameter("pid"));

                        
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

                         float f = 8f;
                         PdfContentByte cb = writer.getDirectContent();
                         Barcode39 code39 = new Barcode39();
                         code39.setBarHeight(f);
                         //code39.setBarWidth(f);
                            //code39.set
                         code39.setGuardBars(true);
                         code39.setCode("991299999");
                         code39.setStartStopText(false);
                         Image image39 = code39.createImageWithBarcode(cb, null,  Color.WHITE);
                         
                          //Image gif= Image.getInstance("C:/JHL_Header copy.jpg");

                          float[] widths = {8f};
                          PdfPTable table = new PdfPTable(widths);
                          table.getDefaultCell().setBorder(0);
                          table.setHorizontalAlignment(Element.ALIGN_CENTER);
                          table.setTotalWidth(widthp);
                          
                          
                          table.addCell(new Paragraph("DEPARTMENT OF PATHOLOGY", fonth));
			  table.addCell("");
                          table.setHorizontalAlignment(Element.ALIGN_CENTER);
                          table.addCell(new Paragraph("Test Report", font9));
                          
                          
//                          float[] width = {8f};
  //                        PdfPTable table1 = new PdfPTable(width);
    //                      table1.getDefaultCell().setBorder(0);
      //                    table1.setHorizontalAlignment(Element.ALIGN_CENTER);
                          
                          //table1.addCell(new Paragraph("Test " + pthRemoteSB.getTestName(testId), font9));
                          
                          //table.setSpacingAfter(30f);
                          
                          document.add(table);
                          
//                          table1.setSpacingBefore(35f);
//                          document.add(table1);

                          float[] widthss = {8f,8f};
                          PdfPTable table2 = new PdfPTable(widthss);
                          table2.getDefaultCell().setBorder(0);
                          //table2.setHorizontalAlignment(Element.ALIGN_JUSTIFIED);
                          table2.setTotalWidth(widthp);
                          
                          
                          
                          
                          table2.addCell(new Paragraph("Test ID: " + testId , font8));
                          table2.addCell("PID: " + pid);
                          //table2.addCell(image39);
                          table2.addCell(new Paragraph("Test Name: " + pthRemoteSB.getTestName(testId), font8));
                          table2.addCell(new Paragraph("Name: " + pthRemoteSB.getPatientName(ptId), font8));
                          table2.addCell(new Paragraph("Test Date: 27-05-2005", font8));
//                          java.sql.Date tem = ptInfo.getDateOfBirth();
//                          int year = tem.getYear();
                          
                            table2.addCell(new Paragraph("Gender: Male", font8));                         
                            table2.addCell(new Paragraph(" ", font8));
                            table2.addCell(new Paragraph("Age: 35", font8));
                          
                        //  table2.addCell(new Paragraph("Referd By :" + pathLabRem.getDrName(Integer.valueOf(Integer.parseInt(testReqId)))+ "/opd-Ent", font8));
                          
                          //table2.addCell("");
                          //table.addCell("20 C Fountains City Lahore");
                          //table2.addCell("");
                          table2.addCell(new Paragraph("Addr: St#1,H#11 Shoukat Caloney Begum Kot Shahdara Lahore", font8));
                          
                          
                          table2.setSpacingBefore(50f);
                          document.add(table2);

                          
                          float[] widthr = {5f,2.5f,2.5f,2.5f,2.5f,5f};
                          int NumColumns = 6;
                          PdfPTable table3 = new PdfPTable(widthr);
                          table3.getDefaultCell().setBorderWidth(1.1f);
                          table3.getDefaultCell().setPadding(2f);
//                   table2.setHorizontalAlignment(Element.ALIGN_JUSTIFIED);
                          table3.setTotalWidth(widthr);
                          
                          
  //         table3.setHeaderRows(1);
                          
                          //table3.addCell(new Paragraph("ID", font8));
                          //table3.addCell("");
                          //table3.addCell(makeCell("Contents"));
                         
                          table3.addCell(new Paragraph("Contents", font8));
                          table3.addCell(new Paragraph("Min Value", font8));
                          table3.addCell(new Paragraph("Max Value", font8));
                          table3.addCell(new Paragraph("Observed Value", font8));
                          table3.addCell(new Paragraph("Units", font8));
                          table3.addCell(new Paragraph("Comments", font8));
                          
                          table3.setSpacingBefore(50f);
                          document.add(table3);
                          
                          
                          
            //             float[] widthr = {5f,2.5f,2.5f,2.5f,2.5f,5f};
            //             int NumColumns = 6;
                         PdfPTable table4 = new PdfPTable(widthr);
                         table4.getDefaultCell().setBorder(0);
                         //table4.getDefaultCell().setPadding(2f);
                         //table2.setHorizontalAlignment(Element.ALIGN_JUSTIFIED);
                          table4.setTotalWidth(widthr);
                          
                          
                          //table3.setHeaderRows(1);
                          
//                          for (int i = 1; i < 4; i++) {
                          
//				if (i % 2 == 1) {
//					table4.getDefaultCell().setGrayFill(0.9f);
//				}
			
                              ResultList = pthRemoteSB.getPthTestConResult(testId,testReqId);
                              ResultIt = ResultList.iterator();  
                              
                                //for (int x = 0; x < NumColumns; x++) {
                                while(ResultIt.hasNext())
                                {
                                        
                                        PthTestContentsInfo pthConRes = (PthTestContentsInfo)ResultIt.next();

                                        table4.addCell(new Paragraph(pthConRes.getName(), font8));
                                        table4.addCell(new Paragraph(Double.valueOf(pthConRes.getMinValue()).toString(), font8));
                                        table4.addCell(new Paragraph(Double.valueOf(pthConRes.getMaxValue()).toString(), font8));
                                        table4.addCell(new Paragraph(Double.valueOf(pthConRes.getContentValue()).toString(), font8));
                                        table4.addCell(new Paragraph(pthConRes.getUnit(), font8));
                                        table4.addCell(new Paragraph(pthConRes.getContentNotes(), font8));

                                        table4.getDefaultCell().setGrayFill(0.9f);
                                }       
				//}
				
//                                if (i % 2 == 1) {
//				table4.getDefaultCell().setGrayFill(0.0f);
//				}
			//}
                          
                          
                        table4.setSpacingBefore(3f);
                        document.add(table4);
                        
                        
                        
                        
                         float[] widthrr = {8f};
                         //int NumColumns = 6;
                         PdfPTable table5 = new PdfPTable(widthrr);
                         table5.getDefaultCell().setBorder(0);
                         //table4.getDefaultCell().setPadding(2f);
                         //table2.setHorizontalAlignment(Element.ALIGN_JUSTIFIED);
                         table5.setTotalWidth(widthrr);
                          
//                         utill.testNotesInfo tNotesInfo =   pathLabRem.getTestNotes(Integer.valueOf(Integer.parseInt(testId)),Integer.valueOf(Integer.parseInt(testReqId)));
                          
                         table5.addCell(new Paragraph("Impression", font10));
                         table5.addCell(new Paragraph(pthRemoteSB.getPthTestOverAllNotes(testId,testReqId), font11));
                	
                         table5.setSpacingBefore(200f);
                         document.add(table5);
                        
                        
                        
                          float[] widthrrr = {2f,2f,2f};
                          //int NumColumns = 6;
                          PdfPTable table6 = new PdfPTable(widthrrr);
                          table6.getDefaultCell().setBorder(0);
                          //table4.getDefaultCell().setPadding(2f);
                         //table2.setHorizontalAlignment(Element.ALIGN_JUSTIFIED);
                          table6.setTotalWidth(widthp);
                          table6.setHorizontalAlignment(Element.ALIGN_RIGHT);
                          //table6.addCell(new Paragraph("Conducted By:", font10));
                          table6.addCell("");
                          //table6.addCell("");
                          table6.addCell("");
                          table6.addCell(new Paragraph("Conducted By:", font12));
                          //table6.addCell("");
                          table6.addCell("\n\n");
                          table6.addCell("");
                          table6.addCell("");
                          table6.addCell("");
                          table6.addCell("");
                          table6.addCell(pthRemoteSB.getEmployeeName(empId));
                	
                          table6.setSpacingBefore(45f);
                          document.add(table6);
                        

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
