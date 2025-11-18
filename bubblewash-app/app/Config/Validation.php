<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public array $registerRules = [
        'email' => [
            'rules' => 'required|valid_email|is_unique[users.email]',
            'errors' => [
                'required'    => 'Email is required.',
                'valid_email' => 'Please enter a valid email address.',
                'is_unique'   => 'This email is already registered.'
            ]
        ],
        'password' => [
            'rules' => 'required|min_length[8]',
            'errors' => [
                'required'   => 'Password is required.',
                'min_length' => 'Password must be at least 8 characters long.'
            ]
        ],
        'confirm_password' => [
            'rules' => 'required|matches[password]',
            'errors' => [
                'required' => 'Please confirm your password.',
                'matches'  => 'Passwords do not match.'
            ]
        ]
    ];

    public array $loginRules = [
        'email' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Email or username is required.'
            ]
        ],
        'password' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Password is required.'
            ]
        ]
    ];

    public array $adminLoginRules = [
        'username' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Username is required.'
            ]
        ],
        'password' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Password is required.'
            ]
        ]
    ];

    public array $profilePictureRules = [
        'profile_picture' => [
            'label' => 'Profile Picture',
            'rules' => 'uploaded[profile_picture]|is_image[profile_picture]|mime_in[profile_picture,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[profile_picture,2048]|max_dims[profile_picture,4000,4000]',
            'errors' => [
                'uploaded' => 'Please select a profile picture to upload.',
                'is_image' => 'The file must be an image.',
                'mime_in' => 'Only JPG, JPEG, PNG, GIF, and WEBP images are allowed.',
                'max_size' => 'The image size must not exceed 2MB.',
                'max_dims' => 'The image dimensions must not exceed 4000x4000 pixels.'
            ]
        ]
    ];

    public array $forgotPasswordRules = [
        'email' => [
            'rules' => 'required|valid_email',
            'errors' => [
                'required'    => 'Please enter your email address.',
                'valid_email' => 'Please enter a valid email address.'
            ]
        ]
    ];

    public array $resetPasswordRules = [
        'token' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Reset token is required.'
            ]
        ],
        'password' => [
            'rules' => 'required|min_length[8]',
            'errors' => [
                'required'   => 'Password is required.',
                'min_length' => 'Password must be at least 8 characters long.'
            ]
        ],
        'confirm_password' => [
            'rules' => 'required|matches[password]',
            'errors' => [
                'required' => 'Please confirm your password.',
                'matches'  => 'Passwords do not match.'
            ]
        ]
    ];
}