<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfileUploadModel extends Model
{
    protected $table = 'profile_uploads';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['user_id', 'filename', 'filepath', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;

    public function createTableIfNotExists()
    {
        $db = \Config\Database::connect();
        
        if (!$db->tableExists('profile_uploads')) {
            $sql = "CREATE TABLE `profile_uploads` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `user_id` int(11) NOT NULL,
                `filename` varchar(255) NOT NULL,
                `filepath` varchar(255) NOT NULL,
                `created_at` datetime DEFAULT NULL,
                `updated_at` datetime DEFAULT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `user_id` (`user_id`),
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            
            $db->query($sql);
        }
    }

    public function getProfilePictureByUserId(int $userId)
    {
        return $this->where('user_id', $userId)->first();
    }

    public function updateOrCreateProfilePicture(int $userId, string $filename, string $filepath)
    {
        $existing = $this->getProfilePictureByUserId($userId);
        
        if ($existing) {
            $oldFilePath = WRITEPATH . 'uploads/' . $existing['filepath'];
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            
            $this->update($existing['id'], [
                'filename' => $filename,
                'filepath' => $filepath,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            $this->insert([
                'user_id' => $userId,
                'filename' => $filename,
                'filepath' => $filepath,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}

