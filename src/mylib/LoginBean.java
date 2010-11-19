/*
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
public class LoginBean implements Serializable {

   private String name;


   public String getName() { return name;}
   
   public void setName(String name) { this.name = name; }

   private String password;


   public String getPassword() { return password;}
   
   public void setPassword(String password) { this.password = password; }

   private String greeting;


   public String getGreeting() { return greeting;}
   
   public void setGreeting(String greeting) { this.greeting = greeting; }
   

    public String login(){
	if (name!=null && password!=null && name.equals("Emmanuel") && password.equals("Emmanuel")){
	    return "hidden";
	}
	greeting="This is the wrong name";
	return "hello";
    }
}
