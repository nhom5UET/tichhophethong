/*
 * Patient.java
 *
 * Created on May 11, 2006, 12:17 AM
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
public class Patient implements Serializable
{
    
    private int pid;
    private String firstName;
    private String lastName;
    private String fatherName;
    private String gender;
    private String dateOfBirth;
    private String streerAddress;
    private String town;
    private String city;
  
    /** Creates a new instance of Patient */
    public Patient ()
    {
    }
    
    /*
     *  Setter Methods
     */
    
    public void setPid (int id)
    {
        this.pid = id ;
    }
    
    public void setFirstName (String fname)
    {
        this.firstName = fname;
    }
    
    public void setLastName (String lname)
    {
        this.lastName = lname;
    }
    
    public void setFatherName (String fathrName)
    {
        this.fatherName = fathrName;
    }
    
    public void setGender (String gen)
    {
        this.gender = gen;
    }
    
    
    public void setDob (String dob)
    {
        this.dateOfBirth = dob;
    }
    
    public void setStreetAddress (String street)
    {
        this.streerAddress = street;
    }
    
    public void setTown (String twn)
    {
        this.town= twn;
    }
    
    public void setCity (String cty)
    {
        this.city = cty;
    }
    
    /*
     *  Getter Methods
     */
    
    public int getPid ()
    {
        return  this.pid;
    }
    
    public String getFirstName ()
    {
        return this.firstName ;
    }
    
    public String getLastName ()
    {
        return this.lastName ;
    }
    
    public String getFatherName ()
    {
        return this.fatherName ;
    }
    
    public String getGender ()
    {
        return this.gender;
    }
    
    public String getDob ()
    {
        return this.dateOfBirth;
    }
    
    public String getStreetAddress ()
    {
        return this.streerAddress;
    }
    
    public String getTown ()
    {
        return this.town;
    }
    
    public String getCity ()
    {
        return this.city;
    }
  
}
