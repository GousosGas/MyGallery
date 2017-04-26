<?php
use google\appengine\api\cloud_storage\CloudStorageTools;

/**
 * Created by PhpStorm.
 * User: gousos
 * Date: 29/11/2016
 * Time: 1:42 πμ
 */
class User extends Db_object
{
    protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name', 'email', 'image_link');
    protected static $db_table = "users";
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $email;
    public $image_link;
    public $type;
    public $user_image;
    public $tmp_path;
    public $size;
    public $upload_directory = "images";
    public $image_placeholder = "http://placehold.it/180x180&text=image";
    public $errors = array();
    public $upload_errors_array = array(
        UPLOAD_ERR_OK => '<p class="alert alert-danger" role="alert">There is no error</p>',
        UPLOAD_ERR_INI_SIZE => '<p class="alert alert-danger" role="alert">The uploaded file exceeds the upload max file size</p>',
        UPLOAD_ERR_FORM_SIZE => '<p class="alert alert-danger" role="alert">The uploaded file exceeds the MAX_FILE_SIZE directive</p>',
        UPLOAD_ERR_PARTIAL => '<p class="alert alert-danger" role="alert">The uploaded file was only partially uploaded</p>',
        UPLOAD_ERR_NO_FILE => '<p class="alert alert-danger" role="alert">No file was uploaded</p>',
        UPLOAD_ERR_NO_TMP_DIR => '<p class="alert alert-danger" role="alert">Missing a temporary folder</p>',
        UPLOAD_ERR_CANT_WRITE => '<p class="alert alert-danger" role="alert">Failed to write file to disk</p>',
        UPLOAD_ERR_EXTENSION => '<p class="alert alert-danger" role="alert">A PHP extension stopped the file upload</p>'

    );


    /*method for creation of a new user*/
    public function create_user()
    {
        global $database;
        /*path to Cloud Storage*/
        $local_image_path = "https://storage.googleapis.com/project-name/";

        mysqli_real_escape_string($database->connection, $this->username);
        mysqli_real_escape_string($database->connection, $this->password);
        mysqli_real_escape_string($database->connection, $this->first_name);
        mysqli_real_escape_string($database->connection, $this->last_name);
        mysqli_real_escape_string($database->connection, $this->email);


        $sql = "INSERT INTO users (username,password,first_name,last_name,email,image_link) ";
        $sql .= " VALUES ('$this->username','$this->password','$this->first_name','$this->last_name','$this->email','$local_image_path{$this->user_image}')";

        $result = $database->query($sql);

        return $result;
    }


    public function image_for_user()
    {
        return $this->image_placeholder;
    }

    /*configures the image of a user*/
    public function set_file($file)
    {
        if (empty($file) || !$file || !is_array($file)) {
            $this->errors[] = "There was not file uploaded here";
            return false;
        } elseif ($file['error'] != 0) {
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        } else {
            $this->user_image = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
    }

    /*Saves the image of the user*/
    public function save_image_user()
    {

        if (!empty($this->errors)) {
            echo "there was an error in saving ";
            return false;

        }


        if (empty($this->user_image) || empty($this->tmp_path)) {
            $this->errors[] = "the file was not available";
            return false;
        }

        //target path
        $target_path = IMAGE_PATH . DS . $this->user_image;

        if (file_exists($target_path)) {
            $this->errors[] = "the file {$this->user_image} already exists";
            return false;
        }
        //move uploaded file --predifined in php
        if (move_uploaded_file($this->tmp_path, $target_path)) {
            unset($this->tmp_path);
            return true;
        } else {
            $this->errors[] = "the folder directory probably does not have the right permission";
            return false;
        }

    }

    public static function verify_user($username, $password)
    {
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);
        $sql = "SELECT * FROM " . self::$db_table . " WHERE username='{$username}' 
            AND password = '{$password}' LIMIT 1";

        $the_result_array = self::find_by_query($sql);
        return !empty($the_result_array) ? array_shift($the_result_array) : false;


    }

    /*methos for uploading the image of the user*/
    public function upload_image()
    {

        if (empty($this->user_image) || empty($this->tmp_path)) {
            $this->errors[] = '<p class="alert alert-danger" role="alert">The file was not available</p>';

            return false;

            /*checks the file type to restrict other files except jpeg and png*/
        } elseif ($this->type != "image/jpeg" && $this->type != "image/png") {
            $this->errors[] = '<p class="alert alert-danger" role="alert">The file is not jpeg/png </p>';
            return false;

        } elseif (!empty($this->user_image) || !empty($this->tmp_path)) {
            $this->google_path();
            $destination = "gs://my-project-test-150523.appspot.com/" . DS . $this->user_image;
            move_uploaded_file($this->tmp_path, $destination);

            return true;
        } else {
            return "The file failed to store in google cloud";
        }


    }

    /*method for google storage bucket*/
    public function google_path()
    {
        $options = ["gs_bucket_name" => "project_name"];
        $upload_url = CloudStorageTools::createUploadUrl('/upload/handler', $options);
        return $upload_url;
    }


}



