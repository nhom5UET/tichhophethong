//22-05-Sunday Night
package coshms.ejb.emergency;
import coshms.domain.emergency.*;
import coshms.util.emergency.MedicinePrescription;
import coshms.util.emergency.MedicineStock;
import coshms.util.emergency.PtTreatments;

import java.sql.CallableStatement;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Date;

import javax.sql.DataSource;

import java.util.ArrayList;

import javax.ejb.*;

import javax.naming.InitialContext;

/**
 * This is the bean class for the PharmacyBean enterprise bean.
 * Created May 11, 2006 12:15:13 AM
 * @author Tahir
 */
public class PharmacyBean implements SessionBean, PharmacyRemoteBusiness
{
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
    public void setSessionContext (SessionContext aContext)
    {
        context = aContext;
    }
    
    /**
     * @see javax.ejb.SessionBean#ejbActivate()
     */
    public void ejbActivate ()
    {
        
    }
    
    /**
     * @see javax.ejb.SessionBean#ejbPassivate()
     */
    public void ejbPassivate ()
    {
        
    }
    
    /**
     * @see javax.ejb.SessionBean#ejbRemove()
     */
    public void ejbRemove ()
    {
        
    }
    // </editor-fold>
    
    public void ejbCreate ()
    {
    }
    
    public ArrayList getPatientRegInfo (int pid)
    {
        CallableStatement cStmt;
        ResultSet rs = null;
        Connection con = null;
        //int pid = 1;
        ArrayList list = new ArrayList ();
        String str = null;
        
        
        try
        {
            ctx = new InitialContext ();
            ds = (DataSource) ctx.lookup (jndiName);
            con = ds.getConnection ();
            cStmt = con.prepareCall ("{ call dmn_getRegPatient(?) }");
            cStmt.setInt (1,pid);
            rs = cStmt.executeQuery ();
            
            while (rs.next ())
            {
                Patient patient = new Patient ();
                
                patient.setPid (rs.getInt (1));
                patient.setFirstName (rs.getString (2));
                patient.setLastName (rs.getString (3));
                patient.setFatherName (rs.getString (4));
                patient.setGender (rs.getString (5));
                patient.setDob (rs.getString (6));
                patient.setStreetAddress (rs.getString (8));
                patient.setTown (rs.getString (9));
                patient.setCity (rs.getString (10));
                //System.out.println (rs.getString (1)+rs.getString (2)+rs.getString (3)+rs.getString (4)+rs.getString (5)+rs.getString (6)+rs.getString (7)+rs.getString (8)+rs.getString (9));
                
                list.add (patient);
            }
        }
        
        catch (Exception e)
        {
            e.printStackTrace ();
        }
        
        finally
        {
            try
            {
                rs.close ();
                con.close ();
            }
            catch (SQLException ex)
            {
                ex.printStackTrace ();
            }
        }
        
        System.out.println ("RegPt");
        return list;
    }
    
    public ArrayList getTprbRecord (int pid)
    {
        
        ResultSet  rs2 = null;
        ResultSet rs = null;
        ResultSet rsLatestTmnt = null;
        
        Connection con = null;
        ArrayList list = new ArrayList ();
        
        CallableStatement cStmt1, cStmt2;
        CallableStatement cStmtLatestTmnt;
        
        int latestEncNo=0 ;
        int latestTmntNo = 0;
        
        try
        {
            ctx = new InitialContext ();
            ds = (DataSource) ctx.lookup (jndiName);
            con = ds.getConnection ();
            
            cStmt1 = con.prepareCall ("{ CALL emg_getLatestEnc(?) }");
            cStmt1.setInt (1,pid);
            rs = cStmt1.executeQuery ();
            while (rs.next ())
            {
                latestEncNo = rs.getInt (1);
            }
            System.out.println ("ENC for TPRB: "+latestEncNo);
            ///////////////////////////////////
            cStmtLatestTmnt = con.prepareCall ("{ CALL emg_getLatestTrtmntNo(?,?) }");
            cStmtLatestTmnt.setInt (1,pid);
            cStmtLatestTmnt.setInt (2,latestEncNo);
            
            rsLatestTmnt = cStmtLatestTmnt.executeQuery ();
            
            while (rsLatestTmnt.next ())
            {
                latestTmntNo = rsLatestTmnt.getInt (1);
            }
            System.out.println ("TRT for TPRB: "+latestTmntNo);
            
            ///////////////////////////////////
            cStmt2 = con.prepareCall ("{ CALL dmn_getTprb(?,?) }");
            cStmt2.setInt (1,pid);
            cStmt2.setInt (2,latestEncNo);
            rs2 = cStmt2.executeQuery ();
            if (rs2.last ())
            {
                PatientTprb patientTprb = new PatientTprb ();
                patientTprb.setBp       (rs2.getString (1));
                patientTprb.setPulse    (rs2.getString (2));
                patientTprb.setTemp     (rs2.getString (3));
                patientTprb.setRRate    (rs2.getString (4));
                patientTprb.setEmgEncNo (latestEncNo);
                patientTprb.setTreatmentNo (latestTmntNo);
                list.add (patientTprb);
            }
        }
        catch (Exception e)
        {
            System.out.println ("TPRB: "+e.toString ());
        }
        
        finally
        {
            try
            {
                con.close ();
                rs.close ();
                rs2.close ();
                rsLatestTmnt.close ();
            }
            catch (SQLException ex)
            {
                ex.printStackTrace ();
            }
        }System.out.println ("[DEBUG] Tprb");
        return list;
    }
    
