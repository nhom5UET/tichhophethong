/*
 * EncounterDetail.java
 *
 * Created on July 12, 2006, 5:54 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.emergency;

import java.io.Serializable;
import java.sql.Timestamp;
/**
 *
 * @author Asif
 */
public class EncounterDetail implements Serializable{
    private String mlc;
    
    private String broughtBy;
    private String phNo;
    private boolean isRefered;
    private Timestamp encDateTime;
    private String refName;
    private String refNotes;
    private String refPhNo;
    private int fileId;
    
    /** Creates a new instance of EncounterDetail */
    public EncounterDetail() {
    }

    public String getMlc() {
        return mlc;
    }

    public void setMlc(String mlc) {
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

    public boolean isIsRefered() {
        return isRefered;
    }

    public void setIsRefered(boolean isRefered) {
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

    public int getFileId() {
        return fileId;
    }

    public void setFileId(int fileId) {
        this.fileId = fileId;
    }

    public Timestamp getEncDateTime() {
        return encDateTime;
    }

    public void setEncDateTime(Timestamp encDateTime) {
        this.encDateTime = encDateTime;
    }   
}
