/*
 * TreatmentReport.java
 *
 * Created on June 29, 2006, 4:19 PM
 */

package coshms.servlets.emergency;


import com.lowagie.text.Document;
import com.lowagie.text.Font;
import com.lowagie.text.FontFactory;
import com.lowagie.text.Image;
import com.lowagie.text.PageSize;
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

import coshms.ejb.emergency.RegistrationMedicationRemote;
import coshms.ejb.domain.EmployeeRemote;
import coshms.ejb.domain.WardRemote;
import coshms.util.BasicFunction;
import coshms.util.EJBAccessPoint;
import coshms.util.domain.Mapping;
import coshms.util.emergency.*;
import java.util.Iterator;
import java.util.ArrayList;
import coshms.util.emergency.Treatment;
import coshms.util.reports.HeaderFooter;
/**
 *
 * @author Aden
 * @version
 */

public class TreatmentReport extends HttpServlet {
    
    
    
    public void makePdf(HttpServletRequest request, HttpServletResponse response, String methodGetPost)
    throws ServletException, IOException {
        try {
            
            
            Integer empId=new Integer(1);
            Integer pid = new Integer(request.getParameter("pid"));
            Integer treatmentNo = new Integer(request.getParameter("treatmentNo"));
            Integer emgEncNo = new Integer(request.getParameter("emgEncNo"));
            
            EJBAccessPoint ejbAP=new EJBAccessPoint();
            RegistrationMedicationRemote regMed=ejbAP.lookupRegistrationMedicationBean();
            EmployeeRemote emp=ejbAP.lookupEmployeeBean();
            WardRemote ward = ejbAP.lookupWardBean();
            
            Patient pt = regMed.getPtForTPRB(pid);
            TPRBRecord tprb=regMed.getLatestTPRB(pid,pt.getEncNo());
            ArrayList dList,mList,wardList; //mList:medicineList, dList:diseaseList
            
            Treatment treatment = ejbAP.lookupRegistrationMedicationBean().getTreatment( pid,emgEncNo,treatmentNo);
            
            
            dList = treatment.getDiseaseList();
            mList = treatment.getMedicineList();
            wardList = ward.getAllWards();
            
            Iterator dItr=dList.iterator(),mItr=mList.iterator(),wardItr=wardList.iterator();
            
            
            
            // step 1
            
            Document document = new Document(PageSize.A4,50,50,50,50);
            Rectangle page = document.getPageSize();
            float widthp = document.getPageSize().width();
            ByteArrayOutputStream baos = new ByteArrayOutputStream();
            PdfWriter writer = PdfWriter.getInstance(document, baos);
            
            String logoimg = (getServletContext().getRealPath("/")+"/emergency/fonts/logo.jpg");
            String fontPath = (getServletContext().getRealPath("/")+"/emergency/fonts/verdana.ttf");
            
            
            String ipAddr = request.getLocalAddr();
            String hostName = request.getLocalName();
            
            
            HeaderFooter headfoot = new HeaderFooter();
            headfoot.setImgPath(logoimg);
             
            headfoot.setfontPath(fontPath);
            headfoot.sethostName(ipAddr);
            headfoot.sethostName(hostName);
            
            // Creating Instance of HeaderFooter Class for setting PageEvent
            writer.setPageEvent(headfoot);
            
            
            // step 3
            document.open();
            
            //Font Registration
            FontFactory.register(fontPath);
            
            
            //BarCode Starts here
            float f = 20f;
            PdfContentByte cb = writer.getDirectContent();
            Barcode39 code39 = new Barcode39();
            code39.setBarHeight(f);
            //code39.set
            code39.setGuardBars(true);
            //code39.setCode(pt.getPid().toString());
            code39.setCode(pt.getPid().toString());
            code39.setStartStopText(false);
            Image image39 = code39.createImageWithBarcode(cb, null,  Color.WHITE);
            
            
            //Barcode Image placement
            image39.setAbsolutePosition(100,725);
            document.add(image39);
       
           
            //Space B/W Header
            
            float[] widthh = {13f};
            PdfPTable tablespace = new PdfPTable(widthh);
            tablespace.getDefaultCell().setBorder(0);
            tablespace.setTotalWidth(widthh);
            //tableh.addCell("\n\n\n\n\n\n\n\n\n");
            
                       
            tablespace.addCell("\n");
            
                                    
            document.add(tablespace);
            
            
            //Patient Header Table
            PdfPTable tableh = new PdfPTable(widthh);
            tableh.getDefaultCell().setBorder(0);
            tableh.setTotalWidth(widthh);
            //tableh.addCell("\n\n\n\n\n\n\n\n\n");
            
            tableh.getDefaultCell().setUseBorderPadding(true);
            tableh.getDefaultCell().setGrayFill(0.93f); 
            
            tableh.addCell(new Paragraph("\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tEmergency Treatment Report", FontFactory.getFont(fontPath, 12,Font.BOLD)));
            
                    
                        
            document.add(tableh);
    
                  
            //Personal Information Table
            float[] widthn = {4.5f,3f,3f,4.5f};
            PdfPTable tablep = new PdfPTable(widthn);
            tablep.getDefaultCell().setBorder(0);
            //tablep.setHorizontalAlignment(Element.ALIGN_CENTER);
            tablep.setTotalWidth(widthn);
           
            
            
            tablep.addCell(new Paragraph("Name:", FontFactory.getFont(fontPath, 9)));
            tablep.addCell(new Paragraph(pt.getName(), FontFactory.getFont(fontPath, 9)));
            tablep.addCell(new Paragraph("\t\t\tPID:", FontFactory.getFont(fontPath, 9)));
            tablep.addCell(new Paragraph("\t\t"+pt.getPid().toString(), FontFactory.getFont(fontPath, 9)));
            tablep.addCell(new Paragraph("Father/Husband Name:", FontFactory.getFont(fontPath, 9)));
            tablep.addCell(new Paragraph(pt.getFatherName(), FontFactory.getFont(fontPath, 9)));
            tablep.addCell(new Paragraph("\t\t\tGender:", FontFactory.getFont(fontPath, 9)));
            tablep.addCell(new Paragraph("\t\t"+pt.getGender(), FontFactory.getFont(fontPath, 9)));
            tablep.addCell(new Paragraph("MLC:", FontFactory.getFont(fontPath, 9)));
            tablep.addCell(new Paragraph(pt.getMlc(), FontFactory.getFont(fontPath, 9)));
            tablep.addCell(new Paragraph("\t\t\tEncounter No:", FontFactory.getFont(fontPath, 9)));
            tablep.addCell(new Paragraph("\t\t"+pt.getEncNo(), FontFactory.getFont(fontPath, 9)));
            tablep.addCell(new Paragraph("Age:", FontFactory.getFont(fontPath, 9)));
            tablep.addCell(new Paragraph(String.valueOf(pt.getAge()), FontFactory.getFont(fontPath, 9)));
            tablep.addCell(new Paragraph("\t\t\tEnc. Date:", FontFactory.getFont(fontPath, 9)));
            tablep.addCell(new Paragraph("\t\t"+pt.getEncDateTime().toLocaleString(), FontFactory.getFont(fontPath, 9)));
            tablep.addCell(new Paragraph("Address:", FontFactory.getFont(fontPath, 9)));
            tablep.addCell(new Paragraph(pt.getAddress(), FontFactory.getFont(fontPath, 9)));
            tablep.addCell("");
            tablep.addCell("");
            tablep.addCell("\n");
            tablep.addCell("\n");
            tablep.addCell("\n");
            tablep.addCell("\n");
            
            
            
            //System.out.println("\n\n\n"+tprb.getMinBp());
            
            tablep.setSpacingBefore(24f);
            document.add(tablep);
           
           
            //Latest TPRB Header Table
            PdfPTable tableT = new PdfPTable(widthh);
            tableT.getDefaultCell().setBorder(0);
            tableT.setTotalWidth(widthh);
            tableT.addCell(new Paragraph("Latest TPRB Record: [At Time: "+tprb.getDTime().toLocaleString()+"]", FontFactory.getFont(fontPath,10,Font.BOLD)));
            tableT.addCell("--------------------------------------------------------------------------------------------");
            
            tableT.setSpacingBefore(1f);
            document.add(tableT);
            
                
            
            //TPRB Record Table
            PdfPTable tableTR = new PdfPTable(widthn);
            tableTR.getDefaultCell().setBorder(0);
            tableTR.setTotalWidth(widthn);
            
            tableTR.addCell(new Paragraph("Blood Pressure (B.P):", FontFactory.getFont(fontPath, 9)));
            tableTR.addCell(new Paragraph(tprb.getMinBp()+"/"+tprb.getMaxBp()+" mmHg", FontFactory.getFont(fontPath, 9,Font.BOLD)));
            tableTR.addCell(new Paragraph("\t\t\t\t\tTemperature: ", FontFactory.getFont(fontPath, 9)));
            tableTR.addCell(new Paragraph(String.valueOf(tprb.getTemp())+" F", FontFactory.getFont(fontPath, 9,Font.BOLD)));
            tableTR.addCell(new Paragraph("Pulse Rate: ", FontFactory.getFont(fontPath, 9)));
            tableTR.addCell(new Paragraph(String.valueOf(tprb.getPulse())+" /Min", FontFactory.getFont(fontPath, 9,Font.BOLD)));
            tableTR.addCell(new Paragraph("\t\t\t\t\tRespiration: ", FontFactory.getFont(fontPath, 9)));
            tableTR.addCell(new Paragraph(String.valueOf(tprb.getRRate())+" /Min", FontFactory.getFont(fontPath, 9,Font.BOLD)));
            tableTR.addCell("\n");
            tableTR.addCell("\n");
            tableTR.addCell("\n");
            tableTR.addCell("\n");
            
            document.add(tableTR);
            
            
            
            //Complaints & Diagnosis Header Table
            PdfPTable tablePC = new PdfPTable(widthh);
            tablePC.getDefaultCell().setBorder(0);
            tablePC.setTotalWidth(widthh);
            
            tablePC.addCell(new Paragraph("Complaints & Diagnosis :", FontFactory.getFont(fontPath, 11,Font.BOLD)));
            tablePC.addCell("--------------------------------------------------------------------------------------------");
            //tablePC.addCell("");
            tablePC.addCell(new Paragraph("Presenting Complaints:", FontFactory.getFont(fontPath, 10,Font.BOLD)));
            tablePC.addCell(new Paragraph(treatment.getPComplaints(),FontFactory.getFont(fontPath, 8)));
            tablePC.addCell("");
            tablePC.addCell(new Paragraph("Provisional Diagnosis:", FontFactory.getFont(fontPath, 10,Font.BOLD)));
            Mapping map;
            while(dItr.hasNext()){
                map = (Mapping)dItr.next();
                tablePC.addCell(new Paragraph(map.getKey()+"  "+map.getValue(),FontFactory.getFont(fontPath, 8)));
            }
            document.add(tablePC);
            
            //Medication Header Table
            PdfPTable tableMEDH = new PdfPTable(widthh);
            tableMEDH.getDefaultCell().setBorder(0);
            tableMEDH.setTotalWidth(widthh);
            
            tableMEDH.addCell("");
            tableMEDH.addCell(new Paragraph("Medication: ["+treatment.getDTime().toLocaleString()+"]", FontFactory.getFont(fontPath, 11,Font.BOLD)));
            tableMEDH.setSpacingBefore(10f);
            document.add(tableMEDH);
            
            
            //Medication Contents Name
            float[] widthm = {5f,2.5f,.9f,2f,5f};
            PdfPTable tablecn = new PdfPTable(widthm);
            //tablecn.getDefaultCell().setBorder(0);
            //tablecn.getDefaultCell().setBorderWidth(1f);
            //tablecn.getDefaultCell().setPadding(2f);
                
            tablecn.addCell(new Paragraph("Medicines", FontFactory.getFont(fontPath, 8,Font.BOLD)));
            tablecn.addCell(new Paragraph(" Timings", FontFactory.getFont(fontPath, 8,Font.BOLD)));
            tablecn.addCell(new Paragraph(" QTY", FontFactory.getFont(fontPath, 8,Font.BOLD)));
            tablecn.addCell(new Paragraph(" Periods", FontFactory.getFont(fontPath, 8,Font.BOLD)));
            tablecn.addCell(new Paragraph("Comments", FontFactory.getFont(fontPath, 8,Font.BOLD)));
            
            tablecn.setSpacingBefore(8f);
            document.add(tablecn);
            
            //Medication Table
            PdfPTable tablem = new PdfPTable(widthm);
            tablem.getDefaultCell().setBorder(0);
            tablem.setTotalWidth(widthm);
            
            
            //Loop for Number of Medicinces to be prescribed
            Medicine med ;
            BasicFunction bf = new BasicFunction();
            int i=1;
            
            while(mItr.hasNext()){
                med = (Medicine)mItr.next();
                //tablem.addCell(new Paragraph(map.getKey()+"  "+map.getValue(),fontc));
                
                //For Highlighting
                
                if (i % 2 == 1) {
                    tablem.getDefaultCell().setGrayFill(0.9f);
                }else {
                    tablem.getDefaultCell().setGrayFill(0.0f);
                }
                
                
                //System.out.println(i);
                tablem.addCell(new Paragraph(med.getMCode()+"\t"+med.getMName(), FontFactory.getFont(fontPath, 9)));
                tablem.addCell(new Paragraph(" "+bf.getTiming(med.getTiming()) , FontFactory.getFont(fontPath, 9)));
                tablem.addCell(new Paragraph(" "+med.getQty(), FontFactory.getFont(fontPath, 9)));
                tablem.addCell(new Paragraph(" "+med.getPeriod(), FontFactory.getFont(fontPath, 9)));
                tablem.addCell(new Paragraph(" "+med.getComments(), FontFactory.getFont(fontPath, 9)));
                i++;
            }
            
            tablem.setSpacingBefore(5f);
            document.add(tablem);
            
           
            //DoctorName Table
            float[] widthdn = {3f};
            PdfPTable tabledn = new PdfPTable(widthdn);
            tabledn.getDefaultCell().setBorder(0);
            tabledn.setTotalWidth(widthp);
            tabledn.addCell(new Paragraph("Diagnosed By\n"+treatment.getEmpName(), FontFactory.getFont(fontPath, 10)));
            //tabledn.addCell(new Paragraph(treatment.getEmpName(),  FontFactory.getFont(fontPath, 9,Font.ITALIC)));
            
            tabledn.setSpacingBefore(30f);
            document.add(tabledn);
            
           
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
        makePdf(request, response, "GET");
    }
    
    private String getAgeFromDOB(java.sql.Date dob){
        return new Integer(new java.util.Date().getYear()-dob.getYear()).toString();
    }
    
    /** Handles the HTTP <code>POST</code> method.
     * @param request servlet request
     * @param response servlet response
     */
    
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        makePdf(request, response, "POST");
    }
    
    /** Returns a short description of the servlet.
     */
    
    public String getServletInfo() {
        return "Short description";
    }
    // </editor-fold>
}