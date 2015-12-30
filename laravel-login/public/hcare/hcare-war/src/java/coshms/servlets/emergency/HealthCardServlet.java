/*
 * HealthCardServlet.java
 *
 * Created on July 3, 2006, 2:05 AM
 */

package coshms.servlets.emergency;
/*
 * HealthCardServlet.java
 *
 * Created on 13 October 2005, 21:04
 */


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
import java.awt.Color;
import java.io.*;

import javax.servlet.*;
import javax.servlet.http.*;
import coshms.util.EJBAccessPoint;
import coshms.util.PatientNotFoundException;
import coshms.util.domain.Patient;
/**
 *
 * @author Aden
 * @version
 */
public class HealthCardServlet extends HttpServlet {
    
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        
    }
    
    public void makePdf(HttpServletRequest request, HttpServletResponse response, String methodGetPost)
    throws ServletException, IOException {
        
        String pid = request.getParameter("pid");
        Patient pt = null;
        try {
        pt = new EJBAccessPoint().lookupRegisterPatientBean().getPatient(new Integer(pid));
        }
        catch(Exception e){
            e.printStackTrace();
        }

        try {
            Font font8 = FontFactory.getFont(FontFactory.COURIER,11);
            Font font9 = FontFactory.getFont(FontFactory.COURIER,12,Font.BOLD);
            // step 1
            Rectangle pageSize = new Rectangle(235,151);
            Document document = new Document(pageSize,0,0,0,0);
            
            
            // step 2
            float width = document.getPageSize().width();
            ByteArrayOutputStream baos = new ByteArrayOutputStream();
            PdfWriter writer = PdfWriter.getInstance(document, baos);
            
            // step 3
            document.open();
            String picPath="";
            Image gif2=null;            
            //Fetching Patient Image frm Database
            if(pt.isPicExist()){
                byte by2[] = new byte[pt.getPicSize()];
                by2 = pt.getPicByte();
                java.io.RandomAccessFile file = new java.io.RandomAccessFile(getServletContext().getRealPath("/")+"emergency/images/picture.jpg","rw");
                file.write(by2);
                file.close();
                picPath = getServletContext().getRealPath("/")+"emergency/images/picture.jpg";
                gif2= Image.getInstance(picPath);
            }
            Image gif= Image.getInstance(getServletContext().getRealPath("/")+"emergency/fonts/coshms-card.jpg");
            Image gif1= Image.getInstance(getServletContext().getRealPath("/")+"emergency/fonts/JHL_CARD.jpg");
            
//            String picPath = "images/picture.jpg";
//            Image gif= Image.getInstance("fonts/coshms-card.jpg");
//            Image gif1= Image.getInstance("fonts/JHL_CARD.jpg");
//            Image gif2= Image.getInstance(picPath);
            
            gif1.setAbsolutePosition(0,0);
            gif.setAbsolutePosition(80,100);
            if(pt.isPicExist()){
                gif2.scaleAbsolute(48f,48f);
                //gif2.scalePercent(30,30);
                gif2.setAbsolutePosition(182,70);                
            }
            
            document.add(gif1);
            document.add(gif);
            if(pt.isPicExist()){
                document.add(gif2);
            }
            
//                        float[] widths = {1f,0.6f};
//                        PdfPTable table = new PdfPTable(widths);
//                        table.getDefaultCell().setBorder(0);
//                        table.setHorizontalAlignment(Element.ALIGN_RIGHT);
            
            
            float f = 14f; // first it was 18
            float f1 = 20f;
            PdfContentByte cb = writer.getDirectContent();
            Barcode39 code39 = new Barcode39();
            code39.setBarHeight(f);
            //code39.set
            code39.setGuardBars(true);
            code39.setCode(pt.getPid().toString());
            //code39.setStartStopText(false);
            Image image39 = code39.createImageWithBarcode(cb, null,  Color.BLACK);
            
            
            
            float[] widthin1 = {2f,0.6f};
            PdfPTable table = new PdfPTable(widthin1);
            
            
            table.setHorizontalAlignment(Element.ALIGN_RIGHT);
            table.getDefaultCell().setBorder(0);
            table.addCell("");
            table.addCell(""); 
            table.addCell(new Paragraph("\n\n"+pt.getFirstName() + " " + pt.getLastName(), font9));
            table.addCell("");
            table.addCell(new Paragraph("DoB: "+ pt.getDob().toString(), font8));
            table.addCell("");
            table.addCell(new Paragraph("Reg: "+ pt.getRegDate().toString(), font8));
            table.addCell("");
            table.addCell(new Paragraph(pt.getStreetAddress() + " " + pt.getTown() + " " + pt.getCity(), font8));
            table.addCell("");           

            document.add(table);
            
            
//			table.addCell(new Paragraph("\n\n\n\n"+ ptRegInfo.getFirstName() + " " + ptRegInfo.getLastName(), font9));
//                        table.addCell("");
//                        table.addCell(new Paragraph("DoB: "+ ptRegInfo.getDateOfBirth().toString(), font8));
//                        table.addCell("");
//                        table.addCell(new Paragraph("Reg: " + ptRegInfo.getDateOfReg().toString(), font8));
//                        table.addCell("");
//
//                        table.addCell(new Paragraph( ptRegInfo.getStreetAddress() + " " + ptRegInfo.getTown() + " " + ptRegInfo.getCity(), font8));
//                        table.addCell("");
//                        table.addCell("");
//                        table.addCell("");
//                        table.addCell("");
//                        table.addCell("");
//                        table.addCell("");
//                        table.addCell("");
//                        table.addCell("");
//                        table.addCell("");
//
//                        table.addCell(image39);
//                        table.addCell("");
//                        document.add(table);
            
            
            
            
            image39.setAbsolutePosition(50, 5);
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
    
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        makePdf(request, response, "GET");
    }
    
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        makePdf(request, response, "POST");
    }
    
    public String getServletInfo() {
        return "Short description";
    }
}
