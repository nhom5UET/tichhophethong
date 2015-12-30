/*
 * PthTestSampleInfo.java
 *
 * Created on May 13, 2006, 7:54 PM
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
public class PthTestSampleInfo implements Serializable {
    
    private int testReqId;
    private int testId;
    private String tName;
    private java.sql.Date testReqDate;
    
    /** Creates a new instance of PthTestSampleInfo */
    public PthTestSampleInfo() {
    }
    public PthTestSampleInfo(int testReqId,int testId,String tName,java.sql.Date tRDate) {
        this.setTName(tName);
        this.setTestId(testId);
        this.setTestReqDate(tRDate);
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

    public String getTName() {
        return tName;
    }

    public void setTName(String tName) {
        this.tName = tName;
    }

    public java.sql.Date getTestReqDate() {
        return testReqDate;
    }

    public void setTestReqDate(java.sql.Date testReqDate) {
        this.testReqDate = testReqDate;
    }
    
    
}
