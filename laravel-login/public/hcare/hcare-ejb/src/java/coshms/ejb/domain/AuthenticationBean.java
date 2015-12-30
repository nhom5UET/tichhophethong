package coshms.ejb.domain;


import coshms.util.domain.Employee;
import coshms.util.domain.Preveliges;
import java.util.ArrayList;
import javax.ejb.*;

import java.rmi.RemoteException;

import java.sql.CallableStatement;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Time;

import javax.sql.DataSource;

import java.util.ArrayList;

import javax.ejb.*;

import javax.naming.InitialContext;


/**
 * This is the bean class for the AuthenticationBean enterprise bean.
 * Created Jul 21, 2006 5:36:53 PM
 * @author Asif
 */
public class AuthenticationBean implements SessionBean, AuthenticationRemoteBusiness {
    private SessionContext context;
    private InitialContext ctx = null;
    private String jndiName = "java:/MySQLDB";
    private DataSource ds = null; 
    // <editor-fold defaultstate="collapsed" desc="EJB infrastructure methods. Click the + sign on the left to edit the code.">
    // TODO Add code to acquire and use other enterprise resources (DataSource, JMS, enterprise bean, Web services)
    // TODO Add business methods or web service operations
    /**
     * @see javax.ejb.SessionBean#setSessionContext(javax.ejb.SessionContext)
     */
    public void setSessionContext(SessionContext aContext) {
        context = aContext;
    }
    
    /**
     * @see javax.ejb.SessionBean#ejbActivate()
     */
    public void ejbActivate() {
        
    }
    
    /**
     * @see javax.ejb.SessionBean#ejbPassivate()
     */
    public void ejbPassivate() {
        
    }
    
    /**
     * @see javax.ejb.SessionBean#ejbRemove()
     */
    public void ejbRemove() {
        
    }
    // </editor-fold>
    
   
    public void ejbCreate() {}
    
    public int authenticatUser (String userName , String password)
    {
        CallableStatement cStmtLogin = null;
        ResultSet rsUser;
        Connection con = null;
        int result = 0;
        
        try
        {
            ctx = new InitialContext ();
            ds = (DataSource) ctx.lookup (jndiName);
           
            con = ds.getConnection ();
            
            cStmtLogin = con.prepareCall ("{ CALL emg_authenticateUser( ? , ? ) }");
            cStmtLogin.setString (1 , userName);
            cStmtLogin.setString (2 , password);
            
            rsUser = cStmtLogin.executeQuery ();
            
            while (rsUser.next ())
            {
                result = rsUser.getInt (1);
            }

             System.out.println ("emg_authenticateUser---->"+result);
        }
        catch (Exception e)
        {
            System.out.println ("authentication error: "+e.toString ());
            return 0;
        }
        finally
        {
            try
            {
                con.close ();
                cStmtLogin.close ();
            }
            catch (SQLException ex)
            {
                System.out.println (ex.toString ());
            }
        }
        return result;
    }
    public int authorizedUser (int userId , String interfaceName)
    {
        int authResult = 0 ;
        CallableStatement cStmt = null;
        ResultSet rs = null;
        Connection con = null;
        int result = 0;
       
        try
        {
            ctx = new InitialContext ();
            ds = (DataSource) ctx.lookup (jndiName);
            con = ds.getConnection ();
       
            cStmt = con.prepareCall ("{ CALL emg_authorizeUser( ? , ? ) }");
            cStmt.setInt    (1 , userId);
            cStmt.setString (2 , interfaceName);
             System.out.println (userId+": to autorize ************"+interfaceName);
            rs = cStmt.executeQuery ();
            while (rs.next ())
            {
                authResult = rs.getInt (1);
                System.out.println (authResult);
            }
            
            if (authResult > 0 )
            {
                System.out.print ("authorized");
            }
        }
        catch (Exception e)
        {
            System.out.println (e.toString ());
        }
        finally
        {
            try
            {
                con.close ();
                cStmt.close ();
                rs.close();
            }
            catch (SQLException ex)
            {
                System.out.println (ex.toString ());
            }
        }
        return authResult;
    }
    
