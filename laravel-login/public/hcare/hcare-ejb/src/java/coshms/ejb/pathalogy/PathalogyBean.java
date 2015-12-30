package coshms.ejb.pathalogy;

import coshms.util.pathalogy.PthTestPlanInfo;
import java.io.*;
import java.util.ArrayList;
import java.util.logging.Level;
import javax.ejb.*;
import javax.sql.DataSource;
import java.sql.*;


import org.apache.log4j.Logger;

/**
 * This is the bean class for the PathalogyBean enterprise bean.
 * Created Jun 15, 2006 12:15:11 PM
 * @author Administrator
 */
public class PathalogyBean implements SessionBean, PathalogyRemoteBusiness {
    private SessionContext context;
    
      static Logger logger = Logger.getLogger(PathalogyBean.class);        
    DataSource ds;    
    Connection con;
    CallableStatement stmt;
    ResultSet rs;
    
    // <editor-fold defaultstate="collapsed" desc="EJB infrastructure methods. Click the + sign on the left to edit the code.">
    // TODO Add code to acquire and use other enterprise resources (DataSource, JMS, enterprise bean, Web services)
    // TODO Add business methods or web service operations
    /**
     * @see javax.ejb.SessionBean#setSessionContext(javax.ejb.SessionContext)
     */
    public void setSessionContext(SessionContext aContext) {
        context = aContext;
    }
    
    /**
     * @see javax.ejb.SessionBean#ejbActivate()
     */
    public void ejbActivate() {
        
    }
    
    /**
     * @see javax.ejb.SessionBean#ejbPassivate()
     */
    public void ejbPassivate() {
        
    }
    
    /**
     * @see javax.ejb.SessionBean#ejbRemove()
     */
    public void ejbRemove() {
        
    }
    // </editor-fold>
    
    /**
     * See section 7.10.3 of the EJB 2.0 specification
     * See section 7.11.3 of the EJB 2.1 specification
     */
    public void ejbCreate() {
        // TODO implement ejbCreate if necessary, acquire resources
        // This method has access to the JNDI context so resource aquisition
        // spanning all methods can be performed here such as home interfaces
        // and data sources.
    }
    
   public ArrayList getAvailablePthTests() {
        //TODO implement getAvailablePthTests
               
        ArrayList pthTestList = new ArrayList();
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getAvailablePthTests() }");
         rs = stmt.executeQuery();
 
