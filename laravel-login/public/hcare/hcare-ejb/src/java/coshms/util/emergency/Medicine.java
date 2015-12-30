/*
 * Medicine.java
 *
 * Created on June 9, 2006, 10:57 AM
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
public class Medicine implements Serializable{
    
    private String mCode;
    private Integer timing;
    private Integer qty;
    private Integer period;
    private String comments;
        
    // use this field when getting data back from db.
    private String mName;
    
    /** Creates a new instance of Medicine */        
    public Medicine() {
    }

    public String getMCode() {
        return mCode;
    }

    public void setMCode(String mCode) {
        this.mCode = mCode;
    }

    public Integer getTiming() {
        return timing;
    }

    public void setTiming(Integer timing) {
        this.timing = timing;
    }

    public Integer getQty() {
        return qty;
    }

    public void setQty(Integer qty) {
        this.qty = qty;
    }

    public Integer getPeriod() {
        return period;
    }

    public void setPeriod(Integer period) {
        this.period = period;
    }

    public String getComments() {
        return comments;
    }

    public void setComments(String comments) {
        this.comments = comments;
    }

    public String getMName() {
        return mName;
    }

    public void setMName(String mName) {
        this.mName = mName;
    }   
}
