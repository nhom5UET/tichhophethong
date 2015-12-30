/*
 * HeaderFooter.java
 *
 * Created on July 22, 2006, 3:54 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.reports;

import com.lowagie.text.Document;
import com.lowagie.text.FontFactory;
import com.lowagie.text.Image;
import com.lowagie.text.PageSize;
import com.lowagie.text.Paragraph;
import com.lowagie.text.Rectangle;
import com.lowagie.text.pdf.PdfPTable;
import com.lowagie.text.pdf.PdfWriter;
import com.lowagie.text.pdf.PdfPageEventHelper;
import com.lowagie.text.ExceptionConverter;
import java.awt.Color;
import java.io.*;

import java.util.Date;

/**
 *
 * @author Aden
 */
public class HeaderFooter extends PdfPageEventHelper{
    
    /** Creates a new instance of HeaderFooter */
    
   
    String imgPath = null;
    String fontPath = null;
    String hostName = null;
    String ipAddr = null;
    
    Document document;
    Rectangle page;
    float widthp;
    ByteArrayOutputStream baos;
    PdfWriter writer; 
    
    public void setImgPath(String img){
        this.imgPath = img;
    }
    
    public void setfontPath(String font){
        this.fontPath = font;
    }
    
    public void sethostName(String hostName){
        this.hostName = hostName;
    }

    public void setipAddr(String ipAddr){
        this.ipAddr = ipAddr;
    }

    
    public HeaderFooter() {
       
             
        try {
            
            document = new Document(PageSize.A4,50,50,50,50);
            page = document.getPageSize();
            widthp = document.getPageSize().width();
            baos = new ByteArrayOutputStream();
            writer = PdfWriter.getInstance(document, baos);
            
            //FontFactory.register(getServletContext().getRealPath("/")+"/emergency/fonts/verdana.ttf");
            
        } catch (Exception e2) {
            System.out.println("Error in " + getClass().getName() + "\n" + e2);
        }
    }
    
    public void onEndPage(PdfWriter writer, Document document) {
        
          Date date = new Date();
        
        try {
            
            Rectangle page = document.getPageSize();
            
            Image logo= Image.getInstance(imgPath);
            logo.setAbsolutePosition(55,779);
            document.add(logo);
            
            
          
            //Header Table
            PdfPTable head = new PdfPTable(1);
            head.getDefaultCell().setBorder(0);
            //head.setTotalWidth(15f);
            
            
            head.addCell(new Paragraph("\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tCOMSATS OpenSource HealthCare\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tManagement System",FontFactory.getFont(fontPath,14)));
            
            
            
            
            head.setTotalWidth(page.width() - document.leftMargin() - document.rightMargin());
            head.writeSelectedRows(0, -1, document.leftMargin(), page.height() - document.topMargin() + head.getTotalHeight(),
                    writer.getDirectContent());
            
            float[] widthn = {1.5f,5f,1.5f,4f};
            PdfPTable foot = new PdfPTable(widthn);
            foot.getDefaultCell().setBorderColor(Color.gray);
            
            foot.addCell(new Paragraph("Report Date:", FontFactory.getFont("verdana", 8,0,Color.gray)));
            foot.addCell(new Paragraph(date.toString(), FontFactory.getFont("verdana", 8,0,Color.gray)));
            foot.addCell(new Paragraph("User Name:", FontFactory.getFont("verdana", 8,0,Color.gray)));
            foot.addCell(new Paragraph("Ashfaq Hussain", FontFactory.getFont("verdana", 8,0,Color.gray)));
            foot.addCell(new Paragraph("Terminal:", FontFactory.getFont("verdana", 8,0,Color.gray)));
            foot.addCell(new Paragraph(hostName, FontFactory.getFont("verdana", 8,0,Color.gray)));
            foot.addCell(new Paragraph("Terminal Addr:", FontFactory.getFont("verdana", 8,0,Color.gray)));
            foot.addCell(new Paragraph(ipAddr, FontFactory.getFont("verdana", 8,0,Color.gray)));
            foot.setTotalWidth(page.width() - document.leftMargin() - document.rightMargin());
            
            foot.setTotalWidth(page.width() - document.leftMargin() - document.rightMargin());
            foot.writeSelectedRows(0, -1, document.leftMargin(), document.bottomMargin(),
                    writer.getDirectContent());
        } catch (Exception e) {
            throw new ExceptionConverter(e);
        }
    }
    
    
    
}
