/*
 * MedicinePrescription.java
 *
 * Created on May 11, 2006, 6:00 PM
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
public class MedicinePrescription implements Serializable
{
    private String mCode;
    private int qty;
    private String name;
    
    /** Creates a new instance of MedicinePrescription */
    public MedicinePrescription ()
    {
    }

    public String getMCode ()
    {
        return mCode;
    }

    public void setMCode (String mCode)
    {
        this.mCode = mCode;
    }

    public int getQty ()
    {
        return qty;
    }

    public void setQty (int qty)
    {
        this.qty = qty;
    }

    public String getName ()
    {
        return name;
    }

    public void setName (String name)
    {
        this.name = name;
    }
    
}