    public ArrayList getMedicineRecord ( int pid , int emgEncNo , int treatmentNo)
    {
        int latestEncNo = 0 , latestTmntNo = 0;
        ResultSet rsLatestEnc =  null, rsMcode = null , rsQty = null , rsMname = null , rsLatestTmnt = null;
        Connection con = null;
        ArrayList list = new ArrayList ();
        
        CallableStatement cStmtLatestEnc , cStmtMcode , cStmtLatestTmnt;
        
        try
        {
            ctx = new InitialContext ();
            ds = (DataSource) ctx.lookup (jndiName);
            con = ds.getConnection ();
            
            //getting medicine code
            
            cStmtMcode = con.prepareCall ("{ CALL emg_getPrescriptionMCode(?,?,?) }");
            cStmtMcode.setInt (1,pid);
            cStmtMcode.setInt (2,emgEncNo);
            cStmtMcode.setInt (3,treatmentNo);
            
            rsMcode = cStmtMcode.executeQuery ();
            
            while (rsMcode.next ())
            {
                MedicinePrescription medicinePrescription = new MedicinePrescription ();
                String mCode = null;
                mCode = rsMcode.getString (1);
                
                //setting mCode
                
                medicinePrescription.setMCode (mCode);
                
                //getting quantity of a medicine
                
                CallableStatement cStmtQty , cStmtMname;
                
                cStmtQty = con.prepareCall ("{ CALL emg_getPrescriptionMedsQty(?,?,?,?) }");
                cStmtQty.setInt     (1,pid);
                cStmtQty.setInt     (2,emgEncNo);
                cStmtQty.setInt     (3,treatmentNo);
                cStmtQty.setString  (4,mCode);
                
                rsQty = cStmtQty.executeQuery ();
                
                while (rsQty.next ())
                {
                    //setting qty
                    medicinePrescription.setQty (Integer.parseInt (rsQty.getString (1)));
                }
                
                //getting name of medicines
                
                cStmtMname = con.prepareCall ("{ CALL emg_getMedicineName(?) }");
                cStmtMname.setString (1,mCode);
                
                rsMname = cStmtMname.executeQuery ();
                
                while (rsMname.next ())
                {
                    
                    //setting medicine name
                    medicinePrescription.setName (rsMname.getString (1));
                }
                System.out.println (medicinePrescription.getMCode ()+"-"+medicinePrescription.getName ()+"-"+medicinePrescription.getQty ());
                list.add (medicinePrescription);
            }
        }
        
        catch (Exception e)
        {
            e.printStackTrace ();
        }
        
        finally
        {
            try
            {
                con.close ();
                //     rsLatestEnc.close ();
                rsMcode.close ();
                rsQty.close ();
                rsMname.close ();
            }
            catch (SQLException ex)
            {
                ex.printStackTrace ();
            }
        }
        return list;
    }
    
