/*
 * RadTestAccInfo.java
 *
 * Created on June 5, 2006, 11:54 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.radiology;
import java.io.Serializable;
/**
 *
 * @author Administrator
 */
public class RadTestAccInfo  implements Serializable  {
    private int testReqId;
    private int testId;
    private int empId;

    /** Creates a new instance of RadTestAccInfo */
    public RadTestAccInfo() {
    }
    public RadTestAccInfo(int tReqId,int tId,int eId) {
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
