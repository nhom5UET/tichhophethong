
package coshms.ejb.emergency;

import coshms.domain.exception.TreatmentNotFoundException;
import coshms.util.emergency.EmgEnc;
import coshms.util.emergency.EncounterDetail;
import coshms.util.emergency.Patient;
import coshms.util.emergency.TPRBRecord;
import coshms.util.emergency.Treatment;
import java.util.ArrayList;


/**
 * This is the business interface for RegistrationMedication enterprise bean.
 */
public interface RegistrationMedicationRemoteBusiness {
    
    ArrayList getAllMLC() throws java.rmi.RemoteException;
    
    void emgEncounter(EmgEnc enc) throws java.rmi.RemoteException;
    
    Integer emgEncounterFileId(EmgEnc enc) throws java.rmi.RemoteException;

    Patient getPtForTPRB(Integer pid) throws java.rmi.RemoteException;

    void setTPRB(coshms.util.emergency.TPRBRecord tprb) throws java.rmi.RemoteException;

    TPRBRecord getLatestTPRB(Integer pid, Integer emgEncNo) throws java.rmi.RemoteException;

    ArrayList getAllTPRB(Integer pid, Integer emgEncNo) throws java.rmi.RemoteException;

    Integer performTreatment(Treatment treatment) throws java.rmi.RemoteException;

    Treatment getTreatment(Integer pid, Integer emgEncNo, Integer treatmentNo) throws java.rmi.RemoteException,TreatmentNotFoundException;

    Patient getPatient(Integer pid, Integer emgEncNo) throws java.rmi.RemoteException;

    ArrayList getAllEncsHeading(Integer pid) throws java.rmi.RemoteException;

    ArrayList getAllTreatmentsHeading(Integer pid, Integer emgEncNo) throws java.rmi.RemoteException;

    EncounterDetail getEncounterDetail(int pid, int emgEncNo) throws java.rmi.RemoteException;
    
}