    public boolean setMedicineTransac (int pid, int emgEncNo, String mCode, int issueQty , int actQty , int empId , char shift , int treatmentNo , int workForBalance)
    {
        CallableStatement procOutFlow, procUpdPharm , procBlnceMeds;
        Connection con = null , con1 = null;
        
        int balanceQty = 0;
        balanceQty = actQty - issueQty ;
        
        System.out.println ("PID: "+ pid + ", Enc: "+emgEncNo +", TrtNO: "+treatmentNo+", MCode: "+mCode +", iQty:  "+issueQty+", aQty: "+actQty + ", balanceQty "+balanceQty + ", shft: "+shift);
        
        try
        {
            ctx = new InitialContext ();
            ds = (DataSource) ctx.lookup (jndiName);
            con = ds.getConnection ();
            con1 = ds.getConnection ();
            
            
            // saving in pham_out_flow
            
            procOutFlow = con.prepareCall ("{ CALL emg_setPharmOutflow( ? , ? , ? , ? , ? , ? , ? ) }");
            procOutFlow.setInt      (1,pid);
            procOutFlow.setInt      (2,emgEncNo);
            procOutFlow.setString   (3,mCode);
            procOutFlow.setInt      (4,issueQty);
            procOutFlow.setInt      (5,empId);
            procOutFlow.setString   (6,String.valueOf (shift));
            procOutFlow.setInt      (7,treatmentNo);
            procOutFlow.execute ();
            System.out.println ("Outflow - issueQty: "+issueQty);
            
            procUpdPharm = con1.prepareCall ("{ CALL emg_issueFromPharmacy( ? , ? , ? ) }");
            procUpdPharm.setString  (1,mCode);
            procUpdPharm.setInt     (2,issueQty);
            procUpdPharm.setString  (3,String.valueOf (shift));
            procUpdPharm.execute ();
            
            System.out.println ("issueFromPharm");
            
            //if balance qty exists
            
            if (balanceQty > 0 && workForBalance == 0)
            {
                System.out.println ("Processing Balance Transaction <Issue Mode>");
                procBlnceMeds = con.prepareCall ("{ CALL emg_setBalanceMedicine( ? , ? , ? , ? , ? , ? , ? ) }");
                procBlnceMeds.setInt      (1,pid);
                procBlnceMeds.setInt      (2,emgEncNo);
                procBlnceMeds.setInt      (3,treatmentNo);
                procBlnceMeds.setString   (4,mCode);
                procBlnceMeds.setInt      (5,empId);
                procBlnceMeds.setString   (6,String.valueOf (shift));
                procBlnceMeds.setInt      (7,balanceQty);
                
                procBlnceMeds.execute ();
                System.out.println ("balanceQty :"+balanceQty);
            }
            
            if (workForBalance == 1)
            {
                
                System.out.println ("Processing Balance Transaction <balance Mode>");
                procBlnceMeds = con.prepareCall ("{ CALL emg_setBalanceMedicine( ? , ? , ? , ? , ? , ? , ? ) }");
                procBlnceMeds.setInt      (1,pid);
                procBlnceMeds.setInt      (2,emgEncNo);
                procBlnceMeds.setInt      (3,treatmentNo);
                procBlnceMeds.setString   (4,mCode);
                procBlnceMeds.setInt      (5,empId);
                procBlnceMeds.setString   (6,String.valueOf (shift));
                procBlnceMeds.setInt      (7,balanceQty);
                
                procBlnceMeds.execute ();
                System.out.println ("balanceQty :"+balanceQty);
                
            }
            
        }
        catch (Exception e)
        {
            System.out.println (e.toString ());
            return false;
        }
        finally
        {
            try
            {
                con.close (); con1.close ();
            }
            catch (SQLException ex)
            {
                ex.printStackTrace ();
                //return false;
            }
        }
        return true;
    }
    
