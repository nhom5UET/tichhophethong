
package coshms.ejb.domain;

import java.util.ArrayList;


/**
 * This is the business interface for Authentication enterprise bean.
 */
public interface AuthenticationRemoteBusiness 
{
    ArrayList getEmployeeInfo(String userName) throws java.rmi.RemoteException;

    java.util.ArrayList getAllAvailablePrevileges() throws java.rmi.RemoteException;

    java.util.ArrayList getAssignedPrevileges(String userName) throws java.rmi.RemoteException;

    boolean removePrevileges(String userName, int infId) throws java.rmi.RemoteException;

    boolean assignPrevileges(String userName, int infId) throws java.rmi.RemoteException;

    java.util.ArrayList getAllUsers() throws java.rmi.RemoteException;

    int checkUserNameAvailability(int empId , String userName) throws java.rmi.RemoteException;

    int checkUserIdDuplication(int empId, String userName) throws java.rmi.RemoteException;

    boolean setNewUserAccount(int empId, String userName, String password) throws java.rmi.RemoteException;

    boolean flushAllPrevileges(String userName) throws java.rmi.RemoteException;    

    int authenticatUser(String userName, String password) throws java.rmi.RemoteException;

    int authorizedUser(int userId, String interfaceName) throws java.rmi.RemoteException;
    
    boolean isAuthorized(int userId, String interfaceName) throws java.rmi.RemoteException;

    java.util.ArrayList getEmployeeLoginTag(int userId) throws java.rmi.RemoteException;
}
