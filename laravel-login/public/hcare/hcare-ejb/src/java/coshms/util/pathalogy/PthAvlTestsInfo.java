/*
 * PthAvlTestsInfo.java
 *
 * Created on May 6, 2006, 7:55 PM
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
public class PthAvlTestsInfo implements Serializable {
   
    private String name;
    private int testId;
    private boolean status;
    private int cost;
    /** Creates a new instance of PthAvlTestsInfo */
    public PthAvlTestsInfo() {
    }

    public PthAvlTestsInfo(String myname, int tid) {
    this.name = myname;
    this.testId = tid;
    }

    public PthAvlTestsInfo(String myname, int tid,int cost,boolean status) {
    this.name = myname;
    this.testId = tid;
    this.cost = cost;
    this.status = status;
    }
    
    public String getName() {
        return this.name;
    }

    public void setName(String myname) {
        this.name = myname;
    }

    public int getTestId() {
        return testId;
    }

    public void setTestId(int testId) {
        this.testId = testId;
    }

    public boolean isStatus() {
        return status;
    }

    public void setStatus(boolean status) {
        this.status = status;
    }

    public int getCost() {
        return cost;
    }

    public void setCost(int cost) {
        this.cost = cost;
    }
    
}
