/*
 * PthTestPlanInfo.java
 *
 * Created on May 21, 2006, 5:05 PM
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
public class PthTestPlanInfo implements Serializable  {

    private int testRequested;
    private int urgentTest;
    private int regularTest;
    private int criticalTest;
    private int sampleCollected;
    
    /** Creates a new instance of PthTestPlanInfo */
    public PthTestPlanInfo() {
    }
    public PthTestPlanInfo(int testRequested,int urgentTest,int regularTest,int criticalTest,int sampleCollected) {
    this.setTestRequested(testRequested);
    this.setUrgentTest(urgentTest);
    this.setRegularTest(regularTest);
    this.setCriticalTest(criticalTest);
    this.setSampleCollected(sampleCollected);
  
    }
    
    public int getTestRequested() {
        return testRequested;
    }

    public void setTestRequested(int testRequested) {
        this.testRequested = testRequested;
    }

    public int getUrgentTest() {
        return urgentTest;
    }

    public void setUrgentTest(int urgentTest) {
        this.urgentTest = urgentTest;
    }

    public int getRegularTest() {
        return regularTest;
    }

    public void setRegularTest(int regularTest) {
        this.regularTest = regularTest;
    }

    public int getCriticalTest() {
        return criticalTest;
    }

    public void setCriticalTest(int criticalTest) {
        this.criticalTest = criticalTest;
    }

    public int getSampleCollected() {
        return sampleCollected;
    }

    public void setSampleCollected(int sampleCollected) {
        this.sampleCollected = sampleCollected;
    }
    
}
