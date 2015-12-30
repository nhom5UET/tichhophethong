/*
 * PatientTprb.java
 *
 * Created on May 10, 2006, 9:10 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.domain.emergency;

import java.io.Serializable;

/**
 *
 * @author Tahir
 */
public class PatientTprb implements Serializable
{
    private String bp;
    private String rRate;
    private String pulse;
    private String temp;
    private int emgEncNo;
    private int treatmentNo;
    
    /** Creates a new instance of PatientTprb */
    public PatientTprb ()
    {
    }

    public String getBp ()
    {
        return bp;
    }

    public void setBp (String bp)
    {
        this.bp = bp;
    }

    public String getRRate ()
    {
        return rRate;
    }

    public void setRRate (String rRate)
    {
        this.rRate = rRate;
    }

    public String getPulse ()
    {
        return pulse;
    }

    public void setPulse (String pulse)
    {
        this.pulse = pulse;
    }

    public String getTemp ()
    {
        return temp;
    }

    public void setTemp (String temp)
    {
        this.temp = temp;
    }
    
    public int getEmgEncNo ()
    {
        return emgEncNo;
    }

    public void setEmgEncNo (int emgEncNo)
    {
        this.emgEncNo = emgEncNo;
    }
    
    public int getTreatmentNo ()
    {
        return treatmentNo;
    }

    public void setTreatmentNo (int treatmentNo)
    {
        this.treatmentNo = treatmentNo;
    }
}
