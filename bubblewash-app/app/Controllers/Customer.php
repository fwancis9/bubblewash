<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ProfileUploadModel;
use App\Models\UserBubblesModel;
use CodeIgniter\Files\File;

class Customer extends BaseController
{
    protected $helpers = ['form'];

    public function getIndex($section = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        if ($section === null) {
            return redirect()->to('/customer/weighted');
        }
        
        $userEmail = session()->get('user_email') ?? null;
        $userId = session()->get('user_id') ?? null;
        
        $sectionInternal = str_replace('-', '_', $section);
        
        $validSections = ['weighted', 'package', 'my_bubbles', 'my_profile', 'checkout'];
        if (!in_array($sectionInternal, $validSections)) {
            return redirect()->to('/customer/weighted');
        }
        
        $userData = null;
        $profilePicture = null;
        if ($sectionInternal === 'my_profile' && $userId) {
            $userModel = new UserModel();
            $profileUploadModel = new ProfileUploadModel();
            
            $profileUploadModel->createTableIfNotExists();
            
            $userData = $userModel->find($userId);
            $profilePicture = $profileUploadModel->getProfilePictureByUserId($userId);
        }
        
        $checkoutData = null;
        if ($sectionInternal === 'checkout') {
            $checkoutData = session()->get('checkout_data');
            if (!$checkoutData) {
                return redirect()->to('/customer/weighted')->with('error', 'No checkout data found.');
            }
        }
        
        $userBubbles = null;
        $pager = null;
        if ($sectionInternal === 'my_bubbles' && $userId) {
            $userBubblesModel = new UserBubblesModel();
            $userBubblesModel->createTableIfNotExists();
            
            $this->autoCancelExpiredOrders($userId);
            
            $perPage = 5;
            $userBubbles = $userBubblesModel->where('user_id', $userId)
                                            ->orderBy('created_at', 'DESC')
                                            ->paginate($perPage);
            $pager = $userBubblesModel->pager;
        }
        
        return view('customer', [
            'userEmail' => $userEmail,
            'userId' => $userId,
            'activeSection' => $sectionInternal,
            'userData' => $userData,
            'profilePicture' => $profilePicture,
            'checkoutData' => $checkoutData,
            'userBubbles' => $userBubbles,
            'pager' => $pager
        ]);
    }

    public function postUploadProfilePicture()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login');
        }

        if (!$this->validate('profilePictureRules')) {
            $errors = $this->validator->getErrors();
            $errorMessage = implode(' ', $errors);
            return redirect()->back()->with('error', $errorMessage);
        }

        $img = $this->request->getFile('profile_picture');
        
        if (!$img->hasMoved()) {
            $profileUploadModel = new ProfileUploadModel();
            $profileUploadModel->createTableIfNotExists();
            $existingProfile = $profileUploadModel->getProfilePictureByUserId($userId);
            
            if ($existingProfile) {
                $existingFilePath = WRITEPATH . 'uploads/' . $existingProfile['filepath'];
                
                if (file_exists($existingFilePath)) {
                    $newFileHash = md5_file($img->getTempName());
                    $existingFileHash = md5_file($existingFilePath);
                    
                    if ($newFileHash === $existingFileHash) {
                        return redirect()->back()->with('error', 'This picture is already set as your profile picture.');
                    }
                }
            }
            
            $profileUploadDir = WRITEPATH . 'uploads/profile_uploads';
            if (!is_dir($profileUploadDir)) {
                mkdir($profileUploadDir, 0755, true);
            }

            $newName = 'user_' . $userId . '_' . time() . '.' . $img->getExtension();
            $img->move($profileUploadDir, $newName);
            
            $filepath = 'profile_uploads/' . $newName;
            
            $profileUploadModel->updateOrCreateProfilePicture($userId, $newName, $filepath);
            
            return redirect()->to('/customer/my-profile')->with('success', 'Profile picture uploaded successfully!');
        }

        return redirect()->back()->with('error', 'The file has already been moved.');
    }

    public function postCheckout()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $serviceType = $this->request->getPost('service_type');
        $weightKg = $this->request->getPost('weight_kg');
        $packageSize = $this->request->getPost('package_size');

        if (!$serviceType || !in_array($serviceType, ['weighted', 'package'])) {
            return redirect()->back()->with('error', 'Invalid service type.');
        }

        if ($serviceType === 'weighted' && (!$weightKg || $weightKg < 1 || $weightKg > 10)) {
            return redirect()->back()->with('error', 'Invalid weight. Please select between 1-10 kg.');
        }

        if ($serviceType === 'package' && (!$packageSize || !in_array($packageSize, ['small', 'medium', 'large']))) {
            return redirect()->back()->with('error', 'Invalid package size.');
        }

        $basePrice = 0;
        if ($serviceType === 'weighted') {
            $basePrice = $weightKg * 50;
        } else {
            $packagePrices = ['small' => 275, 'medium' => 375, 'large' => 475];
            $basePrice = $packagePrices[$packageSize];
        }

        $checkoutData = [
            'service_type' => $serviceType,
            'weight_kg' => $weightKg,
            'package_size' => $packageSize,
            'base_price' => $basePrice
        ];
        session()->set('checkout_data', $checkoutData);

        return redirect()->to('/customer/checkout');
    }

    public function getCheckout()
    {
        $checkoutData = session()->get('checkout_data');
        
        if (!$checkoutData) {
            return redirect()->to('/customer/weighted')->with('error', 'No checkout data found.');
        }

        return $this->getIndex('checkout');
    }

    public function postConfirmOrder()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login');
        }

        $serviceType = $this->request->getPost('service_type');
        $weightKg = $this->request->getPost('weight_kg');
        $packageSize = $this->request->getPost('package_size');
        $folded = $this->request->getPost('folded') ? 1 : 0;
        $price = $this->request->getPost('price');
        $pickupDate = $this->request->getPost('pickup_date');
        $pickupTime = $this->request->getPost('pickup_time');

        if (!$serviceType || !$price || !$pickupDate || !$pickupTime) {
            return redirect()->back()->with('error', 'Missing required fields.');
        }

        $userBubblesModel = new UserBubblesModel();
        $userBubblesModel->createTableIfNotExists();

        $orderData = [
            'user_id' => $userId,
            'service_type' => $serviceType,
            'weight_kg' => $weightKg ?: null,
            'package_size' => $packageSize ?: null,
            'folded' => $folded,
            'price' => $price,
            'status' => 'pending',
            'pickup_date' => $pickupDate,
            'pickup_time' => $pickupTime,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $userBubblesModel->insert($orderData);

        session()->remove('checkout_data');

        return redirect()->to('/customer/my-bubbles')->with('success', 'Order placed successfully! Your laundry will be processed soon.');
    }

    private function autoCancelExpiredOrders($userId)
    {
        $userBubblesModel = new UserBubblesModel();
        
        $pendingOrders = $userBubblesModel->where('user_id', $userId)
                                          ->where('status', 'pending')
                                          ->findAll();
        
        $now = new \DateTime();
        
        foreach ($pendingOrders as $order) {
            $createdAt = new \DateTime($order['created_at']);
            $timeDiff = $now->getTimestamp() - $createdAt->getTimestamp();
            
            if ($timeDiff > 3600) {
                $userBubblesModel->update($order['id'], [
                    'status' => 'cancelled',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }
}

