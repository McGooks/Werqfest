<?php
class Account
{
    private $id;
    private $name;
    private $authenticated;
    private $usertype;
    public function __construct()
    {
        $this->id = null;
        $this->name = null;
        $this->authenticated = false;
        $this->usertype = null;
    }
    public function __destruct()
    {}
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function isAuthenticated(): bool
    {
        return $this->authenticated;
    }

    public function getUsertype(): ?int
    {
        return $this->usertype;
    }

    /* Add a new account to the system and return its ID (the account_id column of the accounts table) */
    public function addAccount(string $name, string $passwd, int $utype): int
    {
        global $pdo;
        $name = trim($name);
        $passwd = trim($passwd);
        $utype = trim($utype);

        if (!$this->isNameValid($name)) {
            throw new Exception('Invalid user name');
        }
        if (!$this->isPasswdValid($passwd)) {
            throw new Exception('Invalid password');
        }

        if (!$this->isUserTypeValid($utype)) {
            throw new Exception('Invalid Usertype');
        }

        if (!is_null($this->getIdFromName($name))) {
            throw new Exception('User name not available');
        }
        $query = 'INSERT INTO gmcgookin01.wqf_users (username, passwd, user_type) VALUES (:name, :passwd, :utype)';
        $hash = password_hash($passwd, PASSWORD_DEFAULT);
        $values = array(':name' => $name, ':passwd' => $hash, ':utype' => $utype);
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
        return $pdo->lastInsertId();
    }

    /* Add a new user profile to the system and return its ID (the account_id column of the accounts table) */
    public function CreateUserProfile(string $fname, string $lname, int $gender, string $dob, int $uid, string $address, int $town, string $postcode, int $editedby)
    {
        global $pdo;
        $fname = trim($fname);
        $lname = trim($lname);

        $query = 'INSERT INTO gmcgookin01.wqf_account (fname, lname, gender, dob ,users_account, address, town, postcode, last_edited_by) VALUES (:fname, :lname, :gender, :dob ,:users_account, :address, :town, :postcode, :editedby)';
        $values = array(':fname' => $fname, ':lname' => $lname, ':gender' => $gender, ':dob' => $dob, ':users_account' => $uid, ':address' => $address, ':town' => $town, ':postcode' => $postcode, ':editedby' => $editedby);
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
        return $pdo->lastInsertId();
    }

    /* Delete an account (selected by its ID) */
    public function deleteAccount(int $id)
    {
        global $pdo;
        if (!$this->isIdValid($id)) {
            throw new Exception('Invalid account ID');
        }
        $query = 'DELETE FROM gmcgookin01.wqf_users WHERE (user_id = :id)';
        $values = array(':id' => $id);
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
        $query = 'DELETE FROM gmcgookin01.wqf_users WHERE (user_id = :id)';
        $values = array(':id' => $id);
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
    }

    /* Edit an account (selected by its ID). The name, the password and the status (enabled/disabled) can be changed */
    public function editAccount(int $id, string $name, string $passwd, bool $enabled)
    {
        global $pdo;
        $name = trim($name);
        $passwd = trim($passwd);
        if (!$this->isIdValid($id)) {
            throw new Exception('Invalid account ID');
        }
        if (!$this->isNameValid($name)) {
            throw new Exception('Invalid user name');
        }
        if (!$this->isPasswdValid($passwd)) {
            throw new Exception('Invalid password');
        }
        $idFromName = $this->getIdFromName($name);
        if (!is_null($idFromName) && ($idFromName != $id)) {
            throw new Exception('User name already used');
        }
        $query = 'UPDATE gmcgookin01.wqf_users SET username = :name, passwd = :passwd, is_active = :enabled WHERE user_id = :id';
        $hash = password_hash($passwd, PASSWORD_DEFAULT);
        $intEnabled = $enabled ? 1 : 0;
        $values = array(':name' => $name, ':passwd' => $hash, ':enabled' => $intEnabled, ':id' => $id);
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {

            throw new Exception('Database query error');
        }
    }

