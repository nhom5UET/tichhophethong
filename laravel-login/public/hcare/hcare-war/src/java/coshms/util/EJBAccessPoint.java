/*
 * EJBAccessPoint.java
 *
 * Created on June 23, 2006, 9:36 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util;

/**
 *
 * @author Asif
 */
public class EJBAccessPoint {
    
    /** Creates a new instance of EJBAccessPoint */
    public EJBAccessPoint() {
    }

    private coshms.util.ServiceLocator serviceLocator;

    private coshms.util.ServiceLocator getServiceLocator() {
        if (serviceLocator == null) {
            serviceLocator = new coshms.util.ServiceLocator();
        }
        return serviceLocator;
    }

    public coshms.ejb.emergency.RegistrationMedicationRemote lookupRegistrationMedicationBean() {
        try {
            return ((coshms.ejb.emergency.RegistrationMedicationRemoteHome) getServiceLocator().getRemoteHome("java:comp/env/ejb/emergency/RegistrationMedicationBean",coshms.ejb.emergency.RegistrationMedicationRemoteHome.class)).create();
        } catch(javax.naming.NamingException ne) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,ne);
            throw new RuntimeException(ne);
        } catch(javax.ejb.CreateException ce) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,ce);
            throw new RuntimeException(ce);
        } catch(java.rmi.RemoteException re) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,re);
            throw new RuntimeException(re);
        }
    }

    public coshms.ejb.domain.DiseaseRemote lookupDiseaseBean() {
        try {
            return ((coshms.ejb.domain.DiseaseRemoteHome) getServiceLocator().getRemoteHome("java:comp/env/ejb/domain/DiseaseBean",coshms.ejb.domain.DiseaseRemoteHome.class)).create();
        } catch(javax.naming.NamingException ne) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,ne);
            throw new RuntimeException(ne);
        } catch(javax.ejb.CreateException ce) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,ce);
            throw new RuntimeException(ce);
        } catch(java.rmi.RemoteException re) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,re);
            throw new RuntimeException(re);
        }
    }

    public coshms.ejb.domain.EmployeeRemote lookupEmployeeBean() {
        try {
            return ((coshms.ejb.domain.EmployeeRemoteHome) getServiceLocator().getRemoteHome("java:comp/env/ejb/domain/EmployeeBean",coshms.ejb.domain.EmployeeRemoteHome.class)).create();
        } catch(javax.naming.NamingException ne) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,ne);
            throw new RuntimeException(ne);
        } catch(javax.ejb.CreateException ce) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,ce);
            throw new RuntimeException(ce);
        } catch(java.rmi.RemoteException re) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,re);
            throw new RuntimeException(re);
        }
    }

    public coshms.ejb.domain.RegisterPatientRemote lookupRegisterPatientBean() {
        try {
            return ((coshms.ejb.domain.RegisterPatientRemoteHome) getServiceLocator().getRemoteHome("java:comp/env/ejb/domain/RegisterPatientBean",coshms.ejb.domain.RegisterPatientRemoteHome.class)).create();
        } catch(javax.naming.NamingException ne) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,ne);
            throw new RuntimeException(ne);
        } catch(javax.ejb.CreateException ce) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,ce);
            throw new RuntimeException(ce);
        } catch(java.rmi.RemoteException re) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,re);
            throw new RuntimeException(re);
        }
    }

    public coshms.ejb.domain.WardRemote lookupWardBean() {
        try {
            return ((coshms.ejb.domain.WardRemoteHome) getServiceLocator().getRemoteHome("java:comp/env/ejb/domain/WardBean",coshms.ejb.domain.WardRemoteHome.class)).create();
        } catch(javax.naming.NamingException ne) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,ne);
            throw new RuntimeException(ne);
        } catch(javax.ejb.CreateException ce) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,ce);
            throw new RuntimeException(ce);
        } catch(java.rmi.RemoteException re) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,re);
            throw new RuntimeException(re);
        }
    }

    public coshms.ejb.emergency.RepEmgRemote lookupRepEmgBean(){
        try {
            return ((coshms.ejb.emergency.RepEmgRemoteHome) getServiceLocator().getRemoteHome("java:comp/env/ejb/emergency/RepEmgBean",coshms.ejb.emergency.RepEmgRemoteHome.class)).create();
        } catch(javax.naming.NamingException ne) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,ne);
            throw new RuntimeException(ne);
        } catch(javax.ejb.CreateException ce) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,ce);
            throw new RuntimeException(ce);
        } catch(java.rmi.RemoteException re) {
            java.util.logging.Logger.getLogger(getClass().getName()).log(java.util.logging.Level.SEVERE,"exception caught" ,re);
            throw new RuntimeException(re);
        }
    }
    
}
