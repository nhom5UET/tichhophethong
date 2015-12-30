/*
 * PtTreatments.java
 *
 * Created on May 17, 2006, 9:25 PM
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
public class PtTreatments implements Serializable 
{
    
    /**
     * Creates a new instance of PtTreatments
     */
    public PtTreatments ()
    {
    }
    private int treatmentNo;
    private int emgEncNo;
    private int empId ;
    private String empName ;
    private String time;

    public int getTreatmentNo ()
    {
        return treatmentNo;
    }

    public void setTreatmentNo (int treatmentNo)
    {
        this.treatmentNo = treatmentNo;
    }

    public int getEmgEncNo ()
    {
        return emgEncNo;
    }

    public void setEmgEncNo (int emgEncNo)
    {
        this.emgEncNo = emgEncNo;
    }

    public String getEmpName ()
    {
        return empName;
    }

    public void setEmpName (String empName)
    {
        this.empName = empName;
    }

    public String getTime ()
    {
        return time;
    }

    public void setTime (String time)
    {
        this.time = time;
    }
    
    
    public int getEmpId ()
    {
        return empId;
    }

    public void setEmpId (int empId)
    {
        this.empId = empId;
    }

}