    public boolean isAuthorized(int userId , String interfaceName)
    {
        System.out.println("INTERFACE NAME : = " + interfaceName);
                
        
        boolean authResult=false;
        CallableStatement cStmt = null;
        ResultSet rs = null;
        Connection con = null;
        int result = 0;
       
        try
        {
            ctx = new InitialContext ();
            ds = (DataSource) ctx.lookup (jndiName);
            con = ds.getConnection ();
       
            cStmt = con.prepareCall ("{ CALL emg_authorizeUser( ? , ? ) }");
            cStmt.setInt    (1 , userId);
            cStmt.setString (2 , interfaceName);
             System.out.println (userId+": to autorize ************"+interfaceName);
            rs = cStmt.executeQuery ();
            while (rs.next ())
            {
                authResult = rs.getBoolean(1);
                System.out.println (authResult);
            }
            
            if(authResult)
            {
                System.out.print ("authorized");
            }
        }
        catch (Exception e)
        {
            System.out.println (e.toString ());
        }
        finally
        {
            try
            {
                con.close ();
                cStmt.close ();
                rs.close();
            }
            catch (SQLException ex)
            {
                System.out.println (ex.toString ());
            }
        }
        return authResult;
    }
    
    public ArrayList getEmployeeInfo(String  userName) {
        CallableStatement cStmt = null , cStmtDesg = null;
        ResultSet rs = null , rsDesg = null;
        Connection con = null;
        
        ArrayList list = new ArrayList();
        String str = null;
        
        try {
            ctx = new InitialContext();
            ds = (DataSource) ctx.lookup(jndiName);
            con = ds.getConnection();
            cStmt = con.prepareCall("{ CALL dmn_getEmployeeInfoByUname(?) }");
            cStmt.setString(1, userName);
            rs = cStmt.executeQuery();            
            while (rs.next()) {
                Employee employee = new Employee();
                employee.setEmpId(rs.getInt(1));
                employee.setEmployeeName(rs.getString(2) +" "+rs.getString(3));
                
                cStmtDesg = con.prepareCall("{  call dmn_getDesignation(?) }");
                cStmtDesg.setInt(1, rs.getInt(4));
                rsDesg = cStmtDesg.executeQuery();
                
                while (rsDesg.next()) {
                    employee.setDesignation(rsDesg.getString(1));
                }
                list.add(employee);
            }
        } catch (Exception ex) {
            System.out.println(ex.toString());
        } finally {
            try {
                con.close();
                rs.close();
                cStmt.close();
            } catch (SQLException ex) {
                ex.printStackTrace();
            }
            
        }
        return list;
    }
    
    public ArrayList getAllAvailablePrevileges() {
        CallableStatement cStmt = null;
        ResultSet rs = null;
        Connection con = null;
        
        ArrayList list = new ArrayList();
        String str = null;
        
        try {
            ctx = new InitialContext();
            ds = (DataSource) ctx.lookup(jndiName);
            con = ds.getConnection();
            cStmt = con.prepareCall("{ CALL dmn_getAllPrevileges() }");
            //cStmt.setString(1, userName);
            rs = cStmt.executeQuery();
            
            while (rs.next()) {
                Preveliges preveliges = new Preveliges();
                preveliges.setInfId(rs.getInt(1));
                preveliges.setDescription(rs.getString(3));
                list.add(preveliges);
            }
        } catch (Exception e) {
            System.out.println(e.toString());
        } finally {
            try {
                con.close();
                rs.close();
                cStmt.close();
                
            } catch (SQLException ex) {
                ex.printStackTrace();
            }
        }
        
        return list;
    }
    
    public ArrayList getAssignedPrevileges(String userName) {
        ArrayList list = new ArrayList();
        CallableStatement cStmt = null , cStmtInf;
        ResultSet rs = null , rsInf = null;
        Connection con = null;
        
        String str = null;
        
        try {
            ctx = new InitialContext();
            ds = (DataSource) ctx.lookup(jndiName);
            con = ds.getConnection();
            cStmt = con.prepareCall("{ CALL dmn_getAssignedPrevileges(?) }");
            cStmt.setString(1, userName);
            rs = cStmt.executeQuery();
            
            while (rs.next()) {
                Preveliges preveliges = new Preveliges();
                preveliges.setInfId(rs.getInt(1));
                cStmtInf = con.prepareCall("{ CALL dmn_getInterfaceInfo(?) }");
                cStmtInf.setInt(1, rs.getInt(1));
                rsInf = cStmtInf.executeQuery();
                while (rsInf.next()) {
                    preveliges.setDescription(rsInf.getString(2));
                }
                list.add(preveliges);
            }
        } catch (Exception e) {
            System.out.println(e.toString());
        } finally {
            try {
                con.close();
                rs.close();
                cStmt.close();
                
            } catch (SQLException ex) {
                System.out.println(ex.toString());
            }
        }
        return list;
    }
    
