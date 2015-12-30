
package coshms.ejb.domain;

import java.util.ArrayList;


/**
 * This is the business interface for Disease enterprise bean.
 */
public interface DiseaseRemoteBusiness {
    ArrayList getDiseaseLike(String diseaseSubString) throws java.rmi.RemoteException;
    ArrayList getAllDiseases() throws java.rmi.RemoteException;
    
}
