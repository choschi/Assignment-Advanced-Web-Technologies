package data;


public class User{
	private String username;
	private String userid;
	public User (){
	}
	
	public String getUsername (){
		return username;
	}
	
	public void setUsername (String name){
		username = name;
	}
	
	public String getUserid (){
		return userid;
	}
	
	public void setUserid (String id){
		userid = id;
	}
	
	public String toString(){
		return username+":"+userid;
	}
}