    public boolean removePrevileges(String userName , int infId) {
        System.out.println("remove Called");
        CallableStatement procRemove = null;
        Connection con = null;
        boolean status;
        
        try {
            ctx = new InitialContext();
            ds = (DataSource) ctx.lookup(jndiName);
            con = ds.getConnection();
            procRemove = con.prepareCall("{ CALL dmn_removePrevileges(?,?) }");
            procRemove.setString(1, userName);
            procRemove.setInt   (2 , infId);
            procRemove.execute();
        } catch (Exception exp) {
            System.out.println(exp.toString());
            return false;
        } finally {
            try {
                con.close();
                procRemove.close();
            } catch (SQLException ex) {
                System.out.println(ex.toString());
                
            }
        }
        return true;
    }
    
    public boolean assignPrevileges(String userName , int infId) {
        CallableStatement procAssign = null;
        Connection con = null;
        boolean status;
        
        try {
            ctx = new InitialContext();
            ds = (DataSource) ctx.lookup(jndiName);
            con = ds.getConnection();
            procAssign = con.prepareCall("{ CALL dmn_assignPrevileges(?,?) }");
            procAssign.setString(1, userName);
            procAssign.setInt   (2 , infId);
          //  System.out.println("");
            procAssign.execute();
        } catch (Exception exp) {
            System.out.println(exp.toString());
            return false;
        } finally {
            try {
                con.close();
                procAssign.close();
            } catch (SQLException ex) {
                System.out.println(ex.toString());
                
            }
        }
        return true;
    }
    
    public ArrayList getAllUsers() {
        CallableStatement cStmt = null , cStmtDesg = null;
        ResultSet rs = null , rsDesg = null;
        Connection con = null;
        
        ArrayList list = new ArrayList();
        String str = null;
        System.out.println("calling All Users#####################################");
        try {
            ctx = new InitialContext();
            ds = (DataSource) ctx.lookup(jndiName);
            System.out.println("lookup done#####################################");
            con = ds.getConnection();
            System.out.println("con done#####################################");
            cStmt = con.prepareCall("{ CALL dmn_getAllUsers() }");
            System.out.println("Preparing#####################################");
            rs = cStmt.executeQuery();
            
            while (rs.next()) {
                Employee employee = new Employee();
                employee.setUserName(rs.getString(1));
                //System.out.println(rs.getString(1)+"########################################");
                list.add(employee);
            }
            System.out.println("Done All Users#####################################");
        } catch (Exception ex) {
            System.out.println(ex.toString());
               // ex.printStackTrace();
        } finally {
            try {
                con.close();
                rs.close();
                cStmt.close();
            } catch (SQLException ex) {
                System.out.println(ex.toString());
            }
            
        }
        return list;
    }
    
    public int checkUserNameAvailability(int empId ,  String userName ) {
        CallableStatement cStmt = null , cStmtId = null;
        ResultSet rs = null , rsId = null;
        Connection con = null;
        
        ArrayList list = new ArrayList();
        String result = null;
        int retResult = 0;
        
        try 
        {
            ctx = new InitialContext();
            ds = (DataSource) ctx.lookup(jndiName);
            con = ds.getConnection();
            //check only for unique user name
            
            cStmt = con.prepareCall("{ CALL dmn_isUNameExist(?,?,?) }");
            cStmt.setInt(1 , empId);
            cStmt.setString(2, userName);
            cStmt.setBoolean(3,false);
            rs = cStmt.executeQuery();
            
            while (rs.next()) 
            {
                if (rs.getString(1).equals("0")) 
                {
                    retResult = 0;
                } 
                else if (rs.getString(1).equals("1")) 
                {
                    retResult = 1;
                }
            }
        } catch (Exception e) {
            System.out.println(e.toString());
        } finally {
            try {
                con.close();
                cStmt.close();
            } catch (SQLException ex) {
                ex.printStackTrace();
            }
        }
        return retResult ;
    }
    
