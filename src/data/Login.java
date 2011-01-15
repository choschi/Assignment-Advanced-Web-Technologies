package data;



public class Login {
	
	private User user;
	
	public void login (String username,String password){
		user = DataManager.login(username, password);
		System.out.println(user.toString());
	}
	
	public boolean loggedIn (){
		return user != null;
	}
}
