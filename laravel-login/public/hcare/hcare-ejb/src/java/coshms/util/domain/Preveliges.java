/*
 * Preveliges.java
 *
 * Created on July 13, 2006, 3:08 PM
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
public class Preveliges implements Serializable
{
    
    /** Creates a new instance of Preveliges */
    public Preveliges() 
    {
    }
    
    private int infId = 0;
    private String description = null;

    public int getInfId() {
        return infId;
    }

    public void setInfId(int infId) {
        this.infId = infId;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }
    
}
