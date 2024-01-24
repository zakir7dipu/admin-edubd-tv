<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait FileUploader
{
    /*
     |--------------------------------------------------------------------------
     | UPLOAD IMAGE
     |--------------------------------------------------------------------------
    */
    public function uploadImage($uploadImage, $model, $database_field_name, $basePath, $width, $height)
    {
        if ($uploadImage) {
            try {

                $basePath = 'assets/uploads/img/' . $basePath . '/' . date('Y') . '/' . date('m');
                $image_name = $model->id . time() . '-' . rand(11111, 999999) . '.' . 'webp';

                if ($model->$database_field_name == 'logo') {
                    dd('ok');
                }
                if (file_exists($model->$database_field_name) && $model->$database_field_name != '') {
                    unlink($model->$database_field_name);
                }

                if (!is_dir($basePath)) {
                    \File::makeDirectory($basePath, 493, true);
                }

                Image::make($uploadImage->getRealPath())
                    ->encode('webp', 90)
                    ->fit($width, $height)
                    // ->resize($width, $height, function ($constraint) {
                    //     $constraint->aspectRatio();
                    //     $constraint->upsize();
                    // })
                    ->save($basePath . '/' . $image_name);

                $model->update([$database_field_name => ($basePath . '/' . $image_name)]);

            } catch (\Exception $ex) {}
        }
    }





    /*
     |--------------------------------------------------------------------------
     | UPLOAD FILE
     |--------------------------------------------------------------------------
    */
    public function uploadFile($uploadFile, $model, $database_field_name, $base_path)
    {
        if ($uploadFile) {

            if (file_exists($model->$database_field_name)) {
                unlink($model->$database_field_name);
            }

            $new_file_name   = $model->id . '-' . time() . '-' . rand(11111, 999999) . '.' . $uploadFile->getClientOriginalExtension();

            $directory   = 'assets/uploads/' . $base_path . '/' . date('Y') . '/' . date('m') . '/';

            $uploadFile->move($directory, $new_file_name);

            $model->update([$database_field_name => $directory . $new_file_name]);
        }
    }






    /*
     |--------------------------------------------------------------------------
     | UPLOAD FILE IN GOOGLE DRIVE IN SPECIFIC DIRECTORY
     |--------------------------------------------------------------------------
    */
    public function uploadFileToGoogleDrive($uploaded_file, $model, $database_field_name)
    {

        if (isset($uploaded_file)) {

            try {

                $file_path = $uploaded_file->store("", 'google');

                $contents = collect(Storage::cloud()->listContents($directory = '/', $recursive = false));


                // get uploaded file by path
                $file = $contents->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($file_path, PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($file_path, PATHINFO_EXTENSION))
                    ->first(); // there can be duplicate file names!




                // set file permission
                $this->setGoogleDriveFilePermission($file['basename']);


                $model->update([$database_field_name => $file['path']]);

            } catch (\Exception $ex) {
                dd($ex->getMessage());
            }
        }
    }
    // public function uploadFileToGoogleDrive($uploaded_file, $model, $database_field_name)
    // {

    //     if (isset($uploaded_file)) {

    //         try {


    //             $file_path = $uploaded_file->store("", 'google');


    //             // get all files and make collection
    //             $contents = collect(Storage::cloud()->listContents($directory = '/', $recursive = false));


    //             // get uploaded file by path
    //             $file = $contents->where('type', '=', 'file')
    //                 ->where('filename', '=', pathinfo($file_path, PATHINFO_FILENAME))
    //                 ->where('extension', '=', pathinfo($file_path, PATHINFO_EXTENSION))
    //                 ->first(); // there can be duplicate file names!




    //             // set file permission
    //             $this->setGoogleDriveFilePermission($file['basename']);




    //             // <!-- update file name to database -->
    //             $model->update([$database_field_name => $file['path']]);
    //         } catch (\Exception $ex) {
    //             dd($ex->getMessage());
    //         }
    //     }
    // }





    /*
     |--------------------------------------------------------------------------
     | UPLOAD FILE IN GOOGLE DRIVE IN SPECIFIC DIRECTORY WITH RETURN FILE NANME AND PATH
     |--------------------------------------------------------------------------
    */
    private function uploadGoogleDriveFileWithPath($request, $field_name, $base_name)
    {
        if ($request->hasFile($field_name)) {

            $file = $request->file($field_name);

            if (isset($file)) {
                $fileName = $base_name . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

                $path = $file->store("", 'google');

                $fileName = $path;
                $dir = '/';
                $recursive = false;
                $contents = collect(Storage::cloud()->listContents($dir, $recursive));
                $file = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($fileName, PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($fileName, PATHINFO_EXTENSION))
                    ->first();

                $service = Storage::cloud()->getAdapter()->getService();
                $permission = new \Google_Service_Drive_Permission();
                $permission->setRole('reader');
                $permission->setType('anyone');
                $permission->setAllowFileDiscovery(false);
                $permissions = $service->permissions->create($file['basename'], $permission);

                $data = [
                    'file_path' => Storage::cloud()->url($file['path']),
                    'file_name' => $fileName
                ];

                return $data;
            }
        }
    }






    /*
     |--------------------------------------------------------------------------
     | DELETE FILE FROM GOOGLE DRIVE USING FILE NAME
     |--------------------------------------------------------------------------
    */
    public function deleteGoogleDriveFileByName($filename = null)
    {
        try {
            if ($filename) {
                $dir = '/';
                $recursive = false; // Get subdirectories also?
                $contents = collect(Storage::cloud()->listContents($dir, $recursive));

                $file = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
                    ->first(); // there can be duplicate file names!

                Storage::cloud()->delete($file['path']);
            }
        } catch (\Exception $ex) {
        }
    }






    /*
     |--------------------------------------------------------------------------
     | DELETE FILE FROM GOOGLE DRIVE USING FILE PATH
     |--------------------------------------------------------------------------
    */
    public function deleteGoogleDriveFileByPath($filepath = null)
    {
        try {
            if ($filepath) {
                Storage::cloud()->delete($filepath);
            }
        } catch (\Exception $ex) {
        }
    }






    /*
     |--------------------------------------------------------------------------
     | BACKUP DATABASE IN GOOGLE DRIVE
     |--------------------------------------------------------------------------
    */
    public function backupSavedToGoogleDrive()
    {
        try {

            $ds         = DIRECTORY_SEPARATOR;
            $path       = public_path() . $ds . 'app' . $ds . 'backups' . $ds;
            $file       = 'dump.sql';
            $directory  = $path . $file;
            $filename   = 'backup_' . fdate(now(), 'Y_m_d_h_i_s') . '.sql';


            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }

            try {
                MySql::create()
                    ->setDbName(env('DB_DATABASE'))
                    ->setUserName(env('DB_USERNAME'))
                    ->setPassword(env('DB_PASSWORD'))
                    ->setHost(env('DB_HOST'))
                    ->setPort(env('DB_PORT'))
                    ->doNotCreateTables()
                    ->dumpToFile($directory);


                try {


                    Storage::disk('google_backup')->put($filename, file_get_contents($directory));
                } catch (\Exception $ex) {

                    return 'Google Drive Credential Error';
                }
            } catch (\Exception $ex) {

                return 'Database Backup Error';
            }
        } catch (\Exception $ex) {

            return 'Internal Server Error';
        }

        return 'Database Successfully Backup To Drive';
    }




    /*
     |--------------------------------------------------------------------------
     | SET READ AND DELETE PERMISSION FOR ANYONE
     |--------------------------------------------------------------------------
    */
    private function setGoogleDriveFilePermission($file_basename)
    {

        $service = Storage::cloud()->getAdapter()->getService();

        $permission = new \Google_Service_Drive_Permission();
        $permission->setRole('reader');
        $permission->setType('anyone');
        $permission->setAllowFileDiscovery(false);

        $service->permissions->create($file_basename, $permission);
    }
}