    public int checkUserIdDuplication(int empId ,  String userName ) 
    {
        CallableStatement cStmt = null , cStmtId = null;
        ResultSet rs = null , rsId = null;
        Connection con = null;
        
        ArrayList list = new ArrayList();
        String result = null;
        int retResult = 0;
        
        try {
            ctx = new InitialContext();
            ds = (DataSource) ctx.lookup(jndiName);
            con = ds.getConnection();
            //check only for unique user name
            cStmt = con.prepareCall("{ CALL dmn_isUNameExist(?,?,?) }");
            cStmt.setInt(1 , empId);
            cStmt.setString(2, userName);
            cStmt.setBoolean(3,true);
            rs = cStmt.executeQuery();
            
            while (rs.next()) 
            {
                if (rs.getString(1).equals("0")) 
                {
                    retResult = 0;
                } 
                else if (rs.getString(1).equals("1")) 
                {
                    retResult = 1;
                }
            }
        } catch (Exception e) {
            System.out.println(e.toString());
        } finally {
            try {
                con.close();
                cStmt.close();
            } catch (SQLException ex) {
                ex.printStackTrace();
            }
        }
        return retResult;
    }
    public boolean setNewUserAccount (int empId , String userName , String password)
    {
        CallableStatement proc = null , cStmtId = null;
        ResultSet rs = null , rsId = null;
        Connection con = null;
        
        ArrayList list = new ArrayList();
        String result = null;
        int retResult = 0;
        
        try 
        {
            ctx = new InitialContext();
            ds = (DataSource) ctx.lookup(jndiName);
            con = ds.getConnection();
            
            //check only for unique user name
            
            proc = con.prepareCall("{ call dmn_setNewUserAccount(?,?,?) }");
            proc.setInt(1 , empId);
            proc.setString(2, userName);
            proc.setString(3, password);
            proc.execute();
        }
        catch (Exception e)
        {
            System.out.println(e.toString());
            return false;
        }
        finally 
        {
            try 
            {
                con.close();
                rs.close();
                proc.close();
            }
            catch (Exception ex)
            {
                System.out.println(ex.toString());
                
            }
        }
        return true;
    }
    public boolean flushAllPrevileges ( String userName )
    {
        CallableStatement proc = null , cStmtId = null;
        ResultSet rs = null , rsId = null;
        Connection con = null;
        
        ArrayList list = new ArrayList();
        String result = null;
        int retResult = 0;
        
        try 
        {
            ctx = new InitialContext();
            ds = (DataSource) ctx.lookup(jndiName);
            con = ds.getConnection();
            proc = con.prepareCall("{ call dmn_flushAllPreveliges(?) }");
            proc.setString(1 , userName);
            proc.execute();
        }
        catch (Exception e)
        {
            System.out.println(e.toString());
            return false;
        }
        finally 
        {
            
            try
            {
                con.close();
                proc.close();
            }
            catch (Exception ex)
            {
                System.out.println (ex.toString());
            }
        }
        return true;
    }
    
    public ArrayList getEmployeeLoginTag (int userId)
    {
        CallableStatement cStmt = null , cStmtDesg = null;
        ResultSet rs = null , rsDesg = null;
        Connection con = null;
        
        ArrayList list = new ArrayList();
        String str = null;
        
        try {
            ctx = new InitialContext();
            ds = (DataSource) ctx.lookup(jndiName);
            con = ds.getConnection();
            cStmt = con.prepareCall("{ CALL dmn_getEmployeeByUid(?) }");
            cStmt.setInt(1, userId);
            rs = cStmt.executeQuery();            
            while (rs.next()) 
            {
                Employee employee = new Employee ();
                employee.setEmpId(rs.getInt(1));
                employee.setEmployeeName(rs.getString(2));
                employee.setDesignation(rs.getString(3));
                list.add(employee);
            }
        }
        catch (Exception e)
        {
            System.out.println(e.toString());
        }
        finally 
        {
            try {
                con.close(); 
                cStmt.close();
                rs.close();
            } catch (SQLException ex) {
                System.out.println(ex.toString());
            }
        }
        return list ;
    }
}
