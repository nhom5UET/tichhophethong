/*
 * RadTestReqDetInfo.java
 *
 * Created on June 4, 2006, 10:21 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.radiology;

import java.io.Serializable;
/**
 *
 * @author Administrator
 */
public class RadTestReqDetInfo implements Serializable  {
    
    private int testId;
    private boolean urgentBasis;
    /** Creates a new instance of RadTestReqDetInfo */
    public RadTestReqDetInfo() {
    }
    public RadTestReqDetInfo(int tid,boolean ub) {
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
