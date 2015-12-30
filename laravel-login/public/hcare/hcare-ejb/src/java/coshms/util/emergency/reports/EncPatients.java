/*
 * EncPatients.java
 *
 * Created on July 19, 2006, 12:46 AM
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
public class EncPatients implements Serializable{
 //   private int total;
    private int males;
    private int females;
    
    /**
     * Creates a new instance of EncPatients
     */
    public EncPatients() {
    }

    public int getTotal() {
        return this.males+this.females;
    }
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
