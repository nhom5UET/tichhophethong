/*
 * EncHeading.java
 *
 * Created on June 29, 2006, 4:03 PM
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
public class EncHeading implements Serializable{
    private Integer emgEncNo;
    private Timestamp dTime;
    private String mlcType;
    
    /** Creates a new instance of EncHeading */
    public EncHeading() {
    }
    
    public Integer getEmgEncNo(){
        return emgEncNo;
    }
    
    public void setEmgEncNo(Integer emgEncNo) {
        this.emgEncNo = emgEncNo;
    }

    public Timestamp getDTime() {
        return dTime;
    }

    public void setDTime(Timestamp dTime) {
        this.dTime = dTime;
    }
    
    public String getMlcType() {
        return mlcType;
    }
    
    public void setMlcType(String mlcType) {
        this.mlcType = mlcType;
    }
    
}