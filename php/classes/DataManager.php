<?php

/**
* DataManager class abstracts the database
* To prevent multiple instantiation the singleton pattern was used
*/

class DataManager{

	private $db;
	
	static private $instance = null;

	
/**
* Returns the instance of DataManager
* @return the singleton instance of DataManager
*/
	
	
	static public function getInstance(){
		if (null === self::$instance){
			self::$instance = new self;
		}
		return self::$instance;
	}
	
/**
* Constructor method for DataManager
* creates a mdb2 database abstraction class
*/

	private function __construct(){
		require_once "MDB2.php";
		$dsn = self::getDSN();
		if ($dsn != false){
			$this->db = &MDB2::factory($dsn);
			$this->db->setCharset("utf8");
			if (PEAR::isError($db)){
				//print ($this->db->getMessage());
			}
			$this->db->setFetchMode(MDB2_FETCHMODE_OBJECT);
		}
	}

/**
* clone is private to prevent a clone
* since the class is implemented as a singleton a public clone method would be nonsense
*/
	
	private function __clone(){}
	
/**
* Save a user to the database and create the auth db entry
* @param email address
* @return the user data object
*/

	public function getUserByEMail($email){
		$sql = "SELECT * FROM admin_auth WHERE email=".$this->db->quote($email,'text');
		$result = $this->db->query($sql);
		if (PEAR::isError($result)){
			//print $result->getMessage();
			return NULL;
		}else{
			while ($data = $result->fetchRow()){
				return $data;
			} 
		}
	}
	
/**
* Save a user to the database and create the auth db entry
* @param email address
* @return the user data object
*/

	public function getModulesForClass($id){
		require_once "data/Module.php";
		$sql = "SELECT
			course.courseID as id,
			GROUP_CONCAT(DISTINCT CAST(class.classID AS CHAR) SEPARATOR ',') as klassen,
			lection.start as start,
			lection.stop as end,
			lection.day as day,
			lection.lectionID as lection,
			subject.name as module,
			subject.name_de as name_de,
			subject.name_fr as name_fr,
			subject.place as location,
			subject.durchfuehrung as durchfuehrung
			FROM
				class,
				class_has_course,
				course,
				subject,
				lection
			WHERE
				class.classID = ".$this->db->quote($id,'integer')." AND
				class.classID=class_has_course.classID AND
				class_has_course.courseID = course.courseID AND 
				course.subjectID=subject.subjectID AND 
				lection.courseID=course.courseID
			GROUP BY subject.durchfuehrung";
		$result = $this->db->query($sql);
		if (PEAR::isError($result)){
			//print $result->getMessage();
			return array();
		}else{
			$output = array();
			while ($data = $result->fetchRow(MDB2_FETCHMODE_OBJECT)){
				$module = new Module();
				$module->initFromDb($data);
				$output[] = $module;
			}
			return $output;
		}
	}
	
/**
* Save a user to the database and create the auth db entry
* @param email address
* @return the user data object
*/

	public function getAllModules(){
		require_once "data/Module.php";
		$sql = "SELECT
			course.courseID as id,
			GROUP_CONCAT(DISTINCT CAST(class.classID AS CHAR) SEPARATOR ',') as klassen,
			lection.start as start,
			lection.stop as end,
			lection.day as day,
			lection.lectionID as lection,
			subject.name as module,
			subject.name_de as name_de,
			subject.name_fr as name_fr,
			subject.place as location,
			subject.durchfuehrung as durchfuehrung
			FROM
				class,
				class_has_course,
				course,
				subject,
				lection
			WHERE
				class.classID=class_has_course.classID AND
				class_has_course.courseID = course.courseID AND 
				course.subjectID=subject.subjectID AND 
				lection.courseID=course.courseID
			GROUP BY subject.durchfuehrung";
		$result = $this->db->query($sql);
		if (PEAR::isError($result)){
			//print $result->getMessage();
			return array();
		}else{
			$output = array();
			while ($data = $result->fetchRow(MDB2_FETCHMODE_OBJECT)){
				$module = new Module();
				$module->initFromDb($data);
				$output[] = $module;
			}
			return $output;
		}
	}
	
/**
* Save a user to the database and create the auth db entry
* @param email address
* @return the user data object
*/

