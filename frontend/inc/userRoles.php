<?php
class LoggedIn {
	proposal
	comment
	wall of america
	protected $permissions;
    protected function __construct() {
        $this->permissions = array();
        
    }

    // return a role object with associated permissions
    public static function getRolePerms($role_id) {
        $role = new LoggedIn();
        $sql = "SELECT t2.perm_desc FROM role_perm as t1
                JOIN permissions as t2 ON t1.perm_id = t2.perm_id
                WHERE t1.role_id = :role_id";
        $sth = $GLOBALS["DB"]->prepare($sql);
        $sth->execute(array(":role_id" => $role_id));
 
        while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $role->permissions[$row["perm_desc"]] = true;
        }
        return $role;
    }
}

class Organization extends LoggedIn {
	no vote
	'page' like on fb
	can post statuses
	no follow
}

class Individual extends LoggedIn {
	vote
	can follow
	no statuses

}

class Visitor {
	no vote
	no proposal
	no comment
	no contribute
}

public function hasPerm($permission) {
        return isset($this->permissions[$permission]);
    }
?>
class Role
{
    protected $permissions;
 
    protected function __construct() {
        $this->permissions = array();
    }
 
    // return a role object with associated permissions
    public static function getRolePerms($role_id) {
        $role = new Role();
        $sql = "SELECT t2.perm_desc FROM role_perm as t1
                JOIN permissions as t2 ON t1.perm_id = t2.perm_id
                WHERE t1.role_id = :role_id";
        $sth = $GLOBALS["DB"]->prepare($sql);
        $sth->execute(array(":role_id" => $role_id));
 
        while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $role->permissions[$row["perm_desc"]] = true;
        }
        return $role;
    }
 
    // check if a permission is set
    public function hasPerm($permission) {
        return isset($this->permissions[$permission]);
    }
}