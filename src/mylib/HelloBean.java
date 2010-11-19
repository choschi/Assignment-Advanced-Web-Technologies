/*
  File HelloBean.java
  Contains the most simple Bean possible: just one single property : name
  This property is a Sting.
  It doesn't contain any other action.
  Modification:
  add the functionalities about the recognition of the chief (only answer to one's boss)
  Author: Emmanuel Benoist
  Date:  Octobre 7, 2010
 */

 
package mylib;

import javax.faces.bean.ManagedBean;
import javax.faces.bean.SessionScoped;
import java.io.Serializable;

@ManagedBean
@SessionScoped
public class HelloBean implements Serializable {

   private String name;


   public String getName() { return name;}
   
   public void setName(String name) { this.name = name; }

}