	public function getModule($id){
		require_once "data/Module.php";
		$sql = "SELECT
			course.courseID as id,
			GROUP_CONCAT(DISTINCT CAST(class.classID AS CHAR) SEPARATOR ',') as klassen,
			lection.start as start,
			lection.stop as end,
			lection.day as day,
			lection.lectionID as lection,
			subject.name as module,
			subject.name_de as name_de,
			subject.name_fr as name_fr,
			subject.place as location,
			subject.durchfuehrung as durchfuehrung
			FROM
				class,
				class_has_course,
				course,
				subject,
				lection
			WHERE
				course.courseID = ".$this->db->quote($id,"integer")." AND
				class.classID=class_has_course.classID AND
				class_has_course.courseID = course.courseID AND 
				course.subjectID=subject.subjectID AND 
				lection.courseID=course.courseID
			GROUP BY subject.durchfuehrung";
		$result = $this->db->query($sql);
		if (PEAR::isError($result)){
			//print $result->getMessage();
			return array();
		}else{
			$output = array();
			while ($data = $result->fetchRow(MDB2_FETCHMODE_OBJECT)){
				$module = new Module();
				$module->initFromDb($data);
				$output[] = $module;
			}
			return $output;
		}
	}
	
	
/**
* Save a user to the database and create the auth db entry
* @param email address
* @return the user data object
*/

	public function getClass($id){
		require_once "data/Klasse.php";
		$sql = "SELECT
			class.classID as id,
			class.name as class,
			class.division as division,
			class.place as location,
			GROUP_CONCAT(DISTINCT CAST(course.courseID AS CHAR) SEPARATOR ',') as modules
			FROM
				class,
				class_has_course,
				course
			WHERE
				LENGTH(class.print) < 1 AND
				class.classID = ".$this->db->quote($id,"integer")." AND
				class.classID=class_has_course.classID AND
				class_has_course.courseID = course.courseID 
			GROUP BY class.classID";
		$result = $this->db->query($sql);
		if (PEAR::isError($result)){
			//print $result->getMessage();
			return array();
		}else{
			$output = array();
			while ($data = $result->fetchRow(MDB2_FETCHMODE_OBJECT)){
				$module = new Klasse();
				$module->initFromDb($data);
				$output[] = $module;
			}
			return $output;
		}
	}
	
/**
* Save a user to the database and create the auth db entry
* @param email address
* @return the user data object
*/

	public function getAllClasses(){
		require_once "data/Klasse.php";
		$sql = "SELECT
			class.classID as id,
			class.name as class,
			class.division as division,
			class.place as location,
			GROUP_CONCAT(DISTINCT CAST(course.courseID AS CHAR) SEPARATOR ',') as modules
			FROM
				class,
				class_has_course,
				course
			WHERE
				LENGTH(class.print) < 1 AND
				class.classID=class_has_course.classID AND
				class_has_course.courseID = course.courseID 
			GROUP BY class.classID";
		$result = $this->db->query($sql);
		if (PEAR::isError($result)){
			//print $result->getMessage();
			return array();
		}else{
			$output = array();
			while ($data = $result->fetchRow(MDB2_FETCHMODE_OBJECT)){
				$module = new Klasse();
				$module->initFromDb($data);
				$output[] = $module;
			}
			return $output;
		}
	}
	
/**
* Save a user to the database and create the auth db entry
* @param email address
* @return the user data object
*/

	public function getClassesForModule($id){
		require_once "data/Klasse.php";
		$sql = "SELECT
			class.classID as id,
			class.name as class,
			class.division as division,
			class.place as location
			FROM
				class,
				class_has_course,
				course
			WHERE
				class_has_course.courseID = ".$this->db->quote($id,'integer')." AND
				LENGTH(class.print) < 1 AND
				class.classID=class_has_course.classID AND
				class_has_course.courseID = course.courseID
			GROUP BY class.classID";
		$result = $this->db->query($sql);
		if (PEAR::isError($result)){
			//print $result->getMessage();
			return array();
		}else{
			$output = array();
			while ($data = $result->fetchRow(MDB2_FETCHMODE_OBJECT)){
				$module = new Klasse();
				$module->initFromDb($data);
				$output[] = $module;
			}
			return $output;
		}
	}

/**
* Save a user to the database and create the auth db entry
* @param email address
* @return the user data object
*/

