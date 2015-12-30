/*
 * DiseaseDiag.java
 *
 * Created on August 12, 2006, 2:02 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.emergency.reports;

import java.io.Serializable;

/**
 *
 * @author Asif
 */
public class DiseaseDiag implements Serializable{
    private String dCode;
    private String name;
    private int count;
    
    /** Creates a new instance of DiseaseDiag */
    public DiseaseDiag() {
    }

    public String getDCode() {
        return dCode;
    }

    public void setDCode(String dCode) {
        this.dCode = dCode;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public int getCount() {
        return count;
    }

    public void setCount(int count) {
        this.count = count;
    }
    
}
