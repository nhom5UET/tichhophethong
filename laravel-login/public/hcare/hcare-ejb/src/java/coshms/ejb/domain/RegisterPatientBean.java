package coshms.ejb.domain;

import coshms.util.DBAccess;
import coshms.util.domain.Patient;
import coshms.util.PatientNotFoundException;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.sql.Blob;
import java.sql.ResultSet;
import java.sql.SQLException;
import javax.ejb.*;
import java.sql.Types;
import java.util.ArrayList;

/**
 * Created May 10, 2006 1:01:54 PM
 * @author project
 */

public class RegisterPatientBean implements SessionBean, RegisterPatientRemoteBusiness {
    private SessionContext context;
    private DBAccess db=null;
    
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

    public void ejbCreate() {
    }
    
    public String getString() {
        return "HELLO FROM SB";
    }
    
    public Integer registerPatient(Patient pt){
        String strRs = null;
        ResultSet rs = null,rs2=null;
        int pid=0;
        db=new DBAccess();
        
        db.prepareCallString("{call dmn_setPatient (?,?,?,?,?,?,?,?,?,?,?,?) }");
        
        try {
            db.proc.setString(1,pt.getFirstName());
            db.proc.setString(2,pt.getLastName());
            db.proc.setString(3,pt.getFatherName());
            db.proc.setString(4,pt.getGender());
            db.proc.setDate(5,pt.getDob());            
            db.proc.setString(6,pt.getStreetAddress());
            db.proc.setString(7,pt.getTown());
            db.proc.setString(8,pt.getCity());            
            ////////////////
            if(pt.isPicExist()){
                File image = pt.getPicture();
                FileInputStream fis = new FileInputStream(image);
                db.proc.setBinaryStream(9, fis, ( int )image.length());
            }else{
                db.proc.setBinaryStream(9,null,0);
            }
            /////////////
            db.proc.setInt(10,Integer.parseInt(pt.getEmpId().toString()));
            db.proc.setString(11,pt.getCnic());


            System.out.println("------------->"+pt.getCnic());

            db.proc.registerOutParameter(12,Types.INTEGER);
            db.proc.execute();
            pid= db.proc.getInt(12);
        } catch (Exception ex) {
            System.out.println(" \n\n START OF EXCEPTION PRINTING RELATED TO DB \n\n " + ex.toString()); } 
        db.closeStmtCon();
        db=null;
        return new Integer(pid);
    }
    
