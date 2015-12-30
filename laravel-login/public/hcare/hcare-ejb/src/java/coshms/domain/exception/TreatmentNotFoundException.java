/*
 * TreatmentNotFoundException.java
 *
 * Created on June 11, 2006, 6:40 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.domain.exception;

/**
 *
 * @author Asif
 */
public class TreatmentNotFoundException extends Exception{
    
    /** Creates a new instance of TreatmentNotFoundException */
    public TreatmentNotFoundException() {
    }
    
    public TreatmentNotFoundException(String message) {
        super(message);
    }       
    
    public TreatmentNotFoundException(Integer pid, Integer encNo, Integer treatmentNo) {        
        super("TreatmetnNotFoundException Occured For: Patient ID="+ 
                pid.toString()+" Encounter Number = "+
                encNo.toString()+" Treatment No = "+
                treatmentNo.toString() +" >>>>>>>> At least One is Invalid ");
    }
}