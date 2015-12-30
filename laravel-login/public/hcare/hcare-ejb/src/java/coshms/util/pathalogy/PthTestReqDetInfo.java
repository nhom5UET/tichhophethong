/*
 * PthTestReqDetInfo.java
 *
 * Created on May 12, 2006, 5:50 AM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.pathalogy;
import java.io.Serializable;
/**
 *
 * @author Administrator
 */
public class PthTestReqDetInfo implements Serializable {
    
    private int testId;
    private boolean urgentBasis;
    /** Creates a new instance of PthTestReqDetInfo */
    public PthTestReqDetInfo() {
    }
    public PthTestReqDetInfo(int tid,boolean ub) {
    this.setTestId(tid);
    this.setUrgentBasis(ub);
    }

    public int getTestId() {
        return testId;
    }

    public void setTestId(int testId) {
        this.testId = testId;
    }

    public boolean isUrgentBasis() {
        return urgentBasis;
    }

    public void setUrgentBasis(boolean urgentBasis) {
        this.urgentBasis = urgentBasis;
    }
    
    
}