    public Patient getPatient(Integer pid){
////        Patient pt=null;
////        String pidStr = pid.toString();
////        ResultSet rs=null;
////        db = new DBAccess();
////        db.prepareCallString("{call dmn_getPatient(?)}");
////        try{
////            db.proc.setInt(1,pid.intValue());
////            db.proc.execute();
////            rs = db.proc.getResultSet();
////            
////            if (rs.next()) rs.beforeFirst();
////            else throw new PatientNotFoundException(pid);
////            
////            int size = 0;
////            while(rs.next()){
////                pt = new Patient();
////                pt.setPid(pid);
////                pt.setFirstName(rs.getString(1));
////                pt.setLastName(rs.getString(2));
////                pt.setFatherName(rs.getString(3));
////                pt.setGender(rs.getString(4));
////                pt.setDob(rs.getDate(5));
////                pt.setRegDate(rs.getDate(6));
////                pt.setStreetAddress(rs.getString(7));
////                pt.setTown(rs.getString(8));
////                pt.setCity(rs.getString(9));                
////                Blob blob = rs.getBlob(10);     //10 is Picture
////                if(blob==null){                    
////                    pt.setPicExist(false);
////                    System.out.println( "RegisterPatient Bean: SET PIC = FALSE" );
////                }else{
////                    size = Integer.parseInt(Long.valueOf(blob.length()).toString());
////                    pt.setPicSize(size);
////                    byte by1[] = new byte[size];
////                    InputStream in = blob.getBinaryStream();
////                    in.read( by1, 0, size );
////                    pt.setPicByte(by1);
////                    pt.setPicExist(true);
////                }
////            }
////            rs.close();
////        }catch(SQLException sqlEx){sqlEx.printStackTrace();}
////        catch(IOException io){io.printStackTrace();}        
////        db.closeStmtCon();
////        db=null;
////        return pt;
        
        
        
        Patient pt=null;      
        String pidStr = pid.toString();
        ResultSet rs=null;
        db = new DBAccess();
        db.prepareCallString("{call dmn_getPatient(?)}");
        try{
            db.proc.setInt(1,pid.intValue());
            db.proc.execute();
            rs = db.proc.getResultSet();
            
//            if (rs.next()) rs.beforeFirst();
//            else throw new PatientNotFoundException(pid);
            
            int size = 0;
            while(rs.next()){
                pt = new Patient();
                pt.setPid(pid);
                pt.setFirstName(rs.getString(1));
                pt.setLastName(rs.getString(2));
                pt.setFatherName(rs.getString(3));
                pt.setGender(rs.getString(4));
                pt.setDob(rs.getDate(5));
                pt.setRegDate(rs.getDate(6));
                pt.setStreetAddress(rs.getString(7));
                pt.setTown(rs.getString(8));
                pt.setCity(rs.getString(9));                
                Blob blob = rs.getBlob(10);     //10 is Picture
                if(blob==null){                    
                    pt.setPicExist(false);
                    System.out.println( "RegisterPatient Bean: SET PIC = FALSE" );
                }else{
                    size = Integer.parseInt(Long.valueOf(blob.length()).toString());
                    pt.setPicSize(size);
                    byte by1[] = new byte[size];
                    InputStream in = blob.getBinaryStream();
                    in.read( by1, 0, size );
                    pt.setPicByte(by1);
                    pt.setPicExist(true);
                }
                pt.setCnic(rs.getString(11));
            }
            rs.close();
        }catch(SQLException sqlEx){sqlEx.printStackTrace();}
        catch(IOException io){io.printStackTrace();}        
        db.closeStmtCon();
        db=null;
        return pt;
    }    
    public void editPtInfo(Patient pt) {
        db=new DBAccess();
        db.prepareCallString("{call dmn_ptUpdate(?,?,?,?,?,?,?,?,?,?,?)}"); 
        //pid, firstName, lastName, fatherName, gender, dob, streetAddress, town, city, empId : 10 
        try{
            db.proc.setObject(1,pt.getPid());
            db.proc.setString(2,pt.getFirstName());
            db.proc.setString(3,pt.getLastName());
            db.proc.setString(4,pt.getFatherName());
            db.proc.setString(5,pt.getGender());
            db.proc.setDate(6,pt.getDob());
            db.proc.setString(7,pt.getStreetAddress());
            db.proc.setString(8,pt.getTown());
            db.proc.setString(9,pt.getCity());
            db.proc.setObject(10,pt.getEmpId());
            db.proc.setString(11,pt.getCnic());
            db.proc.execute();
        }catch(SQLException sqlEx){sqlEx.printStackTrace();}
        db.closeStmtCon();
        db=null;
    }
    
    public ArrayList searchPatient(Patient pt) {
        ResultSet rs=null;
        ArrayList list=null;        
        db=new DBAccess();
        db.prepareCallString("{call dmn_searchPatient(?,?,?,?,?,?,?,?,?)}");
        try{
            db.proc.setString(1,pt.getFirstName());
        db.proc.setString(2,pt.getLastName());
        db.proc.setString(3,pt.getFatherName());
        db.proc.setString(4,pt.getGender());
        db.proc.setDate(5,pt.getDob());
        db.proc.setDate(6,pt.getRegDate());
        db.proc.setString(7,pt.getStreetAddress());
        db.proc.setString(8,pt.getTown());
        db.proc.setString(9,pt.getCity());
        db.proc.execute();
        
        rs = db.proc.getResultSet();
        
         Patient p=null;
        list = new ArrayList();
        
        while(rs.next()){
            p = new Patient();
            p.setPid(new Integer(rs.getInt(1)));
            p.setFirstName(rs.getString(2));
            p.setLastName(rs.getString(3));
            p.setFatherName(rs.getString(4));
            p.setGender(rs.getString(5));
            p.setDob(rs.getDate(6));
            p.setRegDate(rs.getDate(7));
            p.setStreetAddress(rs.getString(8));
            p.setTown(rs.getString(9));
            p.setCity(rs.getString(10));
            p.setEmpId((Integer)rs.getObject(12));
            list.add(p);
        }
        rs.close();
        }catch(SQLException sqlEx){sqlEx.printStackTrace();}

        db.closeStmtCon();        
        db=null;
        return list;
    }
}