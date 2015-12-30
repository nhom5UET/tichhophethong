/*
 * RadTestDisInfo.java
 *
 * Created on June 5, 2006, 10:19 PM
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
public class RadTestDisInfo implements Serializable {

    private int testReqId;
    private int testId;
    private int testCost;
    private String testname;
    private java.sql.Date dDate;
    private int discount;
    /** Creates a new instance of RadTestDisInfo */
    public RadTestDisInfo() {
    }
    public RadTestDisInfo(int tRId,int tId,int tCost,String tName, java.sql.Date dD) {
    this.testReqId = tRId;
    this.testId = tId;
    this.testCost = tCost;
    this.testname = tName;
    this.dDate = dD;
    }

       public RadTestDisInfo(int tRId,int tId,int tCost,String tName, java.sql.Date dD,int dis) {
    this.testReqId = tRId;
    this.testId = tId;
    this.testCost = tCost;
    this.testname = tName;
    this.dDate = dD;
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

    public int getTestCost() {
        return testCost;
    }

    public void setTestCost(int testCost) {
        this.testCost = testCost;
    }

    public String getTestname() {
        return testname;
    }

    public void setTestname(String testname) {
        this.testname = testname;
    }

    public java.sql.Date getDDate() {
        return dDate;
    }

    public void setDDate(java.sql.Date dDate) {
        this.dDate = dDate;
    }

    public int getDiscount() {
        return discount;
    }

    public void setDiscount(int discount) {
        this.discount = discount;
    }
}
