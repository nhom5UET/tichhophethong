/*
 * DBAccess.java
 * Created on 16 May 2006, 23:48
 */

package coshms.util;

import java.sql.CallableStatement;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import javax.naming.InitialContext;
import javax.sql.DataSource;
/*
 * @author asif
 */
/* NOTE :
 * Becareful while initializing this class instance,
 *its creates connection as soon, its instance instantiate
 *only connection is made, expilictly set other parameters (like proc, etc)
 *
 * caution:
 * initializing its instance very earlier will open the connection for long, so instantiate when needed
 * must call prepreCallString()  before calling closeConStmt
 *
 */

public class DBAccess {
    private String jndiName = "java:/MySQLDB";
    private DataSource ds = null;
    public CallableStatement proc=null;
    private InitialContext ctx = null;
    public Connection con = null;
    
    public DBAccess(){
        try {
            Class.forName("com.mysql.jdbc.Driver").newInstance();
            //con = DriverManager.getConnection("jdbc:mysql://192.168.0.2:3306/hisdb?user=root&password=");
            con = DriverManager.getConnection("jdbc:mysql://localhost:3306/hisdb?user=root&password=");
            if(con==null)
                throw new SQLException();
        } catch(ClassNotFoundException cnfe){cnfe.printStackTrace();} catch(InstantiationException ie){ie.printStackTrace();} catch(IllegalAccessException iae){iae.printStackTrace();} catch(SQLException ex ){
            System.out.println("SQLException: " + ex.getMessage());
            System.out.println("SQLState: " + ex.getSQLState());
            System.out.println("VendorError: " + ex.getErrorCode());
            
            try {
                Class.forName("com.mysql.jdbc.Driver").newInstance();
                con = DriverManager.getConnection("jdbc:mysql://localhost:3306/hisdb?user=root&password=pakistan");
                if(con==null)
                    throw new SQLException();
            } catch(ClassNotFoundException cnfe){cnfe.printStackTrace();} catch(InstantiationException ie){ie.printStackTrace();} catch(IllegalAccessException iae){iae.printStackTrace();} catch(SQLException ex2 ){
                System.out.println("SQLException: " + ex2.getMessage());
                System.out.println("SQLState: " + ex2.getSQLState());
                System.out.println("VendorError: " + ex2.getErrorCode());
            }
            
            
            
        }
        
//       try{
//            ctx = new InitialContext();
//            ds = (DataSource) ctx.lookup(jndiName);
//            con=ds.getConnection();
//        }
//        catch(NamingException ne){ne.printStackTrace();}
//        catch(SQLException sqlEx){sqlEx.printStackTrace();}
    }
    
    public void prepareCallString(String str){
        try{
            proc = con.prepareCall(str);
        }catch(SQLException sqlEx){sqlEx.printStackTrace();}
    }
    
    public void closeStmt(){
        try{
            proc.close();
        }catch(SQLException sqlEx){
            sqlEx.printStackTrace();
        }        
    }
    
    public void startTransaction(){
        try{
            con.setAutoCommit(false);
        }catch(SQLException sqlEx){
            sqlEx.printStackTrace();
        }
    }
    
    public void endTransaction(){
        try{
            con.commit();
        }catch(SQLException sqlEx){
            sqlEx.printStackTrace();
        }
    }
    
    
    public void closeStmtCon(){
        try{
            proc.close();
            con.close();
        }catch(SQLException sqlEx){
            sqlEx.printStackTrace();
        }
    }
}