    /* Login with username and password */
    public function login(string $name, string $passwd): bool
    {
        global $pdo;
        $name = trim($name);
        $passwd = trim($passwd);
        if (!$this->isNameValid($name)) {
            return false;
        }
        if (!$this->isPasswdValid($passwd)) {
            return false;
        }
        $query = 'SELECT * FROM gmcgookin01.wqf_users WHERE (username = :name) AND (is_active = 1)';
        $values = array(':name' => $name);
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
            if($res == NULL){
                return false;
            }
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
        $row = $res->fetch(PDO::FETCH_ASSOC);
        if (is_array($row)) {
            if (password_verify($passwd, $row['passwd'])) {
                $this->id = intval($row['user_id'], 10);
                $this->name = $name;
                $this->authenticated = true;
                $this->usertype = $row['user_type'];
                return true;
            }
        }
        return false;
    }

    /* Login with username and password */
    public function LoginAccountCheck(int $id): bool
    {
        global $pdo;
        $query = 'SELECT * FROM gmcgookin01.wqf_account WHERE (users_account = :id) AND (isActive = 1)';
        $values = array(':id' => $id);
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Cannot confirm access to User Account');
        }
        $row = $res->fetch(PDO::FETCH_ASSOC);
        if (is_array($row)) {
            return true;
        }
        return false;
    }

    /* A check for the account username */
    public function isNameValid(string $name): bool
    {
        $valid = true;
        $len = mb_strlen($name);
        if (($len < 1) || ($len > 30)) {
            $valid = false;
        }

        return $valid;
    }

    /* A check for the account password */
    public function isPasswdValid(string $passwd): bool
    {
        $valid = true;
        $len = mb_strlen($passwd);
        if (($len < 8) || ($len > 21)) {
            $valid = false;
        }

        return $valid;
    }

    /* A check for the account ID */
    public function isIdValid(int $id): bool
    {
        $valid = true;
        if (($id < 1) || ($id > 1000000)) {
            $valid = false;
        }

        return $valid;
    }

    /* A check for the account ID */
    public function isUserTypeValid(int $usertype): bool
    {
        $valid = true;
        if (($usertype < 1) || ($usertype > 4)) {
            $valid = false;
        }

        return $valid;
    }

    /* Logout the current user */
    public function logout()
    {
        global $pdo;
        if (is_null($this->id)) {
            return;
        }
        $this->id = null;
        $this->name = null;
        $this->usertype = null;
        $this->authenticated = false;
    }

    /* Returns the account id having $name as name, or NULL if it's not found */
    public function getIdFromName(string $name): ?int
    {
        global $pdo;
        if (!$this->isNameValid($name)) {
            throw new Exception('Invalid user name');
        }
        $id = null;
        $query = 'SELECT user_id FROM gmcgookin01.wqf_users WHERE (username = :name)';
        $values = array(':name' => $name);

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
        $row = $res->fetch(PDO::FETCH_ASSOC);
        if (is_array($row)) {
            $id = intval($row['user_id'], 10);
        }
        return $id;
    }

    /* Admin initiated profile update */
    public function AdminUpdateArtistProfileImage(int $userid, string $artimage, int $last_edited_by)
    {
        global $pdo;
        $query = 'UPDATE gmcgookin01.wqf_artist SET wqf_artist.artimage = :artimage, wqf_artist.last_edited_by = :last_edited_by WHERE
            wqf_artist.userid = :userid';
        $values = array(':userid' => $userid, ':artimage' => $artimage, ':last_edited_by' => $last_edited_by);
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
    }

    /* Admin initiated profile update */
    public function AdminUpdateArtistProfile(int $artistid, int $appstatus, string $act_name, int $act_type, int $stage, string $timeslot, string $web, string $bio_short, string $bio_long, int $is_confirmed, int $is_active, int $last_edited_by)
    {
        global $pdo;

        $query = 'UPDATE gmcgookin01.wqf_artist SET astatus = :appstatus, act_name = :act_name, act_type = :act_type, stage = :stage, timeslot = :timeslot, web = :web, bio_short = :bio_short, bio_long = :bio_long, is_confirmed = :is_confirmed, is_active = :is_active ,last_edited_by = :last_edited_by WHERE wqf_artist.artist_id = :artistid';
        $values = array(':artistid' => $artistid, ':appstatus' => $appstatus, ':act_name' => $act_name, 'act_type' => $act_type, ':stage' => $stage, 'timeslot' => $timeslot, ':web' => $web, ':bio_short' => $bio_short, ':bio_long' => $bio_long, ':is_confirmed' => $is_confirmed, ':is_active' => $is_active, ':last_edited_by' => $last_edited_by);
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
        return $pdo->lastInsertId();
    }

    /* Artist initiated profile update */
    public function UpdateArtistProfile(int $artistid, string $act_name, string $web, string $bio_short, string $bio_long, int $last_edited_by)
    {
        global $pdo;
        $query = 'UPDATE gmcgookin01.wqf_artist SET act_name = :act_name, web = :web, bio_short = :bio_short, bio_long = :bio_long, last_edited_by = :last_edited_by WHERE wqf_artist.artist_id = :artistid';
        $values = array(':artistid' => $artistid, ':act_name' => $act_name, ':web' => $web, ':bio_short' => $bio_short, ':bio_long' => $bio_long, ':last_edited_by' => $last_edited_by);
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
    }

    /* Edit a user profile on the system */
    public function EditUserProfile(int $useid, string $fname, string $lname, int $gender, string $dob, string $address, int $town, string $postcode, string $tel, int $last_edited_by, string $username)
    {
        global $pdo;
        $fname = trim($fname);
        $lname = trim($lname);
        $query = 'UPDATE gmcgookin01.wqf_account, gmcgookin01.wqf_users SET wqf_account.fname = :fname, wqf_account.lname = :lname, wqf_account.gender = :gender, wqf_account.dob = :dob, wqf_account.address = :address, wqf_account.town = :town, wqf_account.postcode = :postcode, wqf_account.tel = :tel, wqf_account.last_edited_by = :last_edited_by, wqf_users.username = :username WHERE
            wqf_account.users_account = :useid AND wqf_users.user_id = :useid';
        $values = array(':useid' => $useid, ':fname' => $fname, ':lname' => $lname, ':gender' => $gender, ':dob' => $dob, ':address' => $address, ':town' => $town, ':postcode' => $postcode, ':tel' => $tel, ':last_edited_by' => $last_edited_by, ':username' => $username);
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
    }

    /* Edit a user profile photo */
    public function EditUserProfilePhoto(int $useid, string $useimage, int $last_edited_by)
    {
        global $pdo;
        $query = 'UPDATE gmcgookin01.wqf_account SET wqf_account.profile_img = :useimage, wqf_account.last_edited_by = :last_edited_by WHERE
            wqf_account.users_account = :useid';
        $values = array(':useid' => $useid, ':useimage' => $useimage, ':last_edited_by' => $last_edited_by);
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }

    }

     /* Edit a user profile on the system */
     public function AdminEditUserProfile(int $useid, int $active, int $valid, string $fname, string $lname, int $gender, string $address, int $town, string $postcode, string $tel, int $last_edited_by, string $username)
     {
         global $pdo;
         $fname = trim($fname);
         $lname = trim($lname);
         $query = 'UPDATE gmcgookin01.wqf_account, gmcgookin01.wqf_users SET wqf_account.isValid = :active, wqf_account.isActive = :valid, wqf_account.fname = :fname, wqf_account.lname = :lname, wqf_account.gender = :gender, wqf_account.address = :address, wqf_account.town = :town, wqf_account.postcode = :postcode, wqf_account.tel = :tel, wqf_account.last_edited_by = :last_edited_by, wqf_users.username = :username, wqf_users.is_active = :active WHERE
             wqf_account.users_account = :useid AND wqf_users.user_id = :useid';
         $values = array(':useid' => $useid, ':active' => $active, ':valid' => $valid, ':fname' => $fname, ':lname' => $lname, ':gender' => $gender,':address' => $address, ':town' => $town, ':postcode' => $postcode, ':tel' => $tel, ':last_edited_by' => $last_edited_by, ':username' => $username, ':active' => $active);
         try {
             $res = $pdo->prepare($query);
             $res->execute($values);
         } catch (PDOException $e) {

             throw new Exception('Database query error');
         }
     }

     /* Add a new user profile to the system and return its ID (the account_id column of the accounts table) */
    public function CreateArtistProfile(int $userid, string $act_name, string $artimage, string $web, string $bio_short, string $bio_long, int $last_edited_by)
    {
        global $pdo;
        $fname = trim($act_name);

        $query = 'INSERT INTO gmcgookin01.wqf_artist (userid, act_name, artimage, web, bio_short, bio_long, last_edited_by) VALUES (:userid, :act_name, :artimage, :web, :bio_short, :bio_long, :last_edited_by)';
        $values = array(':userid' => $userid, ':act_name' => $act_name, ':artimage' => $artimage, ':web' => $web, ':bio_short' => $bio_short, ':bio_long' => $bio_long, ':last_edited_by' => $last_edited_by);
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
            
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
        return $pdo->lastInsertId();
    }

    /* Upon Submission of users application it updates the usertype to 3, which will show the user the artist admin menu */
    public function UpdateUserToArtist(int $userid, int $user_type, int $isArtist)
    {
        global $pdo;
        $query = 'UPDATE gmcgookin01.wqf_users, gmcgookin01.wqf_account SET wqf_users.user_type = :user_type, wqf_account.isArtist = :isArtist WHERE wqf_users.user_id = :userid AND wqf_account.users_account = :userid';
        $values = array(':user_type' => $user_type, ':userid' => $userid, ':isArtist' => $isArtist);
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
    }

    /* Checks to see if the users ID already exists on the artist table, if TRUE, this will hide the "apply here" link at the bottom of the account/index.php page */
    public function ArtistCheck(int $id): bool
    {
        global $pdo;
        $query = 'SELECT * FROM gmcgookin01.wqf_artist WHERE (userid = :id)';
        $values = array(':id' => $id);
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Cannot confirm access to Artist Account');
        }
        $row = $res->fetch(PDO::FETCH_ASSOC);
        if (is_array($row)) {
            return false;
        }
        return true;
    }

    /* Checks to see if the users ID already exists on the artist table, if TRUE, this will hide the "apply here" link at the bottom of the account/index.php page */
    public function RequirementsCheck(int $id): bool
    {
        global $pdo;
        $query = 'SELECT * FROM gmcgookin01.wqf_req_artist WHERE (artistid = :id)';
        $values = array(':id' => $id);
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Cannot confirm access to Artist Account');
        }
        $row = $res->fetch(PDO::FETCH_ASSOC);
        if (is_array($row)) {
            return true;
        }
        return false;
    }

    /* Upon Submission of users application it updates the usertype to 3, which will show the user the artist admin menu */
    public function Schedule(int $act, int $stage, int $slot, int $last_edited_by)
    {
        global $pdo;
        $query = 'UPDATE gmcgookin01.wqf_artist SET wqf_artist.stage = :stage, wqf_artist.timeslot = :slot, wqf_artist.last_edited_by = :last_edited_by WHERE wqf_artist.artist_id = :act';
        $values = array(':act' => $act,':stage' => $stage, ':slot' => $slot, ':last_edited_by' => $last_edited_by);
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            print_r($values);
            throw new Exception('Database query error');
        }
    }

}