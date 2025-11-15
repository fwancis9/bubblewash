<?php

namespace App\Controllers;

class Email extends BaseController
{
    /**
     * Get the email service initialized with config
     */
    private function getEmailService()
    {
        $email = service('email');
        $emailConfig = config('Email');

        $email->initialize([
            'protocol' => $emailConfig->protocol,
            'SMTPHost' => $emailConfig->SMTPHost,
            'SMTPUser' => $emailConfig->SMTPUser,
            'SMTPPass' => $emailConfig->SMTPPass,
            'SMTPPort' => $emailConfig->SMTPPort,
            'SMTPCrypto' => $emailConfig->SMTPCrypto,
            'mailType' => $emailConfig->mailType,
            'charset' => $emailConfig->charset,
            'newline' => $emailConfig->newline,
        ]);

        return ['email' => $email, 'config' => $emailConfig];
    }

    /**
     * Generate verification email HTML template
     */
    private function getVerificationEmailTemplate(string $verificationUrl): string
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                body { 
                    font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif;
                    line-height: 1.5; 
                    color: #333; 
                    margin: 0; 
                    padding: 0; 
                    background-color: #f4f4f4;
                    font-size: 14px;
                }
                .email-wrapper {
                    max-width: 600px; 
                    margin: 0 auto; 
                    background-color: #ffffff;
                }
                .header { 
                    background-color: #007fff;
                    color: #ffffff;
                    padding: 30px 20px; 
                    text-align: center; 
                }
                .header h1 {
                    margin: 0;
                    font-size: 22px;
                    font-weight: 600;
                }
                .content { 
                    padding: 30px 25px; 
                    background-color: #ffffff;
                }
                .content h2 {
                    color: #333;
                    margin-top: 0;
                    font-size: 18px;
                    font-weight: 600;
                }
                .content p {
                    color: #666;
                    font-size: 14px;
                    margin-bottom: 16px;
                }
                .verification-button {
                    display: inline-block;
                    padding: 12px 32px;
                    background: #007fff;
                    color: white !important;
                    text-decoration: none;
                    border-radius: 5px;
                    font-weight: 600;
                    font-size: 14px;
                    margin: 24px 0;
                    text-align: center;
                }
                .verification-button:hover {
                    opacity: 0.9;
                }
                .footer { 
                    text-align: center; 
                    padding: 24px 20px; 
                    color: #999; 
                    font-size: 11px;
                    background-color: #f9f9f9;
                }
                .footer p {
                    margin: 4px 0;
                    color: #999;
                }
            </style>
        </head>
        <body>
            <div class="email-wrapper">
                <div class="header">
                    <h1>Welcome to BubbleWash!</h1>
                </div>
                <div class="content">
                    <h2>Verify Your Email Address</h2>
                    <p>Hello there!</p>
                    <p>Thank you for registering with <strong>BubbleWash</strong>. We\'re excited to have you on board!</p>
                    <p>To complete your registration and activate your account, please verify your email address by clicking the button below:</p>
                    <p><a href="' . $verificationUrl . '" style="color: #667eea; text-decoration: none;">' . $verificationUrl . '</a></p>
                    
                    <div style="text-align: center;">
                        <a href="' . $verificationUrl . '" class="verification-button">Verify Email Address</a>
                    </div>
                    
                    <p>If you have any questions or need assistance, feel free to contact our support team.</p>
                    <p>Best regards,<br><strong>The BubbleWash Team</strong></p>
                </div>
                <div class="footer">
                    <p>This is an automated email from BubbleWash</p>
                    <p>© ' . date('Y') . ' BubbleWash. All rights reserved.</p>
                    <p>If you did not request this email, please ignore it.</p>
                </div>
            </div>
        </body>
        </html>';
    }

    /**
     * Send verification email with token
     * 
     * @param string $toEmail Recipient email address
     * @param string $token Verification token
     * @return bool|array Returns true on success, or error array on failure
     */
    public function sendVerificationEmail(string $toEmail, string $token)
    {
        $emailService = $this->getEmailService();
        $email = $emailService['email'];
        $emailConfig = $emailService['config'];

        // Build verification URL with token (separate endpoint for token verification)
        $baseUrl = rtrim(base_url(), '/'); // Remove trailing slash if present
        $verificationUrl = $baseUrl . '/verify-from-email?token=' . urlencode($token);

        // Set email details
        $email->setFrom($emailConfig->fromEmail, $emailConfig->fromName);
        $email->setTo($toEmail);
        $email->setSubject('Verify Your BubbleWash Account');
        
        // Use template with actual token
        $message = $this->getVerificationEmailTemplate($verificationUrl);
        $email->setMessage($message);

        // Try to send the email
        if ($email->send()) {
            return true;
        } else {
            return [
                'status' => 'error',
                'message' => 'Email sending failed.',
                'debug' => $email->printDebugger(['headers', 'subject', 'body'])
            ];
        }
    }

    /**
     * Generate a verification token for the user
     * 
     * @param int $userId User ID
     * @return string Verification token
     */
    public function generateVerificationToken(int $userId): string
    {
        $userModel = new \App\Models\UserModel();
        $token = bin2hex(random_bytes(32)); // 64 character token
        $expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours')); // Token expires in 24 hours
        
        $userModel->update($userId, [
            'verification_token' => $token,
            'token_expires_at' => $expiresAt
        ]);
        
        return $token;
    }

    /**
     * Verify a user's email using the token
     * 
     * @param string $token Verification token
     * @return array|false Returns user data on success, false on failure
     */
    public function verifyEmail(string $token)
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('verification_token', $token)
                          ->where('token_expires_at >', date('Y-m-d H:i:s'))
                          ->first();
        
        if ($user) {
            // Mark as verified and clear token
            $userModel->update($user['id'], [
                'is_verified' => 1,
                'verification_token' => null,
                'token_expires_at' => null
            ]);
            
            return $user;
        }
        
        return false;
    }

    /**
     * Check if user's email is verified
     * 
     * @param int $userId User ID
     * @return bool
     */
    public function isEmailVerified(int $userId): bool
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);
        return $user && isset($user['is_verified']) && $user['is_verified'] == 1;
    }
}