    public ArrayList getMedicineInStock (char shift )
    {
        CallableStatement cStmtStock , cStmtQty , cStmtName;
        ResultSet rsStock = null , rsQty = null , rsName = null;
        Connection con = null;
        ArrayList list = new ArrayList ();
        System.out.println ("starting stock medicine######");
        try
        {
            ctx = new InitialContext ();
            ds = (DataSource) ctx.lookup (jndiName);
            con = ds.getConnection ();
            
            cStmtStock = con.prepareCall ("{ CALL emg_getMedsInStock(?) }");
            cStmtStock.setString (1,String.valueOf (shift));
            rsStock = cStmtStock.executeQuery ();
            while (rsStock.next ())
            {
                //System.out.println (rsStock.getString (1));
                MedicineStock medicineStock = new MedicineStock ();
                medicineStock.setMCode (rsStock.getString (1));
                
                cStmtQty = con.prepareCall ("{ CALL emg_getMedQtyByShift(?,? ) }");
                cStmtQty.setString (1,rsStock.getString (1));
                cStmtQty.setString (2,String.valueOf (shift));
                rsQty = cStmtQty.executeQuery ();
                while (rsQty.next ())
                {
                    //   System.out.print (rsQty.getInt (1));
                    medicineStock.setQty (rsQty.getInt (1));
                }
                
                cStmtName = con.prepareCall ("{ CALL emg_getMedicineName(?) }");
                cStmtName.setString (1,rsStock.getString (1));
                rsName = cStmtName.executeQuery ();
                while (rsName.next ())
                {
                    //     System.out.print (rsName.getString (1));
                    medicineStock.setName (rsName.getString (1));
                }
                list.add (medicineStock);
            }
        }
        catch (Exception e)
        {
        }
        finally
        {
            try
            {
                con.close ();
                rsStock.close ();
            }
            catch (SQLException ex)
            {
                ex.printStackTrace ();
            }
        }
        return list ;
    }
    