	public function getUser($id){
		$sql = "SELECT * FROM user WHERE id=".$this->db->quote($id,'text');
		$result = $this->db->query($sql);
		if (PEAR::isError($result)){
			return array();
		}else{
			$output = array();
			while ($data = $result->fetchRow(MDB2_FETCHMODE_OBJECT)){
				$item = new User();
				$item->initFromDb($data);
				$output[] = $item;
			}
			return $output;
		}
	}


/**
* Save a user to the database and create the auth db entry
* @param email address
* @return the user data object
*/

	public function createUser($name,$password){
		require_once "data/User.php";
		if ($this->checkAvailability($name)){
			$id = $this->getID();
			$sql = "INSERT INTO user SET
				id='".$id."',
				name=".$this->db->quote($name,'text').",
				password=".$this->db->quote($password,'text');
			$result = $this->db->query($sql);
			if (PEAR::isError($result)){
				//throw new Exception ($result->getMessage());
			}else{
				return $this->getUser($id);
			}
		}else{
			throw new User_Exception ();
		}
	}
	
/**
* login a user
* @param username, password
* @return the user data object
*/

	public function loginUser($name,$password){
		require_once "data/User.php";
		$sql = "SELECT 
			id 
			FROM user 
			WHERE name=".$this->db->quote($name,'text')." AND
			password=".$this->db->quote($password,'text');
		$result = $this->db->query($sql);
		if (PEAR::isError($result)){
			//throw new Exception ($result->getMessage());
		}else{
			while ($user = $result->fetchRow()){
				$output = $this->getUser($user->id);
				return $output;
			}
			return null;
		}
	}
	
/**
* adds a module to the list of booked modules of a certain user
* @param user_id, module_id
*/

	public function addModule($userId,$moduleId){
		$sql = "INSERT INTO user_module
			SET 
			id=".$this->db->quote($userId."_".$moduleId,'text').",
			user=".$this->db->quote($userId).",
			module=".$this->db->quote($moduleId)."
			ON DUPLICATE KEY UPDATE time=NOW()";
		$result = $this->db->query($sql);
		if (PEAR::isError($result)){
			//throw new Exception ($result->getMessage());
		}else{
			throw new User_Exception();
		}
	}
	
/**
* remove a module from a users list
* @param user_id, module_id
*/

	public function removeModule($userId,$moduleId){
		$sql = "DELETE 
			FROM user_module 
			WHERE id=".$this->db->quote($userId."_".$moduleId,'text');
		$result = $this->db->query($sql);
		if (PEAR::isError($result)){
			//print $result->getMessage();
			//throw new Exception ($result->getMessage());
		}else{
			throw new User_Exception();
		}
	}
	
/**
* get the modules of a certain user
* @param username
* @return the module list
*/	

	public function modulesForUser ($username){
		require_once "data/Module.php";
		$sql = "SELECT 
			user_module.module as id,
			course.courseID as id,
			lection.start as start,
			lection.stop as end,
			lection.day as day,
			lection.lectionID as lection,
			subject.name as module,
			subject.name_de as name_de,
			subject.name_fr as name_fr,
			subject.place as location,
			subject.durchfuehrung as durchfuehrung
			FROM user_module
			LEFT JOIN course ON course.courseID =  user_module.module
			LEFT JOIN class_has_course ON class_has_course.courseID = course.courseID
			LEFT JOIN class ON class.classID=class_has_course.classID
			LEFT JOIN subject ON course.subjectID=subject.subjectID
			LEFT JOIN lection ON lection.courseID=course.courseID
			WHERE user_module.user = '88a29558-1f2a-11e0-a509-00144ff783aa'
			GROUP BY course.courseID";
		$result = $this->db->query($sql);
		if (PEAR::isError($result)){
			//print $result->getMessage();
			return array();
		}else{
			$output = array();
			while ($data = $result->fetchRow(MDB2_FETCHMODE_OBJECT)){
				$module = new Module();
				$module->initFromDb($data);
				$output[] = $module;
			}
			return $output;
		}
	}
	

/**
* remove a user
* @param username, password
* @return the user data object
*/

