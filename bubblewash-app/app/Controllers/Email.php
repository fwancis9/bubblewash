<?php

namespace App\Controllers;

class Email extends BaseController
{
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
                    line-height: 1.6; 
                    color: #333; 
                    margin: 0; 
                    padding: 0; 
                    background: linear-gradient(135deg, #1f5f72 0%, #2a7a8f 100%);
                    font-size: 15px;
                }
                .email-wrapper {
                    max-width: 600px; 
                    margin: 40px auto; 
                    background-color: #ffffff;
                    border-radius: 16px;
                    overflow: hidden;
                    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
                }
                .header { 
                    background: linear-gradient(135deg, #1f5f72 0%, #2a7a8f 100%);
                    color: #ffffff;
                    padding: 40px 30px; 
                    text-align: center; 
                    position: relative;
                }
                .header h1 {
                    margin: 0;
                    font-size: 28px;
                    font-weight: 700;
                    letter-spacing: 0.5px;
                }
                .header p {
                    margin: 8px 0 0 0;
                    font-size: 15px;
                    opacity: 0.9;
                    color: #ffffff;
                }
                .content { 
                    padding: 40px 35px; 
                    background-color: #ffffff;
                }
                .content h2 {
                    color: #1f5f72;
                    margin-top: 0;
                    margin-bottom: 20px;
                    font-size: 22px;
                    font-weight: 700;
                }
                .content p {
                    color: #555;
                    font-size: 15px;
                    margin-bottom: 16px;
                    line-height: 1.7;
                }
                .verification-button {
                    display: inline-block;
                    padding: 14px 40px;
                    background: #1f5f72;
                    color: white !important;
                    text-decoration: none;
                    border-radius: 50px;
                    font-weight: 600;
                    font-size: 15px;
                    margin: 24px 0;
                    text-align: center;
                    box-shadow: 0 4px 15px rgba(31, 95, 114, 0.3);
                    transition: all 0.3s ease;
                }
                .verification-button:hover {
                    background: #164557;
                    box-shadow: 0 6px 20px rgba(31, 95, 114, 0.4);
                    transform: translateY(-1px);
                }
                .info-box {
                    background: #f8f9fa;
                    border-left: 4px solid #1f5f72;
                    padding: 16px 20px;
                    margin: 24px 0;
                    border-radius: 4px;
                }
                .info-box p {
                    margin: 0;
                    font-size: 14px;
                    color: #666;
                }
                .footer { 
                    text-align: center; 
                    padding: 30px 20px; 
                    color: #999; 
                    font-size: 12px;
                    background: linear-gradient(to bottom, #f8f9fa 0%, #e9ecef 100%);
                    border-top: 1px solid #e0e0e0;
                }
                .footer p {
                    margin: 6px 0;
                    color: #777;
                }
                .divider {
                    height: 1px;
                    background: linear-gradient(to right, transparent, #e0e0e0, transparent);
                    margin: 24px 0;
                }
            </style>
        </head>
        <body>
            <div class="email-wrapper">
                <div class="header">
                    <h1>🫧 BubbleWash</h1>
                    <p>Welcome aboard!</p>
                </div>
                <div class="content">
                    <h2>Verify Your Email Address</h2>
                    <p>Hello there!</p>
                    <p>Thank you for registering with <strong>BubbleWash</strong>.</p>
                    <p>To complete your registration and start using your account, please verify your email address by clicking the button below:</p>
                    
                    <div style="text-align: center;">
                        <a href="' . $verificationUrl . '" class="verification-button">Verify Email Address</a>
                    </div>
                    
                    <div class="info-box">
                        <p><strong>⏱ This link will expire in 24 hours</strong></p>
                        <p style="margin-top: 8px;">For security reasons, please verify your email soon. If the link expires, you can request a new one when you log in.</p>
                    </div>
                    
                    <div class="divider"></div>
                    
                    <p style="font-size: 13px; color: #888;">If the button doesn\'t work, copy and paste this link into your browser:</p>
                    <p style="font-size: 13px; word-break: break-all;"><a href="' . $verificationUrl . '" style="color: #1f5f72; text-decoration: none;">' . $verificationUrl . '</a></p>
                    
                    <div class="divider"></div>
                    
                    <p>If you have any questions or need assistance, feel free to contact our support team.</p>
                    <p style="margin-bottom: 0;">Best regards,<br><strong style="color: #1f5f72;">The BubbleWash Team</strong></p>
                </div>
                <div class="footer">
                    <p style="font-weight: 600; color: #555;">This is an automated email from BubbleWash</p>
                    <p>© ' . date('Y') . ' BubbleWash. All rights reserved.</p>
                    <p>If you did not request this email, please ignore it.</p>
                </div>
            </div>
        </body>
        </html>';
    }

    public function sendVerificationEmail(string $toEmail, string $token)
    {
        $emailService = $this->getEmailService();
        $email = $emailService['email'];
        $emailConfig = $emailService['config'];

        $baseUrl = rtrim(base_url(), '/');
        $verificationUrl = $baseUrl . '/verify-from-email?token=' . urlencode($token);

        $email->setFrom($emailConfig->fromEmail, $emailConfig->fromName);
        $email->setTo($toEmail);
        $email->setSubject('Verify Your BubbleWash Account');
        
        $message = $this->getVerificationEmailTemplate($verificationUrl);
        $email->setMessage($message);

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

    public function generateVerificationToken(int $userId): string
    {
        $userModel = new \App\Models\UserModel();
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours'));
        
        $userModel->update($userId, [
            'verification_token' => $token,
            'token_expires_at' => $expiresAt
        ]);
        
        return $token;
    }

    public function verifyEmail(string $token)
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('verification_token', $token)
                          ->where('token_expires_at >', date('Y-m-d H:i:s'))
                          ->first();
        
        if ($user) {
            $userModel->update($user['id'], [
                'is_verified' => 1,
                'verification_token' => null,
                'token_expires_at' => null
            ]);
            
            return $user;
        }
        
        return false;
    }

    public function isEmailVerified(int $userId): bool
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);
        return $user && isset($user['is_verified']) && $user['is_verified'] == 1;
    }

