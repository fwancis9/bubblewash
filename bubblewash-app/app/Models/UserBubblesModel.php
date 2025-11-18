<?php

namespace App\Models;

use CodeIgniter\Model;

class UserBubblesModel extends Model
{
    protected $table = 'user_bubbles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['user_id', 'service_type', 'weight_kg', 'package_size', 'folded', 'price', 'status', 'pickup_date', 'pickup_time', 'created_at', 'updated_at'];

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
        
        if (!$db->tableExists('user_bubbles')) {
            $sql = "CREATE TABLE `user_bubbles` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `user_id` int(11) NOT NULL,
                `service_type` enum('weighted','package') NOT NULL,
                `weight_kg` int(11) DEFAULT NULL,
                `package_size` enum('small','medium','large') DEFAULT NULL,
                `folded` tinyint(1) DEFAULT 0,
                `price` decimal(10,2) NOT NULL,
                `status` enum('pending','bubbling','ready_for_pickup','completed','cancelled') DEFAULT 'pending',
                `pickup_date` date DEFAULT NULL,
                `pickup_time` time DEFAULT NULL,
                `created_at` datetime DEFAULT NULL,
                `updated_at` datetime DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `user_id` (`user_id`),
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            
            $db->query($sql);
        } else {
            $fields = $db->getFieldNames('user_bubbles');
            if (!in_array('pickup_date', $fields)) {
                $db->query("ALTER TABLE `user_bubbles` ADD `pickup_date` date DEFAULT NULL AFTER `status`");
            }
            if (!in_array('pickup_time', $fields)) {
                $db->query("ALTER TABLE `user_bubbles` ADD `pickup_time` time DEFAULT NULL AFTER `pickup_date`");
            }
            
            try {
                $db->query("ALTER TABLE `user_bubbles` MODIFY `status` enum('pending','bubbling','ready_for_pickup','completed','cancelled') DEFAULT 'pending'");
            } catch (\Exception $e) {
            }
        }
    }

    public function getUserBubbles(int $userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}

