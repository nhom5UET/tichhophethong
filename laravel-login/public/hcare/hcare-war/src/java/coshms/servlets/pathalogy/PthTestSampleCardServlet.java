/*
 * PthTestSampleCardServlet.java
 *
 * Created on May 20, 2006, 8:33 PM
 */

package coshms.servlets.pathalogy;

import java.io.*;

import javax.servlet.*;
import javax.servlet.http.*;


import com.lowagie.text.Document;
import com.lowagie.text.Element;
import com.lowagie.text.Font;
import com.lowagie.text.FontFactory;
import com.lowagie.text.Image;
import com.lowagie.text.Paragraph;
import com.lowagie.text.Rectangle;
import com.lowagie.text.pdf.Barcode39;
import com.lowagie.text.pdf.PdfContentByte;
import com.lowagie.text.pdf.PdfPTable;
import com.lowagie.text.pdf.PdfWriter;
import coshms.ejb.domain.AuthenticationRemote;
import java.awt.Color;
import coshms.util.pathalogy.*;
/**
 *
 * @author Administrator
 * @version
 */
public class PthTestSampleCardServlet extends HttpServlet {
    
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
            String pthSample=(String)session.getAttribute("pthSample");
            if(pthSample==null){
                AuthenticationRemote aRemote = new coshms.util.administration.LookupService().lookupAuthenticationBean();
                authorized=aRemote.isAuthorized(userId,"pthSample");
                if (authorized){
                    session.setAttribute("pthSample","yes");
                }else if(!authorized){
                    session.setAttribute("pthSample","no");
                    response.sendRedirect("login.jsp");
                }
            }else if(pthSample.equals("no")){
                response.sendRedirect("login.jsp");
            }
        }

        LookupService lookupService = new LookupService();
        coshms.ejb.pathalogy.PathalogyRemote  pthRemoteSB  = lookupService.lookupPathalogyBean();        
        
        int sampleId = Integer.parseInt(request.getParameter("sampleId"));
        int testId = Integer.parseInt(request.getParameter("testId"));
        int testReqId = Integer.parseInt(request.getParameter("testReqId"));
        
        
        String testName = pthRemoteSB.getTestName(testId);
        
        try {
            Font font8 = FontFactory.getFont(FontFactory.COURIER,8);
            Font font9 = FontFactory.getFont(FontFactory.COURIER,10,Font.BOLD);
            // step 1
            Rectangle pageSize = new Rectangle(235,151);
            Document document = new Document(pageSize,0,0,0,0);
            
            
            // step 2
            float width = document.getPageSize().width();
            ByteArrayOutputStream baos = new ByteArrayOutputStream();
            PdfWriter writer = PdfWriter.getInstance(document, baos);
            
            // step 3
            document.open();
            
            float f = 18f;
            float f1 = 20f;
            PdfContentByte cb = writer.getDirectContent();
            Barcode39 code39 = new Barcode39();
            code39.setBarHeight(f);
            //code39.set
            code39.setGuardBars(true);
            code39.setCode(Integer.valueOf(sampleId).toString());
            //code39.setStartStopText(false);
            Image image39 = code39.createImageWithBarcode(cb, null,  Color.BLACK);
            
            
            
            float[] widthin1 = {3f};
            PdfPTable table = new PdfPTable(widthin1);
            
            java.util.Date sampleDate = new java.util.Date();
            
            table.setHorizontalAlignment(Element.ALIGN_CENTER);
            table.getDefaultCell().setBorder(0);
            table.addCell("");
            table.addCell("");
            table.addCell(new Paragraph("\n\n" + "   Department Of Pathalogy" , font9));
            table.addCell("");
            table.setHorizontalAlignment(Element.ALIGN_CENTER);
            table.addCell(new Paragraph(" Test Sample For " + testName, font8));
            table.addCell("");
            table.addCell(new Paragraph("Sample Date : " + sampleDate.toString() , font8));
            table.addCell("");
            table.setHorizontalAlignment(Element.ALIGN_CENTER);
            if(pthRemoteSB.getPthTestIsUrgentBasis(testId,testReqId))
                table.addCell(new Paragraph( "          Test Type : Urgent ", font8));
            else
                table.addCell(new Paragraph( "          Test Type : Regular ", font8));
            table.addCell("");
            
            document.add(table);
            
            image39.setAbsolutePosition(100, 25);
            document.add(image39);
            
            
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
