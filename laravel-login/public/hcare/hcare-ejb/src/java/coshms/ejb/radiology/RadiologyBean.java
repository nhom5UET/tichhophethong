package coshms.ejb.radiology;

import java.util.ArrayList;
//import java.sql;

import java.io.File;
import java.io.FileInputStream;
import java.io.InputStream;
import java.sql.Blob;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import javax.ejb.*;
//import com.mysql.jdbc.Blob;

import org.apache.log4j.Logger;

/**
 * This is the bean class for the RadiologyBean enterprise bean.
 * Created Jun 15, 2006 12:16:07 PM
 * @author Administrator
 */
public class RadiologyBean implements SessionBean, RadiologyRemoteBusiness {
    private SessionContext context;

    static Logger logger = Logger.getLogger(RadiologyBean.class);
    javax.sql.DataSource ds;
    java.sql.Connection con;
    java.sql.CallableStatement stmt;
    java.sql.ResultSet rs;


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



   public ArrayList getRadTestAll() {
        //TODO implement getRadTestAll
          ArrayList radTestList = new ArrayList();

    try {
         ds = getMyDatabase();
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getRadTestAll() }");
         rs = stmt.executeQuery();

         while(rs.next()){
            coshms.util.radiology.RadAvlTestsInfo radTest = new coshms.util.radiology.RadAvlTestsInfo(rs.getString("name"),rs.getInt("testId"));
            radTestList.add(radTest);
        }
        rs.close();
        con.close();
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO DATA ALI HAJWARY RA " +  Ex.getMessage());
        }
        return radTestList;
    }

    private javax.sql.DataSource getMyDatabase() throws javax.naming.NamingException {
        javax.naming.Context c = new javax.naming.InitialContext();
        return (javax.sql.DataSource) c.lookup("java:/MySQLDB");
    }




    public boolean addRadTestRequest(int ptId, int encNo, int empId, java.util.ArrayList radTestReqDet) {

        java.util.Iterator radTestReqDetIt;
        try {
         ds = getMyDatabase();
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL radTestRequestSet(" +  ptId  + ", " + encNo + ", " +  empId + ") }");
         rs = stmt.executeQuery();
         int testReqId = 0;
         if(rs.next())
                 testReqId = rs.getInt(1);

         int urgentBasis = 0;
         radTestReqDetIt = radTestReqDet.iterator();

         while(radTestReqDetIt.hasNext())
         {
         coshms.util.radiology.RadTestReqDetInfo radTestReqDetInfo = (coshms.util.radiology.RadTestReqDetInfo)radTestReqDetIt.next();
         if(radTestReqDetInfo.isUrgentBasis())
                           urgentBasis = 1;
         stmt = con.prepareCall("{ CALL radTestReqDetSet("+ testReqId +", " + radTestReqDetInfo.getTestId() + ", " + urgentBasis + ") }");
         stmt.executeQuery();

         urgentBasis = 0;
         }

         rs.close();
         con.close();
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO DATA ALI HAJWARY RA " +  Ex.getMessage());
        return false;
        }

        return true;
    }

    public ArrayList getRadTestDiscount(int ptId) {

        ArrayList radTestList = new ArrayList();

    try {
         ds = getMyDatabase();
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getRadTestDiscount(" + ptId + ") }");
         rs = stmt.executeQuery();

         while(rs.next()){
            coshms.util.radiology.RadTestDisInfo radTestDis = new coshms.util.radiology.RadTestDisInfo(rs.getInt("testReqId"),rs.getInt("testId"),rs.getInt("cost"),rs.getString("name"),rs.getDate("requestDate"));
            radTestList.add(radTestDis);
        }
        rs.close();
        con.close();
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO DATA ALI HAJWARY RA " +  Ex.getMessage());
        }
        return radTestList;

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

    public boolean addRadTestDiscount(java.util.ArrayList radTestDis) {
        java.util.Iterator radTestDisIt;
        try {
         ds = getMyDatabase();
         con = ds.getConnection();

         radTestDisIt = radTestDis.iterator();

         while(radTestDisIt.hasNext())
         {
         coshms.util.radiology.RadTestDisAddInfo radTestDisInfo = (coshms.util.radiology.RadTestDisAddInfo)radTestDisIt.next();
         stmt = con.prepareCall("{ CALL radTestDiscountSet("+ radTestDisInfo.getTestId() +", " + radTestDisInfo.getTestReqId() + ", " + radTestDisInfo.getDiscount() + ", " + radTestDisInfo.getEmpId() + ") }");
         stmt.executeQuery();
         }

         rs.close();
         con.close();
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO DATA ALI HAJWARY RA " +  Ex.getMessage());
        return false;
        }

        return true;
    }

    public ArrayList getRadTestFee(int ptId) {
        ResultSet rs2;
        ArrayList radTestList = new ArrayList();

    try {
         ds = getMyDatabase();
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getRadTestFeeInfo(" + ptId + ") }");
         rs = stmt.executeQuery();
          int discount = 0;
         while(rs.next()){

              stmt = con.prepareCall("{ CALL getRadTestDiscountInfo(" + rs.getInt("testId") + "," + rs.getInt("testReqId") + ") }");
              rs2 = stmt.executeQuery();

              if(rs2.next()) {
                  discount = rs2.getInt("discount");
                }

            coshms.util.radiology.RadTestDisInfo radTestDis = new coshms.util.radiology.RadTestDisInfo(rs.getInt("testReqId"),rs.getInt("testId"),rs.getInt("cost"),rs.getString("name"),rs.getDate("requestDate"),discount);
            radTestList.add(radTestDis);
            discount = 0;
         }
        rs.close();
        con.close();
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO GHAZI ILAM DEAN SAHEED " +  Ex.getMessage());
        }
        return radTestList;
    }

   public boolean addRadTestFee(java.util.ArrayList pthTestAccList) {

        java.util.Iterator radTestAccIt;
        try {
         ds = getMyDatabase();
         con = ds.getConnection();

         radTestAccIt = pthTestAccList.iterator();

         while(radTestAccIt.hasNext())
         {
         coshms.util.radiology.RadTestAccInfo radTestAcc = (coshms.util.radiology.RadTestAccInfo)radTestAccIt.next();
         stmt = con.prepareCall("{ CALL radTestAccountSet("+ radTestAcc.getTestId() +", " + radTestAcc.getTestReqId() + ", " + radTestAcc.getEmpId() + ") }");
         stmt.executeQuery();
         }

         rs.close();
         con.close();
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!! GAZI ILAM DEAN SAHEED  " + Ex.getMessage());
            return false;
        }

        return true;
    }

   public boolean radTestDomainAdd(String tName, int tStatus, int tCost, int empId) {


        try {
         ds = getMyDatabase();
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL radTestDomainAdd('"+ tName +"', " + tStatus + ", " + tCost + ", " + empId + ") }");
         stmt.executeQuery();

         con.close();
        }catch(Exception Ex){
            logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AWAIS QARNI RA  " +  Ex.getMessage());
        return false;
        }
        return true;
    }


   public ArrayList getRadTestInfo(int testId) {
        ArrayList radTestList = new ArrayList();

    try {
         ds = getMyDatabase();
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getRadTestInfo(" + testId + ") }");
         rs = stmt.executeQuery();

         while(rs.next()){
            coshms.util.radiology.RadAvlTestsInfo radTest = new coshms.util.radiology.RadAvlTestsInfo(rs.getString("name"),rs.getInt("testId"),rs.getInt("cost"),rs.getBoolean("status"));
            radTestList.add(radTest);
        }
        rs.close();
        con.close();
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO DATA ALI HAJWARY RA  " +  Ex.getMessage());
        }
        return radTestList;
    }

   public ArrayList getRadAvailableTests() {
        ArrayList radTestList = new ArrayList();

    try {
         ds = getMyDatabase();
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getRadAvlTests() }");
         rs = stmt.executeQuery();

         while(rs.next()){
            coshms.util.radiology.RadAvlTestsInfo radTest = new coshms.util.radiology.RadAvlTestsInfo(rs.getString("name"),rs.getInt("testId"));
            radTestList.add(radTest);
        }
        rs.close();
        con.close();
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO DATA ALI HAJWARY RA " +  Ex.getMessage());
        }
        return radTestList;
    }

   public boolean radTestDomainEdit(String tName, int status, int cost, int empId, int testId) {

        try {
         ds = getMyDatabase();
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL editRadTestDomain("+ testId +", '" + tName + "', " + status + ", " + cost + ") }");
         stmt.executeQuery();

         con.close();
        }catch(Exception Ex){
            logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO  AWAIS QARNI RA  " +  Ex.getMessage());
        return false;
        }
        return true;
    }

    public boolean radTestResultAdd(int testId, int testReqId, int empId, String notes, java.util.ArrayList imageList) {

        String filename = "";
        java.util.Iterator radTestResIt;

        int yy = 105;
        int m = 2;
        int d = 5;
        java.util.Date t = new java.util.Date();
        java.sql.Date todayDate  = new java.sql.Date(t.getYear(),t.getMonth(),t.getDate());
        PreparedStatement ps = null;
        radTestResIt = imageList.iterator();
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  start " );
    try {
         ds = getMyDatabase();
         logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  ds " );
         con = ds.getConnection();
      logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED   con" );
         while(radTestResIt.hasNext()) {



          logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  while " );
         coshms.util.radiology.RadTestResultInfo radTestResult = (coshms.util.radiology.RadTestResultInfo)radTestResIt.next();
          //ps = con.prepareStatement( "INSERT INTO rad_test_result (imageId, testId, testReqId, notes,empId,resultDT,image) VALUES( ?, ?, ?, ? ,? ,? ,? )" );

      //File image = radTestResult.getImage();
      //FileInputStream fis = new FileInputStream( image );
      //ps.setBinaryStream( 5, fis, ( int )image.length() );

      //ps =    con.prepareCall("{call radTestResultAdd ("+ testId +"," + testReqId + ", '" + notes + "' ," + empId + "," + fis + ") }");
        ps =    con.prepareCall("{call radTestResultAdd (?,?,?,?,?) }");

      logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  aq " );

        //ps.setInt( 1, 0 );
      ps.setInt( 1, testId );
      ps.setInt( 2, testReqId );
      ps.setString( 3, notes );
      ps.setInt( 4, empId );
      //ps.setDate(6,todayDate);

      // Insert the image into radTestResuthe second Blob
      File image = radTestResult.getImage();
      FileInputStream fis = new FileInputStream( image );
      ps.setBinaryStream( 5, fis, ( int )image.length() );

      // Execute the INSERT
      int count = ps.executeUpdate();
      logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Integer.valueOf(testId).toString() +  "   " + Integer.valueOf(testReqId).toString());
      stmt = con.prepareCall("{ CALL radTestResultAdd2("+ testId +"," + testReqId + ") }");
      stmt.executeQuery();
      }

        ps.close();
        con.close();
        //return pthTestList;
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        return false;
        }

        return true;
    }

    public ArrayList getRadTestResultInfo(int ptId) {
        ArrayList radTestList = new ArrayList();

    try {
         ds = getMyDatabase();
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getRadTestResultInfo(" + ptId + ") }");
         rs = stmt.executeQuery();

         while(rs.next()){
            coshms.util.radiology.RadTestResultInfo radTestResult = new coshms.util.radiology.RadTestResultInfo(rs.getInt("testId"),rs.getInt("testReqId"),rs.getString("name"),rs.getDate("requestDate"));
            radTestList.add(radTestResult);
        }
        rs.close();
        con.close();
        }catch(Exception Ex){
        //System.out.println( Ex.getMessage());
        }
        return radTestList;

    }
