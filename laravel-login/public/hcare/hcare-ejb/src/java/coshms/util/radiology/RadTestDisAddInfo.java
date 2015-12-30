/*
 * RadTestDisAddInfo.java
 *
 * Created on June 5, 2006, 10:48 PM
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
public class RadTestDisAddInfo implements Serializable {
    
    private int testReqId;
    private int testId;
    private int empId;
    private int discount;
    /** Creates a new instance of RadTestDisAddInfo */
    public RadTestDisAddInfo() {
    }
    
    public RadTestDisAddInfo(int trId,int tId,int eId,int dis) {
    this.setTestReqId(trId);
    this.setTestId(tId);
    this.setEmpId(eId);
    this.setDiscount(dis);
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

    public int getDiscount() {
        return discount;
    }

    public void setDiscount(int discount) {
        this.discount = discount;
    }

    
}
