/*
 * TreatmentHeading.java
 *
 * Created on June 29, 2006, 4:02 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.emergency;

import java.io.Serializable;
import java.sql.Timestamp;

/**
 *
 * @author Administrator
 */

public class TreatmentHeading implements Serializable{
    private Integer treatmentNo;
    private Timestamp dTime;
    private String drName;
    
    /** Creates a new instance of TreatmentHeading */
    public TreatmentHeading() {
    }

    public Timestamp getDTime() {
        return dTime;
    }

    public void setDTime(Timestamp dTime) {
        this.dTime = dTime;
    }

    public Integer getTreatmentNo() {
        return treatmentNo;
    }

    public void setTreatmentNo(Integer treatmentNo) {
        this.treatmentNo = treatmentNo;
    }

    public String getDrName() {
        return drName;
    }

    public void setDrName(String drName) {
        this.drName = drName;
    }
    
}
