/*
 * Employee.java
 *
 * Created on July 13, 2006, 11:54 AM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.domain;

import java.io.Serializable;

/**
 *
 * @author Administrator
 */
public class Employee implements Serializable{
    
    /** Creates a new instance of Employee */
    public Employee() {
    }
    private String userName = null;
    private String employeeName = null;
    private String designation = null;
    private int empId = 0 ;

    public String getUserName() {
        return userName;
    }

    public void setUserName(String userName) {
        this.userName = userName;
    }

    public String getEmployeeName() {
        return employeeName;
    }

    public void setEmployeeName(String employeeName) {
        this.employeeName = employeeName;
    }

    public String getDesignation() {
        return designation;
    }

    public void setDesignation(String designation) {
        this.designation = designation;
    }

    public int getEmpId() {
        return empId;
    }

    public void setEmpId(int empId) {
        this.empId = empId;
    }
    
}
