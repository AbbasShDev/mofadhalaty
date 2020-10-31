<?php
class Uploader {

    public $file;
    public $fileName;
    public $filePath;
    protected $rootDir;
    protected $uploadDir;
    protected $allowedFilesType = [];
    protected $errors = [];

    public function __construct($uploadDir, $allowedFilesType, $rootDir){

        $this->allowedFilesType = $allowedFilesType;

        $this->rootDir = $rootDir;

        $this->filePath = $uploadDir;
        $this->uploadDir = $this->rootDir.'/'.$uploadDir;
    }

    protected function validate(){

        if (!$this->isMimeAllowed()){
            array_push($this->errors, 'تسيق الملف غير مسموح به');
        }elseif (!$this->isSizeAllowed()){
            array_push($this->errors, 'حجم الملف غير مسموح به');
        }

        return $this->errors;
    }

    protected function createUploadDir(){
        if (!is_dir($this->uploadDir)){
            umask(0);
            if (!mkdir($this->uploadDir,0775)){
                array_push($this->errors, 'لا يمكن انشاء مسار الملف');
                return false;
            }
        }
        return true;
    }

    public function upload(){

        $this->fileName = time().$this->file['name'];
        $this->filePath .= '/'.$this->fileName;


        if ($this->validate()){
            return $this->errors;
        }elseif (!$this->createUploadDir()){
            return $this->errors;
        }elseif (!move_uploaded_file($this->file['tmp_name'], $this->uploadDir.'/'.$this->fileName)){
            array_push($this->errors, 'حدث خطأ اثناء تحميل الملف');
        }

        return $this->errors;
    }

    protected function isMimeAllowed(){

//        $allowedTypes = [
//            'jpg' =>'image/jpeg',
//            'png' =>'image/png',
//            'gif' =>'image/gif'
//        ];

        $verifyimg = getimagesize($this->file['tmp_name']);

        $finfoMime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $this->file['tmp_name']);

        $fileType = mime_content_type($this->file['tmp_name']);

        if (!isset($verifyimg['mime']) || !in_array($verifyimg['mime'], $this->allowedFilesType)){
            return false;
        }elseif (!in_array($finfoMime, $this->allowedFilesType)){
            return false;
        }elseif (!in_array($fileType, $this->allowedFilesType)){
            return false;
        }

        return true;
    }

    protected function isSizeAllowed(){

        $allowedSize = 4 * 1024 * 1024;

        $fileSize = $this->file['size'];

        if ($fileSize > $allowedSize){
            return false;
        }

        return true;
    }

}