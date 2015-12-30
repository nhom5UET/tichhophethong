/*
 * MedicineStock.java
 *
 * Created on May 13, 2006, 8:05 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.emergency;

import java.io.Serializable;

/**
 *
 * @author Tahir
 */
public class MedicineStock implements Serializable 
{
    private int qty ;
    private String mCode ;
    private String name ;
    private String empName ;
    private String date ;
    private String time ;
    /** Creates a new instance of MedicineStock */
    public MedicineStock ()
    {
    }

    public int getQty() {
        return qty;
    }

    public void setQty(int qty) {
        this.qty = qty;
    }

    public String getMCode() {
        return mCode;
    }

    public void setMCode(String mCode) {
        this.mCode = mCode;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getEmpName() {
        return empName;
    }

    public void setEmpName(String empName) {
        this.empName = empName;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public String getTime() {
        return time;
    }

    public void setTime(String time) {
        this.time = time;
    }

   
    
}
