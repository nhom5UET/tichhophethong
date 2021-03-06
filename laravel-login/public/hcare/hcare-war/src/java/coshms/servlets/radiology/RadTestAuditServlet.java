/*
 * RadTestAuditServlet.java
 *
 * Created on June 14, 2006, 6:55 AM
 */

package coshms.servlets.radiology;

import java.util.*;

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
public class RadTestAuditServlet extends HttpServlet {
    
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
            String radAudit=(String)session.getAttribute("radAudit");
            if(radAudit==null){
                AuthenticationRemote aRemote = new coshms.util.administration.LookupService().lookupAuthenticationBean();
                authorized=aRemote.isAuthorized(userId,"radAudit");
                if (authorized){
                    session.setAttribute("radAudit","yes");
                }else if(!authorized){
                    session.setAttribute("radAudit","no");
                    response.sendRedirect("login.jsp");
                }
            }else if(radAudit.equals("no")){
                response.sendRedirect("login.jsp");
            }
        }
        
        
        LookupService lookupService = new LookupService();
        coshms.ejb.radiology.RadiologyRemote radRemoteSB = lookupService.lookupRadiologyBean();
        
        String myDate = "NA";
        int testId = Integer.parseInt(request.getParameter("testId"));
        int testReqId = Integer.parseInt(request.getParameter("testReqId"));
        ArrayList radTestAuditList = radRemoteSB.getRadTestAudit(testId,testReqId);
        Iterator radTestAuditIt = radTestAuditList.iterator();
        
        //if(pthTestAuditIt.hasNext())
        //{
        
        //}
        try {
            RadTestAuditInfo radTestAudit = (RadTestAuditInfo)radTestAuditIt.next();
            Font font8 = FontFactory.getFont(FontFactory.COURIER,14);
            Font font9 = FontFactory.getFont(FontFactory.HELVETICA_BOLD,20,Font.UNDERLINE);
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
            float[] widthin1 = {3f};
            PdfPTable table = new PdfPTable(widthin1);
            
            java.util.Date sampleDate = new java.util.Date();
            
            table.setHorizontalAlignment(Element.ALIGN_CENTER);
            table.getDefaultCell().setBorder(0);
            table.addCell("");
            table.addCell("");
            table.addCell(new Paragraph("\n\n" + "   Department Of Radiology" , fonth));
            table.addCell(" ");
            table.addCell("");
            table.addCell("");
            table.setHorizontalAlignment(Element.ALIGN_CENTER);
            table.addCell(new Paragraph("Test Audit", font9));
            table.addCell("");
            table.addCell("");
            table.addCell(new Paragraph("Audit Date : " + sampleDate.toLocaleString(), font8));
            table.addCell("");
            table.setHorizontalAlignment(Element.ALIGN_CENTER);
            table.addCell("");
            
            document.add(table);
            
            float[] widthss = {8f,8f};
            PdfPTable table2 = new PdfPTable(widthss);
            table2.getDefaultCell().setBorder(0);
            table2.setHorizontalAlignment(Element.ALIGN_JUSTIFIED);
            table2.setTotalWidth(widthp);
            
            table2.addCell(new Paragraph("Test Name  ", font8));
            table2.addCell(new Paragraph(radTestAudit.getTestName(), font8));
            table2.addCell(new Paragraph("Test Request Date ", font8));
            table2.addCell(new Paragraph(radTestAudit.getTestReqTime().toLocaleString(), font8));
            table2.addCell(new Paragraph("Test Requested By " , font8));
            table2.addCell(new Paragraph(radTestAudit.getTestReqBy(), font8));
            table2.addCell(new Paragraph("Test Discount ", font8));
            table2.addCell(new Paragraph(Integer.valueOf(radTestAudit.getDiscount()).toString() + "%", font8));
            table2.addCell(new Paragraph("Test Discounted By ", font8));
            table2.addCell(new Paragraph(radTestAudit.getDiscountBy(), font8));
            table2.addCell(new Paragraph("Test Discounted Date ", font8));
            if(radTestAudit.getDisDate().toString().equals("0002-11-30 00:00:00.0")) {
                table2.addCell(new Paragraph(myDate, font8));
            }else {
                table2.addCell(new Paragraph(radTestAudit.getDisDate().toLocaleString(), font8));
            }
            
            table2.addCell(new Paragraph("Test Fee ", font8));
            if(Integer.valueOf(radTestAudit.getFeeCharge()).toString().equals("0")) {
                table2.addCell(new Paragraph(myDate, font8));
            }else {
                table2.addCell(new Paragraph(Integer.valueOf(radTestAudit.getFeeCharge()).toString(), font8));
            }
            
            
            table2.addCell(new Paragraph("Test Fee Charged Date ", font8));
            if(radTestAudit.getFeeDate().toString().equals("0002-11-30 00:00:00.0")) {
                table2.addCell(new Paragraph(myDate, font8));
            }else {
                table2.addCell(new Paragraph(radTestAudit.getFeeDate().toLocaleString(), font8));
            }
            
            
//                          table2.addCell(new Paragraph("Test Sample ConductedBy", font8));
            //                        table2.addCell(new Paragraph(radTestAudit.getSmapleConductedBy(), font8));
            //                      table2.addCell(new Paragraph("Test Sample Date ", font8));
            //                    table2.addCell(new Paragraph(radTestAudit.getSampleDate().toString(), font8));
            table2.addCell(new Paragraph("Test Conducted By ", font8));
            table2.addCell(new Paragraph(radTestAudit.getResultConductedBy(), font8));
            table2.addCell(new Paragraph("Test Conducted Date ", font8));
            if(radTestAudit.getResultDate().toString().equals("0002-11-30 00:00:00.0")) {
                table2.addCell(new Paragraph(myDate, font8));
            }else {
                table2.addCell(new Paragraph(radTestAudit.getResultDate().toLocaleString(), font8));
            }
            
            //                table2.addCell(new Paragraph("Test Verify By ", font8));
            //                  table2.addCell(new Paragraph(radTestAudit.getResultVerifieddBy(), font8));
            //                  table2.addCell(new Paragraph("Test Verify Date ", font8));
            //                   table2.addCell(new Paragraph(radTestAudit.getResultVerifyDate().toString(), font8));
            
            
            
            table2.setSpacingBefore(50f);
            document.add(table2);
            
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
