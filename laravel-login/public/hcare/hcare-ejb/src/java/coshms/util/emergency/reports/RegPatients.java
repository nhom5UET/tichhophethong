/*
 * RegPatients.java
 *
 * Created on July 19, 2006, 12:44 AM
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
public class RegPatients implements Serializable{
    //private int total;
    private int males;
    private int females;    
    
    /**
     * Creates a new instance of RegPatients
     */
    public RegPatients() {
    }

    public int getTotal() {
        return this.males+this.females;
    }

//    public void setTotal(int total) {
//        this.total = total;
//    }

    public int getMales() {
        return males;
    }

    public void setMales(int males) {
        this.males = males;
    }

    public int getFemales() {
        return females;
    }

    public void setFemales(int females) {
        this.females = females;
    }
    
    
    
}
