/*
 * TPRBRecord.java
 *
 * Created on May 26, 2006, 6:17 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.emergency;

import java.io.Serializable;

/**
 *
 * @author Asif
 */
public class TPRBRecord implements Serializable{
    
    private Integer pid;
    private Integer emgEncNo;
        
    // private String bp;
    private Integer minBp;
    private Integer maxBp;
    
    private Integer pulse;
    private Integer temp;
    private Integer rRate;
    private Integer empId;
    private java.sql.Timestamp dTime;
       
    
    /** Creates a new instance of TPRBRecord */
    public TPRBRecord() {
    }

    public Integer getPid() {
        return pid;
    }

    public void setPid(Integer pid) {
        this.pid = pid;
    }

    public Integer getEmgEncNo() {
        return emgEncNo;
    }

    public void setEmgEncNo(Integer emgEncNo) {
        this.emgEncNo = emgEncNo;
    }

//    public String getBp() {
//        return bp;
//    }
//
//    public void setBp(String bp) {
//        this.bp = bp;
//    }

    public Integer getPulse() {
        return pulse;
    }

    public void setPulse(Integer pulse) {
        this.pulse = pulse;
    }

    public Integer getTemp() {
        return temp;
    }

    public void setTemp(Integer temp) {
        this.temp = temp;
    }

    public Integer getRRate() {
        return rRate;
    }

    public void setRRate(Integer rRate) {
        this.rRate = rRate;
    }

    public Integer getEmpId() {
        return empId;
    }

    public void setEmpId(Integer empId) {
        this.empId = empId;
    }

    public java.sql.Timestamp getDTime() {
        return dTime;
    }

    public void setDTime(java.sql.Timestamp dTime) {
        this.dTime = dTime;
    }

    public Integer getMinBp() {
        return minBp;
    }

    public void setMinBp(Integer minBp) {
        this.minBp = minBp;
    }

    public Integer getMaxBp() {
        return maxBp;
    }

    public void setMaxBp(Integer maxBp) {
        this.maxBp = maxBp;
    }


    
}
