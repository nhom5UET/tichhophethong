/*
 * PthTestAuditInfo.java
 *
 * Created on May 22, 2006, 9:41 AM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.pathalogy;
import java.io.Serializable;
import org.jboss.naming.client.java.javaURLContextFactory;
/**
 *
 * @author Administrator
 */
public class PthTestAuditInfo  implements Serializable {

    private int testReqId;
    private int testId;
    private java.util.Date testReqDate;
    
    private String testName;
    private java.sql.Timestamp testReqTime;
    private String testReqBy;
    private int discount;
    private java.sql.Timestamp disDate;
    private String discountBy;
    private int feeCharge;
    private java.sql.Timestamp feeDate;
    private String smapleConductedBy;
    private java.sql.Timestamp sampleDate;
    private String resultConductedBy;
    private java.sql.Timestamp resultDate;
    private String resultVerifieddBy;
    private java.sql.Timestamp resultVerifyDate;

    
    /** Creates a new instance of PthTestAuditInfo */
    public PthTestAuditInfo(String testName,long testReqTime,String testReqBy,
    int discount,long disDate,String discountBy,int feeCharge,long feeDate,
    String smapleConductedBy,long sampleDate,String resultConductedBy,long resultDate,
    String resultVerifieddBy,long resultVerifyDate) {
        
        this.setTestName(testName);
        this.testReqTime = new java.sql.Timestamp(testReqTime);
        this.setTestReqBy(testReqBy);
        this.setDiscount(discount);
        this.disDate = new java.sql.Timestamp(disDate);
        this.setDiscountBy(discountBy);
        this.setFeeCharge(feeCharge);
        this.feeDate = new java.sql.Timestamp(feeDate);
        this.setSmapleConductedBy(smapleConductedBy);
        this.sampleDate = new java.sql.Timestamp(sampleDate);
        this.setResultConductedBy(resultConductedBy);
        this.resultDate = new java.sql.Timestamp(resultDate);
        this.setResultVerifieddBy(resultVerifieddBy);
        this.resultVerifyDate = new java.sql.Timestamp(resultVerifyDate);
    
    }

    public PthTestAuditInfo() {
    }
    
    public PthTestAuditInfo(int testReqId,int testId,String testName,java.util.Date testReqDate) {
    
    this.setTestId(testId);
    this.setTestName(testName);
    this.setTestReqDate(testReqDate);
    this.setTestReqId(testReqId);
    }

    public int getTestReqId() {
        return testReqId;
    }

    public void setTestReqId(int testReqId) {
        this.testReqId = testReqId;
    }

    public int getTestId() {
        return testId;
    }

    public void setTestId(int testId) {
        this.testId = testId;
    }

    public String getTestName() {
        return testName;
    }

    public void setTestName(String testName) {
        this.testName = testName;
    }

    public java.util.Date getTestReqDate() {
        return testReqDate;
    }

    public void setTestReqDate(java.util.Date testReqDate) {
        this.testReqDate = testReqDate;
    }

    public java.sql.Timestamp getTestReqTime() {
        return testReqTime;
    }

    public void setTestReqTime(java.sql.Timestamp testReqTime) {
        this.testReqTime = testReqTime;
    }

    public String getTestReqBy() {
        return testReqBy;
    }

    public void setTestReqBy(String testReqBy) {
        this.testReqBy = testReqBy;
    }

    public int getDiscount() {
        return discount;
    }

    public void setDiscount(int discount) {
        this.discount = discount;
    }

    public java.sql.Timestamp getDisDate() {
        return disDate;
    }

    public void setDisDate(java.sql.Timestamp disDate) {
        this.disDate = disDate;
    }

    public String getDiscountBy() {
        return discountBy;
    }

    public void setDiscountBy(String discountBy) {
        this.discountBy = discountBy;
    }

    public int getFeeCharge() {
        return feeCharge;
    }

    public void setFeeCharge(int feeCharge) {
        this.feeCharge = feeCharge;
    }

    public java.sql.Timestamp getFeeDate() {
        return feeDate;
    }

    public void setFeeDate(java.sql.Timestamp feeDate) {
        this.feeDate = feeDate;
    }

    public String getSmapleConductedBy() {
        return smapleConductedBy;
    }

    public void setSmapleConductedBy(String smapleConductedBy) {
        this.smapleConductedBy = smapleConductedBy;
    }

    public java.sql.Timestamp getSampleDate() {
        return sampleDate;
    }

    public void setSampleDate(java.sql.Timestamp sampleDate) {
        this.sampleDate = sampleDate;
    }

    public String getResultConductedBy() {
        return resultConductedBy;
    }

    public void setResultConductedBy(String resultConductedBy) {
        this.resultConductedBy = resultConductedBy;
    }

    public java.sql.Timestamp getResultDate() {
        return resultDate;
    }

    public void setResultDate(java.sql.Timestamp resultDate) {
        this.resultDate = resultDate;
    }

    public String getResultVerifieddBy() {
        return resultVerifieddBy;
    }

    public void setResultVerifieddBy(String resultVerifieddBy) {
        this.resultVerifieddBy = resultVerifieddBy;
    }

    public java.sql.Timestamp getResultVerifyDate() {
        return resultVerifyDate;
    }

    public void setResultVerifyDate(java.sql.Timestamp resultVerifyDate) {
        this.resultVerifyDate = resultVerifyDate;
    }
    
}
