/*
 * PthTestAccInfo.java
 *
 * Created on May 13, 2006, 8:18 AM
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
public class PthTestAccInfo implements Serializable {
    
    private int testReqId;
    private int testId;
    private int empId;
    
    
    /** Creates a new instance of PthTestAccInfo */
    public PthTestAccInfo() {
    }
    
    public PthTestAccInfo(int tReqId,int tId,int eId) {
    this.empId = eId;
    this.testId = tId;
    this.testReqId = tReqId;
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

    

    public int getEmpId() {
        return empId;
    }

    public void setEmpId(int empId) {
        this.empId = empId;
    }
    
}
