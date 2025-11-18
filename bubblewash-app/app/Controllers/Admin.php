<?php

namespace App\Controllers;

class Admin extends BaseController
{

    public function getIndex($section = null)
    {
        if ($section === null) {
            return redirect()->to('/admin/bubbles');
        }

        if (session()->get('admin_logged_in')) {
            $sectionInternal = str_replace('-', '_', $section);
            
            $data = [
                'isLoggedIn' => true,
                'activeSection' => $sectionInternal
            ];
            
            if ($sectionInternal === 'users') {
                $userModel = new \App\Models\UserModel();
                $perPage = 10;
                $data['users'] = $userModel->paginate($perPage);
                $data['pager'] = $userModel->pager;
            }
            
            if ($sectionInternal === 'bubbles') {
                $userBubblesModel = new \App\Models\UserBubblesModel();
                $userBubblesModel->createTableIfNotExists();
                $userModel = new \App\Models\UserModel();
                
                $perPage = 10;
                $allBubbles = $userBubblesModel->orderBy('created_at', 'DESC')
                                               ->paginate($perPage);
                
                foreach ($allBubbles as &$bubble) {
                    $user = $userModel->find($bubble['user_id']);
                    $bubble['user_email'] = $user ? $user['email'] : null;
                }
                
                $data['allBubbles'] = $allBubbles;
                $data['pager'] = $userBubblesModel->pager;
            }
            
            return view('admin', $data);
        } else {
            return redirect()->to('/login')->with('error', 'Please log in with admin credentials to access the admin panel.');
        }
    }

    public function postIndex()
    {
        return redirect()->to('/login')->with('error', 'Please use the main login page to access admin panel.');
    }

    public function getLogout()
    {
        session()->remove(['admin_username', 'admin_logged_in']);
        return redirect()->to('/login')->with('success', 'Admin logged out successfully.');
    }

    public function getDelete($userId)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/users');
        }

        $userModel = new \App\Models\UserModel();
        
        try {
            if ($userModel->delete($userId)) {
                return redirect()->to('/admin/users')->with('success', 'User deleted successfully.');
            } else {
                return redirect()->to('/admin/users')->with('error', 'Failed to delete user.');
            }
        } catch (\Exception $e) {
            return redirect()->to('/admin/users')->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }

    public function getEdit($userId)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to('/admin')->with('error', 'User not found.');
        }

        return view('admin_edit', [
            'user' => $user
        ]);
    }

    public function postEdit($userId)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to('/admin')->with('error', 'User not found.');
        }

        $rules = [
            'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']'
        ];

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            return view('admin_edit', [
                'user' => $user,
                'errors' => $errors
            ]);
        }

        $newEmail = $this->request->getPost('email');
        
        try {
            $userModel->update($userId, ['email' => $newEmail]);
            return redirect()->to('/admin')->with('success', 'User email updated successfully.');
        } catch (\Exception $e) {
            return view('admin_edit', [
                'user' => $user,
                'errors' => ['Failed to update email: ' . $e->getMessage()]
            ]);
        }
    }

    public function postUpdateBubbleStatus()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }

        $bubbleId = $this->request->getPost('bubble_id');
        $status = $this->request->getPost('status');

        $validStatuses = ['pending', 'bubbling', 'ready_for_pickup', 'completed', 'cancelled'];
        if (!in_array($status, $validStatuses)) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        try {
            $userBubblesModel = new \App\Models\UserBubblesModel();
            $userBubblesModel->update($bubbleId, [
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            $statusLabels = [
                'pending' => 'Pending',
                'bubbling' => 'Bubbling',
                'ready_for_pickup' => 'Ready for Pickup',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled'
            ];

            return redirect()->to('/admin/bubbles')->with('success', 'Order status updated to ' . $statusLabels[$status] . '.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update status: ' . $e->getMessage());
        }
    }

    public function postUpdateUser()
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $json = $this->request->getJSON();
        $userId = $json->user_id ?? null;
        $email = $json->email ?? null;

        if (!$userId || !$email) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Missing required fields'
            ]);
        }

        $rules = [
            'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']'
        ];

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            return $this->response->setJSON([
                'success' => false,
                'message' => implode(', ', $errors)
            ]);
        }

        try {
            $userModel = new \App\Models\UserModel();
            $user = $userModel->find($userId);

            if (!$user) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User not found'
                ]);
            }

            $userModel->update($userId, ['email' => $email]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'User updated successfully'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error updating user: ' . $e->getMessage()
            ]);
        }
    }
}