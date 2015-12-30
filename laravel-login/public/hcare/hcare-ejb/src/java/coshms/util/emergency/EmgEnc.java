/*
 * EmgEnc.java
 *
 * Created on May 20, 2006, 4:26 PM
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
public class EmgEnc implements Serializable{
    private Integer pid;
    private Integer mlc;
    private String broughtBy;
    private String phNo;
    private Boolean isRefered;
    
    private String refName;
    private String refNotes;
    private String refPhNo;
    
    private Integer empId;
    
    /** Creates a new instance of EmgEnc */
    public EmgEnc() {
    }

    public Integer getMlc() {
        return mlc;
    }

    public void setMlc(Integer mlc) {
        this.mlc = mlc;
    }

    public String getBroughtBy() {
        return broughtBy;
    }

    public void setBroughtBy(String broughtBy) {
        this.broughtBy = broughtBy;
    }

    public String getPhNo() {
        return phNo;
    }

    public void setPhNo(String phNo) {
        this.phNo = phNo;
    }

    public Boolean getIsRefered() {
        return isRefered;
    }

    public void setIsRefered(Boolean isRefered) {
        this.isRefered = isRefered;
    }

    public String getRefName() {
        return refName;
    }

    public void setRefName(String refName) {
        this.refName = refName;
    }

    public String getRefNotes() {
        return refNotes;
    }

    public void setRefNotes(String refNotes) {
        this.refNotes = refNotes;
    }

    public String getRefPhNo() {
        return refPhNo;
    }

    public void setRefPhNo(String refPhNo) {
        this.refPhNo = refPhNo;
    }

    public Integer getPid() {
        return pid;
    }

    public void setPid(Integer pid) {
        this.pid = pid;
    }

    public Integer getEmpId() {
        return empId;
    }

    public void setEmpId(Integer empId) {
        this.empId = empId;
    }
    
    
    
}
