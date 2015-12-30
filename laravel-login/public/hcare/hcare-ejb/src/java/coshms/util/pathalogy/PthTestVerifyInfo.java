/*
 * PthTestVerifyInfo.java
 *
 * Created on May 19, 2006, 9:14 AM
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
public class PthTestVerifyInfo implements Serializable {
    
    private int testId;
    private int testReqId;
    private String testName;
    private String overAllNotes;
    /** Creates a new instance of PthTestVerifyInfo */
    public PthTestVerifyInfo() {
    }

    public PthTestVerifyInfo(int testId,int testReqId,String testName) {
    this.setTestId(testId);
    this.setTestReqId(testReqId);
    this.setTestName(testName);
    }
    
    public PthTestVerifyInfo(String overAllNotes ,int testId,int testReqId) {
    this.setTestId(testId);
    this.setTestReqId(testReqId);
    this.setOverAllNotes(overAllNotes);
    }
    
    public int getTestId() {
        return testId;
    }

    public void setTestId(int testId) {
        this.testId = testId;
    }

    public int getTestReqId() {
        return testReqId;
    }

    public void setTestReqId(int testReqId) {
        this.testReqId = testReqId;
    }

    public String getTestName() {
        return testName;
    }

    public void setTestName(String testName) {
        this.testName = testName;
    }

    public String getOverAllNotes() {
        return overAllNotes;
    }

    public void setOverAllNotes(String overAllNotes) {
        this.overAllNotes = overAllNotes;
    }
    
}
