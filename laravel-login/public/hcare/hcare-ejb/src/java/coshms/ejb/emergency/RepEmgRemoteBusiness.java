
package coshms.ejb.emergency;

import coshms.util.emergency.reports.EncPatients;
import coshms.util.emergency.reports.RegPatients;
import java.sql.Date;
import java.util.ArrayList;


/**
 * This is the business interface for RepEmg enterprise bean.
 */
public interface RepEmgRemoteBusiness {
    RegPatients RegPatientBw(Date fromDate, Date toDate) throws java.rmi.RemoteException;
    EncPatients PatientsEncBw(Date fromDate, Date toDate) throws java.rmi.RemoteException;

    ArrayList mlcCasesBw(Date fromDate, Date toDate) throws java.rmi.RemoteException;

    ArrayList regFromEachCityBw(Date fromDate, Date toDate) throws java.rmi.RemoteException;

    ArrayList diseasesDiagBw(Date fromDate, Date toDate) throws java.rmi.RemoteException;   
    
    ArrayList diseasesDiagBw(String[] diseaseList, Date fromDate, Date toDate) throws java.rmi.RemoteException;   
    
}
