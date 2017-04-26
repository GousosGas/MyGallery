<?php

use google\appengine\api\cloud_storage\CloudStorageTools;

/**
 * Created by PhpStorm.
 * User: gousos
 * Date: 4/12/2016
 * Time: 7:20 μμ
 */
class Photo extends Db_object
{


    protected static $db_table_fields = array('id', 'title', 'caption', 'alternative', 'description', 'filename', 'type', 'size');
    protected static $db_table = "photos";
    public $id;
    public $title;
    public $caption;
    public $alternative;
    public $description;
    public $filename;
    public $type;
    public $size;
    public $image_link;
    public $tmp_path;
    public $upload_directory = "images";
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


    /*basename — Returns trailing name component of path*/

    public function set_file($file)
    {
        if (empty($file) || !$file || !is_array($file)) {
            $this->errors[] = '<p class="alert alert-danger" role="alert">There was not file uploaded here</p>';

            return false;
        } elseif ($file['error'] != 0) {
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        } else {
            $this->filename = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];

        }
    }

    /*the path of cloud storage bucket*/
    public function google_path()
    {
        $options = ["gs_bucket_name" => "your_bucket_name"];
        $upload_url = CloudStorageTools::createUploadUrl('/upload/handler', $options);
        return $upload_url;
    }


    public function upload()
    {

        if (empty($this->filename) || empty($this->tmp_path)) {
            $this->errors[] = '<p class="alert alert-danger" role="alert">The file was not available</p>';


            return false;
        } elseif ($this->type != "image/jpeg" && $this->type != "image/png") {
            $this->errors[] = '<p class="alert alert-danger" role="alert">The file is not jpeg/png </p>';
            return false;

        } elseif (!empty($this->filename) || !empty($this->tmp_path)) {
            $this->google_path();
            $destination = "your_bucket_destination" . DS . $this->filename;
            /*moves file from temp location to google storage*/
            move_uploaded_file($this->tmp_path, $destination);

            return true;
        } else {
            return "The file failed to store in google cloud";
        }


    }

    /*Database image path*/
    public function image_path()
    {
        return $this->upload_directory . DS . $this->filename;
    }


    public function save()
    {
        $bucket = "your_bucket_name";
        $target_path = 'gs://' . $bucket . DS . $_SERVER["REQUEST_ID_HASH"] . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;

        if ($this->id) {
            $this->update();
        } else {
            if (!empty($this->errors)) {
                return false;
            }

            if (empty($this->filename) || empty($this->tmp_path)) {
                $this->errors[] = '<p class="alert alert-danger" role="alert">The file was not available</p>';
                return false;
            }


            if (file_exists($target_path)) {
                $this->errors[] = "The file {$this->filename} already exists";
                return false;

            }

            if (move_uploaded_file($this->tmp_path, $target_path)) {

                if ($this->create()) {
                    unset($this->tmp_path);
                    return true;
                }

            } else {
                $this->errors[] = "the file directory probably does not have permission";
                return false;
            }
        }
    }

    public function delete_photo()
    {
        if ($this->delete()) {
            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->image_path();
            return unlink($target_path) ? true : false;
        } else {
            return false;
        }
    }

    public function save_image()
    {

        global $database;
        $local_image_path = "https://storage.googleapis.com/project_name//";
        mysqli_real_escape_string($database->connection, $local_image_path);
        mysqli_real_escape_string($database->connection, $this->title);
        mysqli_real_escape_string($database->connection, $this->caption);
        mysqli_real_escape_string($database->connection, $this->alternative);
        mysqli_real_escape_string($database->connection, $this->description);
        mysqli_real_escape_string($database->connection, $this->filename);
        mysqli_real_escape_string($database->connection, $this->type);
        mysqli_real_escape_string($database->connection, $this->size);
        $sql = "INSERT INTO photos (title,caption,alternative,description,filename,type,size,image_link) ";
        $sql .= " VALUES ('$this->title','$this->caption','$this->alternative','$this->description','$this->filename','$this->type','$this->size','$local_image_path{$this->filename}')";

        $result = $database->query($sql);

        return $result;
    }

}