         while(rs.next()){
            coshms.util.pathalogy.PthAvlTestsInfo pthAvlTest = new coshms.util.pathalogy.PthAvlTestsInfo(rs.getString("name"),rs.getInt("testId"));
             pthTestList.add(pthAvlTest);
        }
        rs.close();
        con.close();
        }catch(Exception Ex){
        //System.out.println( Ex.getMessage());
        }
        return pthTestList;
    }
    

    private javax.sql.DataSource getMyDatabase() throws javax.naming.NamingException {
        javax.naming.Context c = new javax.naming.InitialContext();
        return (javax.sql.DataSource) c.lookup("java:/MySQLDB");
    }
    
    public String temp(int empId, coshms.util.pathalogy.PthCriTestSchInfo pthCriticalSch) {
   
        return "ok";
    }

    public ArrayList myTempProc() {
   
        int ptId = 1;
        String filename = "D:\\mrangio.dcm";
        String notes = "Islam";
        int yy = 105;
        int m = 2;
        int d = 5;
        java.util.Date t = new java.util.Date();
        java.sql.Date todayDate  = new java.sql.Date(t.getYear(),t.getMonth(),t.getDate());
        PreparedStatement ps = null;
        
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         
          ps = con.prepareStatement( "INSERT INTO rad_test_result (imageId, testId, testReqId, notes,empId,resultDT,image) VALUES( ?, ?, ?, ? ,? ,? ,? )" );

      ps.setInt( 1, 0 );
      ps.setInt( 2, 1 );
      ps.setInt( 3, 4 );
      ps.setString( 4, notes );
      ps.setInt( 5, 1 );
      ps.setDate(6,todayDate);
      
      // Insert the image into the second Blob
      File image = new File( filename );
      FileInputStream fis = new FileInputStream( image );
      ps.setBinaryStream( 7, fis, ( int )image.length() );

      // Execute the INSERT
      int count = ps.executeUpdate();
      System.out.println( "Rows inserted: " + count );
        ps.close(); 
        con.close();
        //return pthTestList;
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        }
        
        return null;                 
           
    }
    
    

    public boolean addPthTestRequest(int ptId, int encNo, int empId, java.util.ArrayList pthTestReqDetAL) {
        //TODO implement addPthTestRequest java.util.ArrayList pthTestReqDetAL
        java.util.Iterator pthTestReqDetIt;
        try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL setPthTestRequest(" +  ptId  + ", " + encNo + ", " +  empId + ") }");
         rs = stmt.executeQuery();
         int testReqId = 0;
         if(rs.next()) 
                 testReqId = rs.getInt(1);
         
         int urgentBasis = 0;
         pthTestReqDetIt = pthTestReqDetAL.iterator();
         
         while(pthTestReqDetIt.hasNext())
         {
         coshms.util.pathalogy.PthTestReqDetInfo pthTestReqDet = (coshms.util.pathalogy.PthTestReqDetInfo)pthTestReqDetIt.next();
         if(pthTestReqDet.isUrgentBasis())
                           urgentBasis = 1;
         stmt = con.prepareCall("{ CALL setPthTestReqDet("+ testReqId +", " + pthTestReqDet.getTestId() + ", " + urgentBasis + ") }");
         stmt.executeQuery();
         urgentBasis = 0;
         }
         
         rs.close();
         con.close();
        }catch(Exception Ex){
            logger.info("!!!!!!!!!!!!!! GAZI ILAM DEAN SAHEED  " + Ex.getMessage());
        return false;
        }
        
        return true;
    }

    public ArrayList getPthTestDiscount(int ptId) {
       
        ArrayList pthTestList = new ArrayList();
        
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPthTestDiscountInfo(" + ptId + ") }");
         rs = stmt.executeQuery();
 
         while(rs.next()){
            coshms.util.pathalogy.PthTestDisInfo pthTestDis = new coshms.util.pathalogy.PthTestDisInfo(rs.getInt("testReqId"),rs.getInt("testId"),rs.getInt("cost"),rs.getString("name"),rs.getDate("requestDate"));
            pthTestList.add(pthTestDis);
        }
        rs.close();
        con.close();
        }catch(Exception Ex){
        //System.out.println( Ex.getMessage());
        }
        return pthTestList;
    }


    
    public boolean addPthTestDiscount(java.util.ArrayList pthTestDisList) {
        
         java.util.Iterator pthTestDisIt;
        try {
         ds = getMyDatabase();    
         con = ds.getConnection();
       
         pthTestDisIt = pthTestDisList.iterator();
         
         while(pthTestDisIt.hasNext())
         {
         coshms.util.pathalogy.PthTestDisAddInfo pthTestDis = (coshms.util.pathalogy.PthTestDisAddInfo)pthTestDisIt.next();
         stmt = con.prepareCall("{ CALL setPthTestDiscount("+ pthTestDis.getTestId() +", " + pthTestDis.getTestReqId() + ", " + pthTestDis.getDiscount() + ", " + pthTestDis.getEmpId() + ") }");
         stmt.executeQuery();
         }
         
       
        }catch(Exception Ex){
        return false;
        }finally{
            try {
                rs.close();
                 con.close();
            } catch (SQLException ex) {
              
            }

        }
        
        return true;
    }

    public ArrayList getPthTestPayment(int ptId) {
        
        ResultSet rs2;
        ArrayList pthTestList = new ArrayList();
        
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPthTestPayInfo(" + ptId + ") }");
         rs = stmt.executeQuery();
          int discount = 0;
         while(rs.next()){
             
              stmt = con.prepareCall("{ CALL getPthTestDisInfo(" + rs.getInt("testId") + "," + rs.getInt("testReqId") + ") }");
              rs2 = stmt.executeQuery();
         
              if(rs2.next()) {
                  discount = rs2.getInt("discount");
                }
              
            coshms.util.pathalogy.PthTestDisInfo pthTestDis = new coshms.util.pathalogy.PthTestDisInfo(rs.getInt("testReqId"),rs.getInt("testId"),rs.getInt("cost"),rs.getString("name"),rs.getDate("requestDate"),discount);
            pthTestList.add(pthTestDis);
            discount = 0;
         }
        rs.close();
        con.close();
        }catch(Exception Ex){
        //System.out.println( Ex.getMessage());
        }
        return pthTestList;
    }

    public boolean addPthTestPayment(java.util.ArrayList pthTestAccList) {
        
        java.util.Iterator pthTestAccIt;
        try {
         ds = getMyDatabase();    
         con = ds.getConnection();
      
         pthTestAccIt = pthTestAccList.iterator();
         
         while(pthTestAccIt.hasNext())
         {
         coshms.util.pathalogy.PthTestAccInfo pthTestAcc = (coshms.util.pathalogy.PthTestAccInfo)pthTestAccIt.next();
         stmt = con.prepareCall("{ CALL setPthTestAccount("+ pthTestAcc.getTestId() +", " + pthTestAcc.getTestReqId() + ", " + pthTestAcc.getEmpId() + ") }");
         stmt.executeQuery();
         }
         
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!! GAZI ILAM DEAN SAHEED  " + Ex.getMessage());
            return false;
        }finally{
            try {
                rs.close();
                con.close();
            } catch (SQLException ex) {
                java.util.logging.Logger.getLogger(PathalogyBean.class.getName()).log(Level.SEVERE, null, ex);
            }

        }
        
        return true;
    }

    public boolean pthTestDomainAdd(java.util.ArrayList pthTestDomainList, String tName, int tStatus, int tCost, int empId) {
        
        java.util.Iterator pthTestConIt;
        try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL setPthTestDomain('"+ tName +"', " + tStatus + ", " + tCost + ", " + empId + ") }");
         rs = stmt.executeQuery();
         
         int testId = 0;
         if(rs.next())
         testId = rs.getInt(1);
           
         pthTestConIt = pthTestDomainList.iterator();
         
         while(pthTestConIt.hasNext())
         {
         coshms.util.pathalogy.PthTestContentsInfo pthTestCon = (coshms.util.pathalogy.PthTestContentsInfo)pthTestConIt.next();
         stmt = con.prepareCall("{ CALL setPthTestContents("+ testId +", '" + pthTestCon.getName() + "', " + pthTestCon.getMinValue() + ", " + pthTestCon.getMaxValue() + ",'" + pthTestCon.getUnit() + "') }");
         stmt.executeQuery();
         }
         
         rs.close();
         con.close();
        }catch(Exception Ex){
            logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AWAIS QARNI RA  " +  Ex.getMessage());
        return false;
        }
        return true;
    }

    public ArrayList getPthTestSample(int ptId) {
        ArrayList pthTestList = new ArrayList();
        
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPthTestSampleInfo(" + ptId + ") }");
         rs = stmt.executeQuery();
 
         while(rs.next()){
            coshms.util.pathalogy.PthTestSampleInfo pthTestSample = new coshms.util.pathalogy.PthTestSampleInfo(rs.getInt("testReqId"),rs.getInt("testId"),rs.getString("name"),rs.getDate("requestDate"));
            pthTestList.add(pthTestSample);
        }
        rs.close();
        con.close();
        }catch(Exception Ex){
        //System.out.println( Ex.getMessage());
        }
        return pthTestList; 

    }

    public int pthTestSampleAdd(int testReqId, int testId, int empId) {
        
        int sampleId = 0;
        
        try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL setPthTestSam("+ testReqId +", " + testId + ", " + empId + ") }");
         rs = stmt.executeQuery();

         
         if(rs.next())
         sampleId = rs.getInt(1);

         rs.close();
         con.close();
        }catch(Exception Ex){
         logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        return 0;
        }
        return sampleId;
    }

    public ArrayList getPthResultInfo(int sampleId) {
        
       ResultSet rs2;
       ResultSet rs3;
       ArrayList pthConList = new ArrayList();
       int testId = 0;
       int samId = 0;
       String testName = "";
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();

         stmt = con.prepareCall("{ CALL getPthTestIsSamplReject("+ sampleId +") }");
         rs3 = stmt.executeQuery();
         if(rs3.next())
         {
         samId = rs3.getInt(1);
         return null;
         }       

         stmt = con.prepareCall("{ CALL getPthTestIsResultAdd("+ sampleId +") }");
         rs3 = stmt.executeQuery();
         if(rs3.next())
         {
         samId = rs3.getInt(1);
         return null;
         }
         
         stmt = con.prepareCall("{ CALL getPthTestResultInfo("+ sampleId +") }");
         rs = stmt.executeQuery();
 
         if(rs.next())
         {
             testId = rs.getInt(1);
             testName = rs.getString(2);
         }
         
         stmt = con.prepareCall("{ CALL getPthTestResCon("+ testId +") }");
         rs = stmt.executeQuery();
              
//         testName = getTestName(testId);
         
         while(rs.next()){
             
         stmt = con.prepareCall("{ CALL getPthTestConInfo("+ rs.getInt(1) +") }");
         rs2 = stmt.executeQuery();
         if(rs2.next()) 
         {   
            coshms.util.pathalogy.PthTestContentsInfo pthAvlTestCon = new coshms.util.pathalogy.PthTestContentsInfo(testName,rs2.getInt("contentId"),rs2.getString("name"),rs2.getDouble("minValue"),rs2.getDouble("maxValue"),rs2.getString("unit"));
            pthConList.add(pthAvlTestCon);
         }
        }
        rs.close();
        con.close();
        }catch(Exception Ex){
         logger.info("!!!!!!!!!!!!getPthResultInfo!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        return null;
        }
        return pthConList;
    }

    
    
    
    public boolean PthTestResultAdd(int sampleId, int empId, java.util.ArrayList pthTestResList) {
           
        java.util.Iterator pthTestResIt;
        try {
         ds = getMyDatabase();    
         con = ds.getConnection();
      
         pthTestResIt = pthTestResList.iterator();
         
         while(pthTestResIt.hasNext())
         {
         coshms.util.pathalogy.PthTestContentsInfo pthTestRes = (coshms.util.pathalogy.PthTestContentsInfo)pthTestResIt.next();
         stmt = con.prepareCall("{ CALL setPthTestResult("+ sampleId +", " + pthTestRes.getContentId() + "," + pthTestRes.getContentValue() + ",' " + pthTestRes.getContentNotes() + "', " + empId + ") }");
         stmt.executeQuery();
         }
         
        
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!PthTestResultAdd!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
            return false;
        }finally{
            try{

         rs.close();
         con.close();
            }catch(Exception e){

            }
        }
        
        return true;
    }

    public ArrayList getPthTestSampleReject(int sampleId) {
        
        ArrayList pthTestList = new ArrayList();
        
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPthTestSampleReject(" + sampleId + ") }");
         rs = stmt.executeQuery();
 
         while(rs.next()){
            coshms.util.pathalogy.PthTestSampleInfo pthTestSample = new coshms.util.pathalogy.PthTestSampleInfo(0,0,rs.getString("tName"),rs.getDate("tRDate"));
            pthTestList.add(pthTestSample);
        }
        rs.close();
        con.close();
        }catch(Exception Ex){
        //System.out.println( Ex.getMessage());
        }
        return pthTestList; 
    }

    public boolean PthTestSamRejAdd(int sampleId, int empId, String description) {
        
        try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL setPthSamRej("+ sampleId +", '" + description + "', " + empId + ") }");
         rs = stmt.executeQuery();
         rs.close();
         con.close();
        }catch(Exception Ex){
        return false;
        }
        return true;
    }

    public ArrayList getPthTestReportInfo(int ptId) {
        
        ArrayList pthTestList = new ArrayList();
        
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPthTestReportInfo(" + ptId + ") }");
         rs = stmt.executeQuery();
 
         while(rs.next()){
            coshms.util.pathalogy.PthTestReportInfo pthTestReport = new coshms.util.pathalogy.PthTestReportInfo(rs.getInt("testReqId"),rs.getInt("testId"),rs.getString("name"),rs.getDate("requestDate"));
            pthTestList.add(pthTestReport);
        }
        rs.close();
        con.close();
        }catch(Exception Ex){
        //System.out.println( Ex.getMessage());
        }
        return pthTestList; 
    }

    public void getPthCriticalTestInfo() {
        //TODO implement getPthCriticalTestInfo
    }

    public ArrayList getPthCriticalTest(int ptId) {

        ArrayList pthTestList = new ArrayList();
        
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPthCriticalTestInfo(" + ptId + ") }");
         rs = stmt.executeQuery();
 
         while(rs.next()){
            coshms.util.pathalogy.PthCriTestSchInfo pthTest = new coshms.util.pathalogy.PthCriTestSchInfo(rs.getInt("testReqId"),rs.getInt("testId"),rs.getString("name"),rs.getDate("requestDate"));
            pthTestList.add(pthTest);
        }
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        }finally{
            try{

        rs.close();
        con.close();
            }catch(Exception e){

            }
        }
        return pthTestList;                 
    }

    public boolean pthCriticalTestSchAdd(int empId, coshms.util.pathalogy.PthCriTestSchInfo pthCriticalSch) {
        
        try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         
         coshms.util.pathalogy.PthCriTestSchInfo pthCriticalSch2 =  (coshms.util.pathalogy.PthCriTestSchInfo)pthCriticalSch;
         stmt = con.prepareCall("{ CALL setPthCriticalSchdule("+ pthCriticalSch2.getTestId() +", " + pthCriticalSch2.getTestReqId() + ", " + empId + ",'" + pthCriticalSch2.getAppointmentDate().toString() + "', '" + pthCriticalSch2.getShiftName() + "') }");
         logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO GAHZI ILAM DEAN  SAHEED  " + pthCriticalSch2.getShiftName() );
         stmt.executeQuery();

        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO GAHZI ILAM DEAN  SAHEED  " +  Ex.getMessage());
            return false;
        } try{
             rs.close();
         con.close();
        }catch(Exception ee){

        }
        return true;
    }

    public String getPatientName(int ptId) {
        String name = "";
        try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPatientName(" + ptId + ") }");
         rs = stmt.executeQuery();
 
         if(rs.next()){
            
             name = rs.getString(1) + rs.getString(2);
        }
        rs.close();
        con.close();
        }catch(Exception Ex){
        return Ex.getMessage();
        }
        
        return name;
    }

    public ArrayList getPthTestInfo(int testId) {
        ArrayList pthTestList = new ArrayList();
        
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPthTestInfo(" + testId + ") }");
         rs = stmt.executeQuery();
 
         while(rs.next()){
            coshms.util.pathalogy.PthAvlTestsInfo pthTest = new coshms.util.pathalogy.PthAvlTestsInfo(rs.getString("name"),rs.getInt("testId"),rs.getInt("cost"),rs.getBoolean("status"));
            pthTestList.add(pthTest);
        }
        rs.close();
        con.close();
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO DATA ALI HAJWARY RA  " +  Ex.getMessage());
        }
        return pthTestList;                 
    }

    public ArrayList getPthTestConInfo(int testId) {
        ResultSet rs2;
        ResultSet rs3;
        ArrayList pthConList = new ArrayList();
        
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
        
        stmt = con.prepareCall("{ CALL getPthTestResCon("+ testId +") }");
        rs = stmt.executeQuery();

        while(rs.next()){
         stmt = con.prepareCall("{ CALL getPthTestConInfo("+ rs.getInt(1) +") }");
         rs2 = stmt.executeQuery();
         if(rs2.next()) 
         {   
            coshms.util.pathalogy.PthTestContentsInfo pthAvlTestCon = new coshms.util.pathalogy.PthTestContentsInfo("",rs2.getInt("contentId"),rs2.getString("name"),rs2.getDouble("minValue"),rs2.getDouble("maxValue"),rs2.getString("unit"));
            pthConList.add(pthAvlTestCon);
         }
        }
        rs.close();
        con.close();
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO  DATA ALI HAJWARY RA  " +  Ex.getMessage());
        }
        return pthConList;
    }

    public boolean pthTestDomainEdit(java.util.ArrayList pthTestConList, String tName, int status, int cost, int empId, int testId) {
        java.util.Iterator pthTestConIt;
        try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL editPthTestDomain("+ testId +", '" + tName + "', " + status + ", " + cost + ") }");
         stmt.executeQuery();
         
         pthTestConIt = pthTestConList.iterator();
         while(pthTestConIt.hasNext())
         {
         coshms.util.pathalogy.PthTestContentsInfo pthTestCon = (coshms.util.pathalogy.PthTestContentsInfo)pthTestConIt.next();
         stmt = con.prepareCall("{ CALL editPthTestContent("+ pthTestCon.getContentId() +", '" + pthTestCon.getName() + "', " + pthTestCon.getMinValue() + ", " + pthTestCon.getMaxValue() + ",'" + pthTestCon.getUnit() + "') }");
         stmt.executeQuery();
         }
         
         rs.close();
         con.close();
        }catch(Exception Ex){
            logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO  AWAIS QARNI RA  " +  Ex.getMessage());
        return false;
        }
        return true;
    }

    public ArrayList getPthTestAll() {
        ArrayList pthTestList = new ArrayList();
        
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPthTestAll() }");
         rs = stmt.executeQuery();
 
         while(rs.next()){
            coshms.util.pathalogy.PthAvlTestsInfo pthTest = new coshms.util.pathalogy.PthAvlTestsInfo(rs.getString("name"),rs.getInt("testId"));
            pthTestList.add(pthTest);
        }
        rs.close();
        con.close();
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO DATA ALI HAJWARY RA " +  Ex.getMessage());
        }
        return pthTestList;                 
    }

    public ArrayList getPthResultVerifyInfo() {
        ArrayList pthTestList = new ArrayList();
        
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPthVerifyInfo() }");
         rs = stmt.executeQuery();
 
         while(rs.next()){
            coshms.util.pathalogy.PthTestVerifyInfo pthTest = new coshms.util.pathalogy.PthTestVerifyInfo(rs.getInt("testId"),rs.getInt("testReqId"),rs.getString("name"));
            pthTestList.add(pthTest);
        }
        rs.close();
        con.close();
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        }
        return pthTestList;                 
    }

    public ArrayList getPthTestConResult(int testId, int testReqId) {
       
        ArrayList pthTestList = new ArrayList();
        
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPthTestResult("+ testId +","+ testReqId +") }");
         rs = stmt.executeQuery();
         while(rs.next()){
            coshms.util.pathalogy.PthTestContentsInfo pthTest = new coshms.util.pathalogy.PthTestContentsInfo(rs.getString("name"),rs.getDouble("minValue"),rs.getDouble("maxValue"),rs.getString("unit"),rs.getDouble("contentValue"),rs.getString("notes"));
            pthTestList.add(pthTest);
        }
        rs.close();
        con.close();
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        }
        return pthTestList;                 
        
    }

    public boolean pthResultVerifyAdd(int testId, int testReqId, String overAllNotes, int empId) {
        try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         
         stmt = con.prepareCall("{ CALL setPthTestResultVerify("+ testId +", " + testReqId + ",'"+ overAllNotes +"'," + empId + ") }");
         stmt.executeQuery();

        
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO GAHZI ILAM DEAN  SAHEED  " +  Ex.getMessage());
            return false;
        }finally{
            try{
             rs.close();
         con.close();
        }catch(Exception ee){
            
        }
        }
        return true;
    }

    public String getTestName(int testId) {
        
        String name = "";
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPthTestName("+ testId +") }");
         rs = stmt.executeQuery();
         if(rs.next()){
          name = rs.getString(1);
         }
        rs.close();
        con.close();
        return name;
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        }
        return "Error";                 
    }

    public String getEmployeeName(int empId) {
        
        String name = "";
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getEmpName("+ empId +") }");
         rs = stmt.executeQuery();
         if(rs.next()){
          name = rs.getString(1);
          name += " " + rs.getString(2);
         }
        rs.close();
        con.close();
        return name;
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        }
        return "Error";                 
    }

    public String getPthTestOverAllNotes(int testId, int testReqId) {
        
        String notes = "";
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPthTestOverAllNotes("+ testId +","+ testReqId +") }");
         rs = stmt.executeQuery();
         if(rs.next()){
          notes = rs.getString(1);
         }
        rs.close();
        con.close();
        return notes;
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        }
        return "Error";                 
    }

    public boolean getPthTestIsUrgentBasis(int testId, int testReqId) {
        
        boolean urgentBasis = false;
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPthTestIsUrgentBasis(" + testId + "," + testReqId + ") }");
         rs = stmt.executeQuery();
         
              if(rs.next()) {
                  urgentBasis = rs.getBoolean(1);
                }
              
        rs.close();
        con.close();
        return urgentBasis;
        }catch(Exception Ex){
        //System.out.println( Ex.getMessage());
        }
        return urgentBasis;
    }

    public PthTestPlanInfo getPthTestPlan() {

        int testReqCount = 0;
        int urgentCount = 0;
        int regularCount = 0;
        int smapleCount = 0;
        int criticalTestCount = 0;
        
        
        ResultSet rs2;
        try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPthTodayReqId() }");
         rs = stmt.executeQuery();
         
         while(rs.next()) {
         stmt = con.prepareCall("{ CALL getPthTestPlan("+ rs.getInt("testReqId") +") }");
         rs2 = stmt.executeQuery();
       if(rs2.next()) {
         testReqCount += rs2.getInt("testReqCount");
         urgentCount += rs2.getInt("urgentBasis");
         regularCount += rs2.getInt("regular");
         smapleCount += rs2.getInt("sampleCount");
         criticalTestCount += rs2.getInt("criticalTestCount"); 
       }
         }
         
         coshms.util.pathalogy.PthTestPlanInfo   pthTestPlan = new coshms.util.pathalogy.PthTestPlanInfo(testReqCount,urgentCount,regularCount,criticalTestCount,smapleCount);
         
        rs.close();
        con.close();
        return pthTestPlan;
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        }
        return null;
        
    }

    public ArrayList getPthTestAuditInfo(int ptId) {
               
        ArrayList pthTestList = new ArrayList();
        
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPatientPthTest("+ ptId +") }");
         rs = stmt.executeQuery();
         while(rs.next()){
            coshms.util.pathalogy.PthTestAuditInfo pthTest = new coshms.util.pathalogy.PthTestAuditInfo(rs.getInt("testReqId"),rs.getInt("testId"),rs.getString("name"),rs.getDate("requestDate"));
            pthTestList.add(pthTest);
            logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " + rs.getString("name"));
        }
        rs.close();
        con.close();
        //return pthTestList;
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        }
        
        return pthTestList;                 
    }

    public ArrayList getPthTestAudit(int ptId) {
               
        ArrayList pthTestList = new ArrayList();
        
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPatientPthTest("+ ptId +") }");
         rs = stmt.executeQuery();
         while(rs.next()){
            coshms.util.pathalogy.PthTestAuditInfo pthTest = new coshms.util.pathalogy.PthTestAuditInfo(rs.getInt("testReqId"),rs.getInt("testId"),rs.getString("name"),rs.getDate("requestDate"));
            pthTestList.add(pthTest);
            //logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " + rs.getString("name"));
        }
        rs.close();
        con.close();
        //return pthTestList;
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        }
        
        return pthTestList;                 
    }

    public ArrayList getPthTestAudit(int testId, int testReqId) {
        ArrayList pthTestList = new ArrayList();
        java.sql.Timestamp myTime;
        String testReqDate = "0002-11-30 00:00:00.0";
        String testDisDate = "0002-11-30 00:00:00.0";
        String testFeeDate = "0002-11-30 00:00:00.0";
        String testResDate = "0002-11-30 00:00:00.0";
        String testResVerDate = "0002-11-30 00:00:00.0";
        
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPthTestAudit("+ testId +","+ testReqId +") }");
         rs = stmt.executeQuery();
         while(rs.next()){
             
            
            coshms.util.pathalogy.PthTestAuditInfo pthTest = new coshms.util.pathalogy.PthTestAuditInfo(rs.getString("testName"),
       
            rs.getTimestamp("testReqDate").getTime(),
            rs.getString("testRequestedByf") +" "+ rs.getString("testRequestedByl"),
            rs.getInt("discount"),
                    
            rs.getTimestamp("discountDate").getTime(),
//rs.getDate("discountDate").getTime(),
            rs.getString("testDiscountedByf") +" "+ rs.getString("testDiscountedByl"),rs.getInt("testFee"),
            rs.getTimestamp("testFeeDate").getTime(),
            rs.getString("testSampleConductedByf") +" "+ rs.getString("testSampleConductedByl"),rs.getTimestamp("testSampleDate").getTime(),rs.getString("testResultConductedByf") +" "+ rs.getString("testResultConductedByl"),
            rs.getTimestamp("testResultDate").getTime(),rs.getString("testResultVerifiedByf") +" "+ rs.getString("testResultVerifiedByl"),
            rs.getTimestamp("testResultVerifiedDate").getTime());
            pthTestList.add(pthTest);
            myTime = new java.sql.Timestamp(rs.getTimestamp("testReqDate").getTime());
            logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " + Integer.valueOf(testId).toString() + " " + Integer.valueOf(testReqId).toString()) ;
        }
        rs.close();
        con.close();
        //return pthTestList;
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        }
        
        return pthTestList;                 
    }

    public String getPthTNameForSam(int sid) {
        ResultSet rs2;
       ResultSet rs3;
       ArrayList pthConList = new ArrayList();
       int testId = 0;
       int samId = 0;
       String testName = "";
    try {
         ds = getMyDatabase();    
         con = ds.getConnection();

         stmt = con.prepareCall("{ CALL getPthTestIsSamplReject("+ sid +") }");
         rs3 = stmt.executeQuery();
         if(rs3.next())
         {
         samId = rs3.getInt(1);
         return null;
         }       

         stmt = con.prepareCall("{ CALL getPthTestIsResultAdd("+ sid +") }");
         rs3 = stmt.executeQuery();
         if(rs3.next())
         {
         samId = rs3.getInt(1);
         return null;
         }
         
         stmt = con.prepareCall("{ CALL getPthTestResultInfo("+ sid +") }");
         rs = stmt.executeQuery();
 
         if(rs.next())
         {
             testId = rs.getInt(1);
             testName = rs.getString(2);
         }
         
         stmt = con.prepareCall("{ CALL getPthTestResCon("+ testId +") }");
         rs = stmt.executeQuery();
              
         testName = getTestName(testId);
     
    
            }catch(Exception Ex){
         logger.info("!!!!!!!!!!!!getPthResultInfo!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        return null;
        }   
         return testName;
    }

    public int getPtIdFromSamId(int sampleId) {
       int ptId = 0;
        try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{CALL PthTestPtId("+ sampleId +") }");
         rs = stmt.executeQuery();
         while(rs.next()){
            ptId = rs.getInt("pid");
        return ptId;
            //logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " + rs.getString("name"));
        }
        rs.close();
        con.close();
        //return pthTestList;
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        }
        return 0;
    }

    public int getPtIdFromTReqId(int testReqId) {
        int ptId = 0;
        try {
         ds = getMyDatabase();    
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL PthTestPtIdFromReqId("+ testReqId +") }");
         rs = stmt.executeQuery();
         while(rs.next()){
            ptId = rs.getInt("pid");
        return ptId;
            //logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " + rs.getString("name"));
        }
        rs.close();
        con.close();
        //return pthTestList;
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        }
        
        return 0;
    }
    
    
}
