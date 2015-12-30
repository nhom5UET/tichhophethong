/*
 * PthTestReportInfo.java
 *
 * Created on May 15, 2006, 7:56 AM
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
public class PthTestReportInfo implements Serializable {
    
    private int testReqId;
    private int testId;
    private String testName;
    private java.util.Date testReqDate;
    /** Creates a new instance of PthTestReportInfo */
    public PthTestReportInfo(int testReqId,int testId,String testName,java.util.Date testReqDate) {
    this.setTestId(testId);
    this.setTestName(testName);
    this.setTestReqDate(testReqDate);
    this.setTestReqId(testReqId);
    }
    
    public PthTestReportInfo() {
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
    
}
