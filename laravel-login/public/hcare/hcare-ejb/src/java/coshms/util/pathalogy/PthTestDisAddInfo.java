/*
 * PhtTestDisAddInfo.java
 *
 * Created on May 13, 2006, 12:17 AM
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
public class PthTestDisAddInfo implements Serializable {
    private int testReqId;
    private int testId;
    private int empId;
    private int discount;
    /** Creates a new instance of PhtTestDisAddInfo */
    public PthTestDisAddInfo() {
    }
    
    public PthTestDisAddInfo(int trId,int tId,int eId,int dis) {
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
