/*
 * PatientNotFoundException.java
 *
 * Created on May 24, 2006, 2:57 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util;

/**
 *
 * @author Asif
 */
public class PatientNotFoundException extends Exception{    
    private Integer pid;
    /** Creates a new instance of PatientNotFoundException */
    public PatientNotFoundException(Integer pid) {
        this.pid = pid;
    }
    
    public String toString(){
        return "PatientNotFoundException : For PID = " + pid ;
    }    
}
