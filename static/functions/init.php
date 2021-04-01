<?php
    require_once 'connect.php';
    require_once 'function.php';

    abstract class Event {
        const USER_PROFILE_EDIT = "แก้ไขข้อมูลผู้ใช้";
        const USER_PROBLEM_POST = "เพิ่มโจทย์";
        const USER_PROBLEM_EDIT = "แก้ไขโจทย์";
        const USER_SUBMISSION = "ส่ง Submission";
        const USER_ARTICLE_POST = "โพสต์";
        const USER_ARTICLE_EDIT = "แก้ไขโพสต์";
        const USER_ARTICLE_DELETE = "ลบโพสต์";

        const USER_FILE_FILE_CREATE = "เพิ่มไฟล์";
        const USER_FILE_FILE_DELETE = "ลบไฟล์";
        const USER_FILE_FOLDER_MKDIR = "สร้างโฟลเดอร์";
        const USER_FILE_FOLDER_RMDIR = "ลบโฟลเดอร์";

        const USER_REGISTER = "สร้างบัญชีใหม่";
        const USER_LOGIN = "ลงชื่อเข้าใช้";

        const STATE_WAIT = "รอดำเนินการ";
        const STATE_WORKING = "กำลังดำเนินการ";
        const STATE_DONE = "ดำเนินการเรียบร้อยแล้ว";
        const STATE_REJECT = "ปฏิเสธ";
        const STATE_RECHECK = "ต้องการข้อมูลเพิ่มเติม";
        
        const STATE_MSG_APPROVED = "อนุมัติ";

        const STATE_GET_REQUEST = "รับคำร้องและเอกสาร";
        const STATE_HEAD_UNIT = "หัวหน้าหน่วยของภาควิชา";
        const STATE_HEAD_DEPARTMENT = "หัวหน้าภาควิชา";
        const STATE_HEAD_PHARMACY_DEPARTMENT = "หัวหน้างานเภสัชกรรม";
        const STATE_HEAD_HOSPITAL = "ผู้อำนวยการ";
    }

    abstract class ErrorMessage {
        const AUTH_WRONG = "ERROR 01 : Wrong username or password";
        const AUTH_INVALID_EMAIL_TOKEN = "ERROR 06 : That email confirmation token is invalid, is that expired?";
        const AUTH_INVALID_RESET_PASSWORD_TOKEN = "ERROR 07 : That reset password token is invalid, is that expired?";
        
        const USER_NOT_FOUND = "ERROR 10 : User not found";
        const USER_ERROR = "ERROR 19 : Found conflict user";

        const FILE_IO = "ERROR 20 : Cannot performing File IO";
        const FILE_UPLOAD_NOT_FOUND = "ERROR 21 : Cannot locate the uploaded file";

        const DATABASE_ESTABLISH = "ERROR 40 : Cannot established with the database";
        const DATABASE_QUERY = "ERROR 41 : Cannot query with the database";
        const DATABASE_ERROR = "ERROR 49 : Unexpected internal database error";

        const SESSION_INVALID = "ERROR 60 : Session is invalid";
        
        const PERMISSION_REQUIRE = "ERROR 90 : You do not have enough permission";
        const PERMISSION_ERROR = "ERROR 99 : Found conflict permission";
    }

    abstract class Role {
        const ADMIN = "admin";
        const ROLES = array(Role::ADMIN);
    }

    class User {
        protected int $id;
        protected String $user, $email, $role, $name;
        public $profile, $properties;

        public function getID() {
            return $this->id;
        }
        public function setID(int $id) {
            $this->id = $id;
        }

        public function getUsername() {
            return $this->user;
        }
        public function setUsername(String $username) {
            $this->user = $username;
        }

        public function getName() {
            return $this->name;
        }
        public function setName(String $name) {
            $this->name = $name;
        }

        public function properties() {
            return $this->properties;   
        }
        public function getProperties(String $key) {
            if (empty($this->properties)) return false;
            return array_key_exists($key, $this->properties()) ? $this->properties()[$key] : false;
        }
        public function setProperties(String $key, $val) {
            $this->properties[$key] = $val;
            //Don't forget to update data in SQL!
        }

        public function isAdmin() {
            return $this->getProperties("admin");
        }

        public function getProfile() {
            $profile = $this->getProperties("profile");
            return empty($profile) ? "../static/elements/user.png" : $this->getProperties("profile");
        }
        public function setProfile(String $url) {
            return $this->setProperties("profile", $url);
        }

        public function getInfo() {
            return array(
                "id" => $this->id,
                "username" => $this->getUsername(),
                "name" => $this->getName(),
                "properties" => $this->properties()
            );
        }

        public function __construct(int $id) {
            $this->id = $id;
            $data = getUserData($id);
            if (!empty($data)) {
                $this->name = $data['name'];
                $this->user = $data['username'];
                $this->properties = json_decode($data['properties'], true);
            } else {
                $this->id = -1;
            }
        }
    }

    class Document {
        protected int $id;
        protected $properties, $data;

        public function getID() {
            return $this->id;
        }

        public function data() {
            return $this->data;   
        }
        public function getData(String $key) {
            if (empty($this->data)) return false;
            return array_key_exists($key, $this->data()) ? $this->data()[$key] : false;
        }
        public function setData(String $key, $val) {
            $this->data[$key] = $val;
            //Don't forget to update data in SQL!
        }

        public function properties() {
            return $this->properties;   
        }
        public function getProperties(String $key) {
            if (empty($this->properties)) return false;
            return array_key_exists($key, $this->properties()) ? $this->properties()[$key] : false;
        }
        public function setProperties(String $key, $val) {
            $this->properties[$key] = $val;
            //Don't forget to update data in SQL!
        }

        public function __construct(int $id) {
            $this->id = $id;
            if ($id > 0) {
                $post = getDocumentData($id);
                $this->id = $post['id'];
                $this->data = json_decode($post['data'], true);
                $this->properties = json_decode($post['properties'], true);
            } else {
                $this->id = -1;
                $this->data = array(
                    "flow" => array()
                );
                $this->properties = array(
                    "owner" => null,
                    "state" => array(
                        "current" => 0,
                        // 0 => User create submission
                        0 => array(
                            "status" => 0,
                            "comment" => null,
                            "update" => null
                        ),
                        // 1 => Head Unit
                        1 => array(
                            "status" => 0,
                            "comment" => null,
                            "update" => null
                        ),
                        // 2 => Head Department
                        2 => array(
                            "status" => 0,
                            "comment" => null,
                            "update" => null
                        ),
                        // 3 => Head of Pharmacy Department
                        3 => array(
                            "status" => 0,
                            "comment" => null,
                            "update" => null
                        ),
                        // 4 => Head of Hospital
                        4 => array(
                            "status" => 0,
                            "comment" => null,
                            "update" => null
                        )
                    )
                );
            }
        }
    }

?>