    public void setPhramacyTransac ( int empId , char shift , String mCode , int updQty )
    {
        System.out.println ("EmpId: " + empId +" , shift: "+ shift +" , mCode: "+ mCode + " , updQty: "+ updQty);
        
        Connection con = null;
        CallableStatement procUpdPharm = null , procPharmInflow ;
        
        try
        {
            ctx = new InitialContext ();
            ds = (DataSource) ctx.lookup (jndiName);
            con = ds.getConnection ();
            
            procUpdPharm = con.prepareCall (" { CALL emg_setPharmacyStock( ? , ? , ? ) } ");
            procUpdPharm.setString  ( 1 , mCode);
            procUpdPharm.setInt     ( 2 , updQty) ;
            procUpdPharm.setString  ( 3 , String.valueOf (shift)) ;
            procUpdPharm.execute ();
            
            System.out.println ("PharmStock");
            // preparing for dumping enteries in pharm_in_flow
            
            procPharmInflow = con.prepareCall (" { CALL emg_setPharmInflow( ? , ? , ? , ? ) } ");
            procPharmInflow.setString   ( 1 , mCode );
            procPharmInflow.setInt      ( 2 , updQty ) ;
            procPharmInflow.setString   ( 3 , String.valueOf (shift));
            procPharmInflow.setInt      ( 4 , empId);
            procPharmInflow.execute ();
            
            System.out.println ("PharmInflow");
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
                procUpdPharm.close ();
            }
            catch (SQLException ex)
            {
                ex.printStackTrace ();
            }
        }
    }
    
    public ArrayList getAllTreatmentOnMaxEnc ( int pid )
    {
        
        ArrayList list = new ArrayList ();
        Connection con = null;
        CallableStatement cStmtTrtmnt = null , cStmtEmp= null , cStmtTrtInBalnc= null , cStmtLatestEnc= null;
        ResultSet rsTrtmnt = null , rsEmp = null , rsTrtInBalnc = null , rsLatstEnc = null;
        int treatmentNo , latstEncNo =0;
        
        try
        {
            ctx = new InitialContext ();
            ds = (DataSource) ctx.lookup (jndiName);
            con = ds.getConnection ();
            
//////////////////////
            
            cStmtLatestEnc = con.prepareCall ("{ CALL emg_getLatestEnc(?) }");
            cStmtLatestEnc.setInt (1,pid);
            rsLatstEnc = cStmtLatestEnc.executeQuery ();
            System.out.println ("[Got ENC]");
            while (rsLatstEnc.next ())
            {
                latstEncNo = rsLatstEnc.getInt (1); }
            
///////////////////////
            
            cStmtTrtmnt = con.prepareCall (" { CALL emg_getTreatmentsOnEnc( ? , ?) } ");
            cStmtTrtmnt.setInt (1,pid);
            cStmtTrtmnt.setInt (2,latstEncNo);
            
            rsTrtmnt = cStmtTrtmnt.executeQuery ();
            
            System.out.println ("[Got TRT]");
            
            while (rsTrtmnt.next ())
            {
                PtTreatments ptTreatments = new PtTreatments ();
                ptTreatments.setEmgEncNo    (latstEncNo);
                ptTreatments.setTreatmentNo (rsTrtmnt.getInt (1));
                ptTreatments.setEmpId       (rsTrtmnt.getInt (2));
                ptTreatments.setTime        (rsTrtmnt.getTimestamp (3).toString ());
                
                System.out.println ("[Got TRT rs]");
                
                int empId = rsTrtmnt.getInt (2);
                
                cStmtEmp = con.prepareCall (" { CALL emg_getEmpName(?) } ");
                cStmtEmp.setInt (1,empId);
                rsEmp = cStmtEmp.executeQuery ();
                System.out.println ("[Got EMP]");
                
                while (rsEmp.next ())
                {
                    
                    ptTreatments.setEmpName (rsEmp.getString (1)+" "+rsEmp.getString (2));
                }
                System.out.println (ptTreatments.getEmpName () +ptTreatments.getTime ()+ptTreatments.getEmgEncNo ()+ptTreatments.getTreatmentNo ());
                list.add (ptTreatments);
                System.out.println ("[Got LIST ]");
            }
        }
        catch (Exception e)
        {
            e.printStackTrace ();
        }
        finally
        {
            try
            {
                con.close ();
            }
            catch (SQLException ex)
            {
                ex.printStackTrace ();
            }}
        
        System.out.println ("[ret LIST ] "+list.size ());
        
        return list ;
        
    }
    
    public ArrayList getBalanceMedicine (int pid , int emgEncNo , int trtmntNo)
    {
        ArrayList list = new ArrayList ();
        
        ResultSet rsLatestEnc =  null, rsMcode = null , rsQty = null , rsMname = null , rsLatestTmnt = null;
        Connection con = null;
        CallableStatement cStmtLatestEnc , cStmtMcode , cStmtLatestTmnt;
        
        try
        {
            ctx = new InitialContext ();
            ds = (DataSource) ctx.lookup (jndiName);
            con = ds.getConnection ();
            
            System.out.println ("get con");
            
            //getting medicine code
            
            cStmtMcode = con.prepareCall ("{ CALL emg_getBalanceMCode(?,?,?) }");
            cStmtMcode.setInt (1,pid);
            cStmtMcode.setInt (2,emgEncNo);
            cStmtMcode.setInt (3,trtmntNo);
            
            rsMcode = cStmtMcode.executeQuery ();
            
            while (rsMcode.next ())
            {
                System.out.println ("callin done ");
                MedicinePrescription medicinePrescription = new MedicinePrescription ();
                String mCode = null;
                mCode = rsMcode.getString (1);
                
                //setting mCode
                System.out.println ("setting mCode");
                medicinePrescription.setMCode (mCode);
                
                //getting quantity of a medicine
                
                CallableStatement cStmtQty , cStmtMname;
                
                cStmtQty = con.prepareCall ("{ CALL emg_getBalanceQty(?,?,?,?) }");
                cStmtQty.setInt     (1,pid);
                cStmtQty.setInt     (2,emgEncNo);
                cStmtQty.setInt     (3,trtmntNo);
                cStmtQty.setString  (4,mCode);
                
                rsQty = cStmtQty.executeQuery ();
                
                System.out.println ("setting Qty");
                
                while (rsQty.next ())
                {
                    //setting qty
                    medicinePrescription.setQty (Integer.parseInt (rsQty.getString (1)));
                }
                
                //getting name of medicines
                
                cStmtMname = con.prepareCall ("{ CALL emg_getMedicineName(?) }");
                cStmtMname.setString (1,mCode);
                
                rsMname = cStmtMname.executeQuery ();
                
                while (rsMname.next ())
                {
                    
                    //setting medicine name
                    System.out.println ("setting name");
                    medicinePrescription.setName (rsMname.getString (1));
                }
                System.out.println (medicinePrescription.getMCode ()+"-"+medicinePrescription.getName ()+"-"+medicinePrescription.getQty ());
                list.add (medicinePrescription);
            }
        }
        catch ( Exception e )
        {
            e.printStackTrace ();
        }
        finally
        {
            try
            {
                con.close ();
            }
            catch (SQLException ex)
            {
                ex.printStackTrace ();
            }
        }
        return list ;
    }
    
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
                //System.out.println (result);
            }
            
            if (result > 0 )
            {
                System.out.print ("authenticated ...");
            }
        }
        catch (Exception e)
        {
            System.out.println ("authentication error: "+e.toString ());
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
        CallableStatement cStmtAuth = null;
        ResultSet rsAuthUser = null;
        Connection con = null;
        int result = 0;
        
        try
        {
            ctx = new InitialContext ();
            ds = (DataSource) ctx.lookup (jndiName);
            con = ds.getConnection ();
            
            cStmtAuth = con.prepareCall ("{ CALL emg_authorizeUser( ? , ? ) }");
            cStmtAuth.setInt    (1 , userId);
            cStmtAuth.setString (2 , interfaceName);
            rsAuthUser = cStmtAuth.executeQuery ();
            while (rsAuthUser.next ())
            {
                authResult = rsAuthUser.getInt (1);
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
                cStmtAuth.close ();
            }
            catch (SQLException ex)
            {
                System.out.println (ex.toString ());
            }
        }
        return authResult;
    }
    
    public ArrayList getCurrentStockByShift ( String shift )
    {
        ArrayList list = new ArrayList ();
        
        ResultSet rs = null , rsName = null;
        Connection con = null;
        CallableStatement  cStmtMcode = null , cStmtName = null;
        
        try
        {
            ctx = new InitialContext ();
            ds = (DataSource) ctx.lookup (jndiName);
            con = ds.getConnection ();
            
            //getting medicine code
            
            cStmtMcode = con.prepareCall ("{ CALL emg_getMedsInStock(?) }");
            cStmtMcode.setString (1 , shift );
            rs = cStmtMcode.executeQuery ();
            while (rs.next ())
            {
                MedicineStock medicineStock = new MedicineStock ();
                medicineStock.setQty (rs.getInt (2));
                cStmtMcode = con.prepareCall ("{ CALL emg_getMedicineName(?) }");
                cStmtMcode.setInt (1 , rs.getInt (1));
                while (rsName.next ())
                {
                    medicineStock.setName (rsName.getString (1));
                }
                list.add (medicineStock);
            }
        }
        catch (Exception e)
        {
            System.out.println ();
        }
        finally
        {
            try
            {
                rs.close ();
                rsName.close ();
                con.close ();
                cStmtMcode.close ();
                cStmtName.close ();
            }
            catch (SQLException ex)
            {
                ex.printStackTrace ();
            }
        }
        return list;
    }
    
    public ArrayList getStockInflow (Date fromThisDate , Date toThisDate , String shift)
    {
        ArrayList list = new ArrayList ();
        
        ResultSet rs = null , rsName = null , rsEmpName = null;
        Connection con = null;
        CallableStatement  cStmtMcode = null , cStmtName = null , cStmtEmpName = null;
        
        try
        {
            ctx = new InitialContext ();
            ds = (DataSource) ctx.lookup (jndiName);
            con = ds.getConnection ();
            
            //getting medicine code
            
            cStmtMcode = con.prepareCall ("{ CALL emg_getPharmInflow( ? , ? , ?) }");
            cStmtMcode.setDate (1 , fromThisDate );
            cStmtMcode.setDate (2 , toThisDate );
            cStmtMcode.setString (3 , shift);
            rs = cStmtMcode.executeQuery ();
            
            
            while (rs.next ())
            {
                MedicineStock medicineStock = new MedicineStock ();
                medicineStock.setQty (rs.getInt (2));
               // medicineStock.setDate (rs.getString (3));
                medicineStock.setDate(rs.getString (3));
                
                //getting medicine name
                cStmtName = con.prepareCall ("{ CALL emg_getMedicineName(?) }");
                cStmtName.setInt (1 , rs.getInt (1));
                rsName = cStmtName.executeQuery ();
                while (rsName.next ())
                {
                    medicineStock.setName (rsName.getString (1));
                }
                
                // getting employee name
                cStmtEmpName = con.prepareCall ("{ CALL emg_getEmpName(?) }");
                cStmtEmpName.setInt (1 , rs.getInt (4));
                rsEmpName = cStmtEmpName.executeQuery ();
                while (rsEmpName.next ())
                {
                    medicineStock.setEmpName (rsEmpName.getString (1)+" "+rsEmpName.getString (2));
                }
                
                list.add (medicineStock);
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
                cStmtMcode.close ();
                cStmtName.close ();
                
                rs.close ();
                rsName.close ();
            }
            catch (SQLException ex)
            {
                System.out.println (ex.toString ());
            }
        }
        return list;
    }
    
    public ArrayList getStockOutflow (Date fromThisDate , Date toThisDate , String shift)
    {
        
        ArrayList list = new ArrayList ();
        
        ResultSet rs = null , rsName = null , rsEmpName = null;
        Connection con = null;
        CallableStatement  cStmtMcode = null , cStmtName = null , cStmtEmpName = null;
        
        try
        {
            ctx = new InitialContext ();
            ds = (DataSource) ctx.lookup (jndiName);
            con = ds.getConnection ();
            
            //getting medicine code
            
            cStmtMcode = con.prepareCall ("{ call emg_getPharmStockOutflow (?,?,?) }");
            cStmtMcode.setDate (1 , fromThisDate );
            cStmtMcode.setDate (2 , toThisDate );
            cStmtMcode.setString (3 , shift);
            rs = cStmtMcode.executeQuery ();
            
            while (rs.next ())
            {
                MedicineStock medicineStock = new MedicineStock ();
                medicineStock.setQty (rs.getInt (2));
                medicineStock.setDate (rs.getString (3));
                medicineStock.setTime (rs.getString (4));
                //getting medicine name
                cStmtName = con.prepareCall ("{ CALL emg_getMedicineName(?) }");
                cStmtName.setInt (1 , rs.getInt (1));
                rsName = cStmtName.executeQuery ();
                while (rsName.next ())
                {
                    medicineStock.setName (rsName.getString (1));
                }
                
                // getting employee name
                cStmtEmpName = con.prepareCall ("{ CALL emg_getEmpName(?) }");
                cStmtEmpName.setInt (1 , rs.getInt (5));
                rsEmpName = cStmtEmpName.executeQuery ();
                while (rsEmpName.next ())
                {
                    medicineStock.setEmpName (rsEmpName.getString (1)+" "+rsEmpName.getString (2));
                }
                if (medicineStock.getQty () > 0)
                {
                    list.add (medicineStock);
                }
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
                rs.close ();
                rsName.close ();
                rsEmpName.close ();           
            }
            catch (SQLException ex)
            {
                System.out.println (ex.toString ());
            }
        }
        return list;
    }
    
    public ArrayList getStockConsumption (Date fromThisDate , Date toThisDate)
    {
        
        ArrayList list = new ArrayList ();
        
        ResultSet rs = null , rsName = null , rsEmpName = null;
        Connection con = null;
        CallableStatement  cStmtMcode = null , cStmtName = null , cStmtEmpName = null;
        
        try
        {
            ctx = new InitialContext ();
            ds = (DataSource) ctx.lookup (jndiName);
            con = ds.getConnection ();
            
            //getting medicine code
            
            cStmtMcode = con.prepareCall ("{ call emg_getConsumption (?,?) }");
            cStmtMcode.setDate (1 , fromThisDate );
            cStmtMcode.setDate (2 , toThisDate );
            
            rs = cStmtMcode.executeQuery ();
            
            while (rs.next ())
            {
                MedicineStock medicineStock = new MedicineStock ();
                medicineStock.setQty (rs.getInt (2));
                
                //getting medicine name
                cStmtName = con.prepareCall ("{ CALL emg_getMedicineName(?) }");
                cStmtName.setInt (1 , rs.getInt (1));
                rsName = cStmtName.executeQuery ();
                while (rsName.next ())
                {
                    medicineStock.setName (rsName.getString (1));
                }
                
                list.add (medicineStock);
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
                
                rs.close ();
                rsName.close ();       
            }
            catch (SQLException ex)
            {
                System.out.println (ex.toString ());
            }
        }
        return list;
    }
    
}