public ArrayList getRadTestReportInfo(int ptId) {
        ArrayList radTestList = new ArrayList();

    try {
         ds = getMyDatabase();
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getRadTestReportInfo(" + ptId + ") }");
         rs = stmt.executeQuery();

         while(rs.next()){
            coshms.util.radiology.RadTestResultInfo radTestResult = new coshms.util.radiology.RadTestResultInfo(rs.getInt("testId"),rs.getInt("testReqId"),rs.getString("name"),rs.getDate("requestDate"));
            radTestList.add(radTestResult);
        }
        rs.close();
        con.close();
        }catch(Exception Ex){
        //System.out.println( Ex.getMessage());
        }
        return radTestList;

    }

public ArrayList getRadTestReport(int testId ,int testReqId) {
        ArrayList radTestList = new ArrayList();
        int index = 0;
    try {
         ds = getMyDatabase();
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getRadTestResult(" + testId + ","+ testReqId +") }");
         rs = stmt.executeQuery();

         if(rs.next()){
             int size = 0;
      logger.info("!!!!!!!!!!!!!size=0!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " );
      Blob iblob = rs.getBlob("image");
      logger.info("!!!!!!!!!!!!!ab!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " );
             size = Integer.parseInt(Long.valueOf(iblob.length()).toString());
             byte by1[] = new byte[ size];
             InputStream in = iblob.getBinaryStream();
             coshms.util.radiology.RadTestResultInfo radTestResult = new coshms.util.radiology.RadTestResultInfo(rs.getString("notes"),size,rs.getString("name"),rs.getInt("empId"),rs.getDate("resultDT"));
       logger.info("!!!!!!!!!!!!!radTestRes!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " );
             index = in.read( by1, 0, size );
             radTestResult.setBy(by1);
             radTestList.add(radTestResult);


             logger.info("!!!!!!!!!!!!!size!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " + Integer.valueOf(size).toString());
            logger.info("!!!!!!!!!!!!!!!index!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " + Integer.valueOf(index).toString());
             //}
        rs.close();
        con.close();

         }
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!sb ex!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " + Ex.getMessage());
        }
        return radTestList;

    }

    public InputStream getRadImage(int testId, int testReqId) {

        try {
         ds = getMyDatabase();
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getRadTestResult(" + testId + ","+ testReqId +") }");
         rs = stmt.executeQuery();

         if(rs.next()) {
             Blob blob = rs.getBlob("image");

             InputStream in = blob.getBinaryStream();
           // coshms.util.radiology.RadTestResultInfo radTestResult = new coshms.util.radiology.RadTestResultInfo(rs.getInt("testId"),rs.getInt("testReqId"),rs.getString("name"),rs.getDate("requestDate"));
          //  radTestList.add(radTestResult);
        //}
        rs.close();
        con.close();
        return in;
         }
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        }
        return null;
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

    public int getPatientAge(int ptId) {

        int age = 0;
    try {
         ds = getMyDatabase();
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPtAge("+ ptId +") }");
         rs = stmt.executeQuery();
         if(rs.next()){
          age = rs.getInt(1);
         }
        rs.close();
        con.close();
        return age;
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        }

        return 0;
    }

  public ArrayList getRadTestAudit(int ptId) {

        ArrayList radTestList = new ArrayList();

    try {
         ds = getMyDatabase();
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getPatientRadTest("+ ptId +") }");
         rs = stmt.executeQuery();
         while(rs.next()){
            coshms.util.radiology.RadTestAuditInfo radTest = new coshms.util.radiology.RadTestAuditInfo(rs.getInt("testReqId"),rs.getInt("testId"),rs.getString("name"),rs.getDate("requestDate"));
            radTestList.add(radTest);
            logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " + rs.getString("name"));
        }
        rs.close();
        con.close();
        //return pthTestList;
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        }

        return radTestList;
  }

    public ArrayList getRadTestAudit(int testId, int testReqId) {
        ArrayList radTestList = new ArrayList();
        java.sql.Timestamp myTime;
    try {
         ds = getMyDatabase();
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getRadTestAudit("+ testId +","+ testReqId +") }");
         rs = stmt.executeQuery();
         while(rs.next()){
            coshms.util.radiology.RadTestAuditInfo radTest = new coshms.util.radiology.RadTestAuditInfo(rs.getString("testName"),rs.getTimestamp("testReqDate").getTime(),rs.getString("testRequestedByf") +" "+ rs.getString("testRequestedByl"),
            rs.getInt("discount"),rs.getTimestamp("discountDate").getTime(),rs.getString("testDiscountedByf") +" "+ rs.getString("testDiscountedByl"),rs.getInt("testFee"),rs.getTimestamp("testFeeDate").getTime(),
            rs.getTimestamp("testResultDate").getTime(),rs.getString("testResultConductedByf") +" "+ rs.getString("testResultConductedByl"));
            radTestList.add(radTest);
            myTime = new java.sql.Timestamp(rs.getTimestamp("testReqDate").getTime());
            logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " + rs.getTimestamp("testResultDate").getTime() ) ;
        }
        rs.close();
        con.close();
        //return radTestList;
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        }

        return radTestList;
    }

    public coshms.util.radiology.RadTestPlanInfo getRadTestPlan() {

        int testReqCount = 0;
        int urgentCount = 0;
        int regularCount = 0;
        //int smapleCount = 0;
        //int criticalTestCount = 0;


        ResultSet rs2;
        try {
         ds = getMyDatabase();
         con = ds.getConnection();
         stmt = con.prepareCall("{ CALL getRadTodayReqId() }");
         rs = stmt.executeQuery();

         while(rs.next()) {
         stmt = con.prepareCall("{ CALL getRadTestPlan("+ rs.getInt("testReqId") +") }");
         rs2 = stmt.executeQuery();
       if(rs2.next()) {
         testReqCount += rs2.getInt("testReqCount");
         urgentCount += rs2.getInt("urgentBasis");
         regularCount += rs2.getInt("regular");
//         smapleCount += rs2.getInt("sampleCount");
 //        criticalTestCount += rs2.getInt("criticalTestCount");
       }
         }

         coshms.util.radiology.RadTestPlanInfo   radTestPlan = new coshms.util.radiology.RadTestPlanInfo(testReqCount,urgentCount,regularCount);

        rs.close();
        con.close();
        return radTestPlan;
        }catch(Exception Ex){
        logger.info("!!!!!!!!!!!!s!!!!!!!!!!!!!!!!! SALAM TO AMIR CHEEMA SAHEED  " +  Ex.getMessage());
        }
        return null;
    }




}