    private function getPasswordResetEmailTemplate(string $resetUrl): string
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
                    line-height: 1.6; 
                    color: #333; 
                    margin: 0; 
                    padding: 0; 
                    background: linear-gradient(135deg, #1f5f72 0%, #2a7a8f 100%);
                    font-size: 15px;
                }
                .email-wrapper {
                    max-width: 600px; 
                    margin: 40px auto; 
                    background-color: #ffffff;
                    border-radius: 16px;
                    overflow: hidden;
                    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
                }
                .header { 
                    background: linear-gradient(135deg, #1f5f72 0%, #2a7a8f 100%);
                    color: #ffffff;
                    padding: 40px 30px; 
                    text-align: center; 
                    position: relative;
                }
                .header h1 {
                    margin: 0;
                    font-size: 28px;
                    font-weight: 700;
                    letter-spacing: 0.5px;
                }
                .header p {
                    margin: 8px 0 0 0;
                    font-size: 15px;
                    opacity: 0.9;
                    color: #ffffff;
                }
                .content { 
                    padding: 40px 35px; 
                    background-color: #ffffff;
                }
                .content h2 {
                    color: #1f5f72;
                    margin-top: 0;
                    margin-bottom: 20px;
                    font-size: 22px;
                    font-weight: 700;
                }
                .content p {
                    color: #555;
                    font-size: 15px;
                    margin-bottom: 16px;
                    line-height: 1.7;
                }
                .reset-button {
                    display: inline-block;
                    padding: 14px 40px;
                    background: #1f5f72;
                    color: white !important;
                    text-decoration: none;
                    border-radius: 50px;
                    font-weight: 600;
                    font-size: 15px;
                    margin: 24px 0;
                    text-align: center;
                    box-shadow: 0 4px 15px rgba(31, 95, 114, 0.3);
                    transition: all 0.3s ease;
                }
                .reset-button:hover {
                    background: #164557;
                    box-shadow: 0 6px 20px rgba(31, 95, 114, 0.4);
                    transform: translateY(-1px);
                }
                .info-box {
                    background: #f8f9fa;
                    border-left: 4px solid #1f5f72;
                    padding: 16px 20px;
                    margin: 24px 0;
                    border-radius: 4px;
                }
                .info-box p {
                    margin: 0;
                    font-size: 14px;
                    color: #666;
                }
                .footer { 
                    text-align: center; 
                    padding: 30px 20px; 
                    color: #999; 
                    font-size: 12px;
                    background: linear-gradient(to bottom, #f8f9fa 0%, #e9ecef 100%);
                    border-top: 1px solid #e0e0e0;
                }
                .footer p {
                    margin: 6px 0;
                    color: #777;
                }
                .divider {
                    height: 1px;
                    background: linear-gradient(to right, transparent, #e0e0e0, transparent);
                    margin: 24px 0;
                }
            </style>
        </head>
        <body>
            <div class="email-wrapper">
                <div class="header">
                    <h1>🫧 BubbleWash</h1>
                    <p>Password Reset Request</p>
                </div>
                <div class="content">
                    <h2>Reset Your Password</h2>
                    <p>Hello!</p>
                    <p>We received a request to reset your password for your <strong>BubbleWash</strong> account.</p>
                    <p>To reset your password, please click the button below:</p>
                    
                    <div style="text-align: center;">
                        <a href="' . $resetUrl . '" class="reset-button">Reset Password</a>
                    </div>
                    
                    <div class="info-box">
                        <p><strong>⏱ This link will expire in 1 hour</strong></p>
                        <p style="margin-top: 8px;">For security reasons, please reset your password soon. If the link expires, you can request a new one from the login page.</p>
                    </div>
                    
                    <div class="divider"></div>
                    
                    <p style="font-size: 13px; color: #888;">If the button doesn\'t work, copy and paste this link into your browser:</p>
                    <p style="font-size: 13px; word-break: break-all;"><a href="' . $resetUrl . '" style="color: #1f5f72; text-decoration: none;">' . $resetUrl . '</a></p>
                    
                    <div class="divider"></div>
                    
                    <p>If you have any questions or need assistance, feel free to contact our support team.</p>
                    <p style="margin-bottom: 0;">Best regards,<br><strong style="color: #1f5f72;">The BubbleWash Team</strong></p>
                </div>
                <div class="footer">
                    <p style="font-weight: 600; color: #555;">This is an automated email from BubbleWash</p>
                    <p>© ' . date('Y') . ' BubbleWash. All rights reserved.</p>
                    <p>If you did not request this email, please ignore it.</p>
                </div>
            </div>
        </body>
        </html>';
    }

    public function generatePasswordResetToken(int $userId): string
    {
        $userModel = new \App\Models\UserModel();
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $userModel->update($userId, [
            'reset_token' => $token,
            'reset_token_expires_at' => $expiresAt
        ]);
        
        return $token;
    }

    public function sendPasswordResetEmail(string $toEmail, string $token)
    {
        $emailService = $this->getEmailService();
        $email = $emailService['email'];
        $emailConfig = $emailService['config'];

        $baseUrl = rtrim(base_url(), '/');
        $resetUrl = $baseUrl . '/reset-password?token=' . urlencode($token);

        $email->setFrom($emailConfig->fromEmail, $emailConfig->fromName);
        $email->setTo($toEmail);
        $email->setSubject('Reset Your BubbleWash Password');
        
        $message = $this->getPasswordResetEmailTemplate($resetUrl);
        $email->setMessage($message);

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

    public function verifyPasswordResetToken(string $token)
    {
        $token = trim($token);
        
        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('reset_token', $token)
                          ->where('reset_token_expires_at >', date('Y-m-d H:i:s'))
                          ->first();
        
        return $user ? $user : false;
    }
}