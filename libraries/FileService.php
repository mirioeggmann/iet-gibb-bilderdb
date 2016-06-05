<?php
class FileService {
    public function createUsereHome($userId) {
        if (!file_exists('./userHomes/'.$userId)) {
            mkdir('./userHomes/'.$userId.'/photos', 0777, true);
            mkdir('./userHomes/'.$userId.'/thumbnails', 0777, true);
        }
    }
    // Snipped: http://stackoverflow.com/questions/1334398/how-to-delete-a-folder-with-contents-using-php
    public function delete($path)
    {
        if (is_dir($path) === true)
        {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file)
            {
                $this->delete(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        }

        else if (is_file($path) === true)
        {
            return unlink($path);
        }

        return false;
    }


    public function deleteFile($path) {
        if (is_file($path) === true)
        {
            return unlink($path);
        }
        return false;
    }
}