	public function removeUser($name,$password){
		$sql = "DELETE 
			FROM user 
			WHERE name=".$this->db->quote($name,'text')." AND
			password=".$this->db->quote($password,'text');
		$result = $this->db->query($sql);
		if (PEAR::isError($result)){
			//print $result->getMessage();
			//throw new Exception ($result->getMessage());
		}else{
			throw new User_Exception();
		}
	}

	
	
/**
* Save a user to the database and create the auth db entry
* @param email address
* @return the user data object
*/
	private function checkAvailability($name){
		$sql = "SELECT * FROM user WHERE name=".$this->db->quote($name,'text');
		$result = $this->db->query($sql);
		if (PEAR::isError($result)){

		}else{
			if ($result->numRows() > 0){
				return false;
			}
		}
		return true;
	}
	
/**
* save an i18n string to the db
* @param string
*/

	public function saveI18NString($string){
		$sql = "INSERT INTO i18n_strings SET
			string='".$string."',
			count=1,
			updated=".time()."
			ON DUPLICATE KEY UPDATE count=count+1, updated=".time();
		$result = $this->db->query($sql);
		if (PEAR::isError($result)){
			//print $result->getMessage();
			return NULL;
		}
	}

/**
* gets the liszt of all the exhibitors in the database
* @return a list of populated Exhibitor objects
*/	
	
	public function getExhibitors(){
		require_once "data/Exhibitor.php";
		$sql = "SELECT * FROM ".Exhibitor::getTable()." ORDER BY NAME ASC";
		$result = $this->db->query($sql);
		if (PEAR::isError($result)){
			print $result->getMessage();	
		}else{
			$output = array();
			while ( $data = $result->fetchRow(MDB2_FETCHMODE_ASSOC)){
				$ex = new Exhibitor	();
				$ex->initFromDb($data);
				$output[] = $ex;
			}
			return $output;
		}
	}
	
/**
* perform a query on the db and return the result object
* @return the result object
*/	
	
	public function performQuery($query){
		return $this->db->query($query);
	}

/**
* start a transaction
*/

	public function startTransaction(){
		$this->db->beginTransaction();
	}
	
/**
* commit the transactions queries
*/

	public function commitTransaction(){
		$this->db->commit();
	}
	
/**
* rollback the transactions queries
*/

	public function rollbackTransaction(){
		$this->db->rollback();
	}


/**
* get an UUID from the mysql database
* @return an UUID
*/
	
	public function getID (){
		$sql = "SELECT UUID() as id";
		$result = $this->db->query($sql);
		if (PEAR::isError($result)){
			return NULL;
		}else{
			while ($data = $result->fetchRow()){
				return $data->id;
			}
		}
	}
	
/**
* quote a value with mdb2 quote function 
* @param value of the field
* @param type of the field
* @return quoted value
*/
	
	public function quote ($value,$type='text'){
		$output = $this->db->quote($value,$type);
		if ($type == 'integer'){
			return 0+$output;
		}
		return $output;
	}
	
/**
* save a data object to the db
* @param query
*/
	
	public function save ($query){
		//print $query;
		$result = $this->db->query($query);
		if (PEAR::isError($result)){
			throw new Exception ($result->getMessage());
		}
	}
	
/**
* load a data object from the db
* @param table
* @param id
*/
	
	public function load ($table,$id){
		$sql = "SELECT * FROM ".$table." WHERE id=".$this->db->quote($id,'text');
		$result = $this->db->query($sql);
		if (PEAR::isError($result)){
			throw new Exception ($result->getMessage());
		}else{
			return $result->fetchRow(MDB2_FETCHMODE_ASSOC);	
		}
	}
	
/**
* get a dsn for use with the mdb2 factory method
* @return a dsn string
*/	
	public static function getDSN(){
		$config = Config::getInstance();
		$cfg = $config->getConfig();
		$db = $cfg['db'];
		$dsn = "mysqli://".$db['user'].":".$db['password']."@".$db['server']."/".$db['database'];
		return $dsn;
	}
}

class User_Exception extends Exception{
		
}

?>