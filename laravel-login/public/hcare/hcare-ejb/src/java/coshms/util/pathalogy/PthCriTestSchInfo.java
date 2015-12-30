/*
 * PthCriTestSchInfo.java
 *
 * Created on May 15, 2006, 7:37 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.pathalogy;
import java.io.Serializable;
/**
 *
 * @author Administrator
 */
public class PthCriTestSchInfo implements Serializable {
    
    private int testReqId;
    private java.sql.Date testReqDate;
    private int testId;
    private String testName;
    private java.sql.Date appReqDate;
    private java.sql.Date appointmentDate;
    private String shiftName;
    
    /**
     * Creates a new instance of PthCriTestSchInfo
     */
    public PthCriTestSchInfo() {
    }

    public PthCriTestSchInfo(int testReqId,int testId, String testName,java.sql.Date testReqDate) {
    this.setTestReqId(testReqId);
    this.setTestReqDate(testReqDate);
    this.setTestId(testId);
    this.setTestName(testName);
    }
    
    public PthCriTestSchInfo(int testReqId,int testId,java.sql.Date appointmentDate, String shiftName) {
    this.setTestReqId(testReqId);
    this.setTestId(testId);
    this.setAppointmentDate(appointmentDate);
    this.setShiftName(shiftName);
    }
    
    
    
    public int getTestReqId() {
        return testReqId;
    }

    public void setTestReqId(int testReqId) {
        this.testReqId = testReqId;
    }

    public java.sql.Date getTestReqDate() {
        return testReqDate;
    }

    public void setTestReqDate(java.sql.Date testReqDate) {
        this.testReqDate = testReqDate;
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

    public java.sql.Date getAppReqDate() {
        return appReqDate;
    }

    public void setAppReqDate(java.sql.Date appReqDate) {
        this.appReqDate = appReqDate;
    }

    public java.sql.Date getAppointmentDate() {
        return appointmentDate;
    }

    public void setAppointmentDate(java.sql.Date appointmentDate) {
        this.appointmentDate = appointmentDate;
    }

    public String getShiftName() {
        return shiftName;
    }

    public void setShiftName(String shiftName) {
        this.shiftName = shiftName;
    }
    
    
    
}
