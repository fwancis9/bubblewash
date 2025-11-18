<div style="position: absolute; top: 1rem; right: 1rem; z-index: 10; display: flex; gap: 0.5rem;">
    <a href="#" onclick="confirmChangePassword(event)" class="change-password-btn">Change Password</a>
    <a href="<?= site_url('logout') ?>" class="logout-btn">Log Out</a>
</div>

<div class="profile-container" style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 20px;">
    
    <div style="margin-bottom: 20px;">
        <?php if ($profilePicture): ?>
            <img src="<?= base_url('writable/' . esc($profilePicture['filepath'])) ?>" 
                 alt="Profile Picture" 
                 id="profileImage"
                 style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid #1f5f72; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
        <?php else: ?>
            <div id="profileImage" style="width: 150px; height: 150px; border-radius: 50%; background: linear-gradient(135deg, #1f5f72 0%, #164557 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                <span style="font-size: 60px; color: white; font-weight: bold;">
                    <?= strtoupper(substr($userData['email'] ?? 'U', 0, 1)) ?>
                </span>
            </div>
        <?php endif; ?>
    </div>
    
    <div style="margin-bottom: 30px;">
        <label for="profile_picture" class="upload-btn">
            Upload Picture
        </label>
    </div>
    
    <?= form_open_multipart('/customer/upload-profile-picture', ['id' => 'uploadForm']) ?>
        <input type="file" 
               name="profile_picture" 
               id="profile_picture" 
               accept="image/*"
               style="display: none;"
               onchange="document.getElementById('uploadForm').submit();">
    <?= form_close() ?>
    
    <div style="margin-bottom: 20px;">
        <div style="color: #666; font-size: 14px; margin-bottom: 5px;">Email</div>
        <div style="font-size: 18px; font-weight: 600; color: #333;">
            <?= esc($userData['email'] ?? 'N/A') ?>
        </div>
    </div>
    
    <div style="margin-bottom: 20px;">
        <div style="color: #666; font-size: 14px; margin-bottom: 5px;">Member Since</div>
        <div style="font-size: 16px; color: #555;">
            <?php if (isset($userData['created_at'])): ?>
                <?= date('F j, Y', strtotime($userData['created_at'])) ?>
            <?php else: ?>
                N/A
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.upload-btn {
    background-color: #1f5f72;
    color: #fff;
    padding: 0.5rem 1.5rem;
    border-radius: 2rem;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
    display: inline-block;
}

.upload-btn:hover {
    background-color: #164557;
}

.change-password-btn {
    background-color: #1f5f72;
    color: #fff;
    padding: 0.5rem 1.5rem;
    border-radius: 2rem;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    height: 40px;
    line-height: 1.5;
}

.change-password-btn:hover {
    background-color: #164557;
    color: #fff;
}

.logout-btn {
    background-color: #dc3545;
    color: #fff;
    padding: 0.5rem 1.5rem;
    border-radius: 2rem;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    height: 40px;
    line-height: 1.5;
}

.logout-btn:hover {
    background-color: #c82333;
    color: #fff;
}

.swal2-actions button {
    height: 40px !important;
    min-height: 40px !important;
    padding: 0.5rem 1.5rem !important;
}
</style>

<script>
    function confirmChangePassword(event) {
        event.preventDefault();
        
        Swal.fire({
            title: 'Change Password?',
            text: 'You will be logged out in order to change your password. Proceed?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, proceed',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#1f5f72',
            cancelButtonColor: '#6c757d',
            reverseButtons: true,
            customClass: {
                confirmButton: 'rounded-pill',
                cancelButton: 'rounded-pill'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= site_url('logout/for-change-password') ?>';
            }
        });
    }

    <?php if (session()->getFlashdata('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            html: `<?= addslashes(session()->getFlashdata('success')) ?>`,
            confirmButtonColor: '#1f5f72',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: `<?= addslashes(session()->getFlashdata('error')) ?>`,
            confirmButtonColor: '#1f5f72',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>
</script>