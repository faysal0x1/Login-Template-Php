<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


class User
{
    private $id;
    private $username;
    private $email;
    private $password;

    public function __construct($id = "", $username = "", $email = "", $password = "")
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }



    // Getter and setter methods go here

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}

class Notify
{
    private $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function sendResetEmail(User $user)
    {
        $resetToken = self::generateResetToken();
        $this->saveResetToken($user, $resetToken);

        $resetLink = "http://localhost/Fiverr/Login-Php/reset-password.php?token=$resetToken";

        $mail = new PHPMailer(true);
        try {

            $mail->isSMTP();
            $mail->Host     = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = 'f8e08ed4155b95';
            $mail->Password = '6e2a89d59d59a0';
            $mail->SMTPSecure = 'tls';
            $mail->Port     = 2525;


            // Recipients
            $mail->setFrom('from@example.com', 'Your Name');
            $mail->addAddress($user->getEmail(), $user->getUsername());

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset';
            $mail->Body    = "Click the following link to reset your password: $resetLink";

            $mail->send();
            echo 'Password reset email sent successfully';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }


    public function sendOtpEmail(User $user,)
    {
        $otpCode = self::generateOtpCode();


        $this->saveOtpCode($user, $otpCode);

        $resetToken = self::generateResetToken();


        // $this->saveResetToken($user, $resetToken);

        $resetLink = "http://localhost/Fiverr/Login-Php/reset-password.php";

        $mail = new PHPMailer(true);

        try {
            // Server settings

            $mail->isSMTP();
            $mail->Host     = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = 'f8e08ed4155b95';
            $mail->Password = '6e2a89d59d59a0';
            $mail->SMTPSecure = 'tls';
            $mail->Port     = 2525;

            // Recipients
            $mail->setFrom('from@example.com', 'Your Name');
            $mail->addAddress($user->getEmail(), $user->getUsername());

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = "Your OTP code is: $otpCode";
            // $mail->Body = "<a>You can reset your password using this : $resetLink </a>";

            $mail->send();
            header("Location: Otp-Code.php");
            // echo 'OTP code sent successfully';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function generateOtpCode()
    {
        $otpCode = rand(100000, 999999);
        return $otpCode;
    }

    // public function resetPasswordWithOtp(User $user, $otpCode, $newPassword)
    // {
    //     if ($this->isValidOtp($user, $otpCode)) {
    //         // Update the user's password in the database
    //         $user->setPassword(password_hash($newPassword, PASSWORD_BCRYPT));
    //         // Save the user object to the database
    //         $this->updateUserPassword($user);
    //         echo 'Password reset successfully';
    //     } else {
    //         echo 'Invalid or expired OTP code';
    //     }
    // }

    public function isValidOtp($user, $otpCode)
    {
        $stmt = $this->db->prepare("SELECT * FROM otp_codes WHERE user_id = ? AND code = ? AND expires_at > NOW()");
        $stmt->execute([$user, $otpCode]);

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteOtp($userId, $otpCode)
    {

        $deleted = false;
        // Prepare statement 
        $stmt = $this->db->prepare("DELETE FROM otp_codes WHERE user_id = ? AND code = ?");

        // Execute statement with user id and code 
        $stmt->execute([$userId, $otpCode]);

        // Check if row was deleted
        if ($stmt->rowCount() > 0) {
            $deleted = true;
        }
        // Return true if deleted, false otherwise
        return $deleted;
    }



    // public  function resetPassword(User $user, $resetToken, $newPassword)
    // {
    //     if ($this->isValidToken($user, $resetToken)) {
    //         $this->invalidateToken($user, $resetToken);
    //         $user->setPassword(password_hash($newPassword, PASSWORD_BCRYPT)); // Hash the new password
    //         // Update the user's password in the database
    //         // Save the user object to the database
    //         $this->updateUserPassword($user['password'], $user['id']);
    //         echo 'Password reset successfully';
    //     } else {
    //         echo 'Invalid or expired token';
    //     }
    // }

    private static function generateResetToken()
    {
        return bin2hex(random_bytes(32));
    }

    public function generateResetTokenOtp()
    {
        return bin2hex(random_bytes(32));
    }

    public function saveResetToken($userId, $resetToken)
    {
        $expirationTime = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expiration time: 1 hour
        $stmt = $this->db->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $resetToken, $expirationTime]);
    }

    public function saveOtpCode(User $user, $otpCode)
    {
        $expirationTime = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expiration time: 1 hour

        // Check if a code already exists for the user

        $stmt = $this->db->prepare("SELECT * FROM otp_codes WHERE user_id = ?");

        $stmt->execute([$user->getId()]);

        if ($stmt->rowCount() > 0) {
            $stmt = $this->db->prepare("UPDATE otp_codes SET code = ?, expires_at = ? WHERE user_id = ?");
            $stmt->execute([$otpCode, $expirationTime, $user->getId()]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO otp_codes (user_id, code, expires_at) VALUES (?, ?, ?)");
            $stmt->execute([$user->getId(), $otpCode, $expirationTime]);
        }
    }

    private function isValidToken(User $user, $resetToken)
    {
        $stmt = $this->db->prepare("SELECT * FROM password_resets WHERE user_id = ? AND token = ? AND expires_at > NOW()");
        $stmt->execute([$user->getId(), $resetToken]);
        return $stmt->rowCount() > 0;
    }

    public function isValidTokenForOtp($userId, $resetToken)
    {
        $stmt = $this->db->prepare("SELECT * FROM password_resets WHERE user_id = ? AND token = ?");
        $stmt->execute([$userId, $resetToken]);
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isValidOtpCode(User $user, $otpCode)
    {

        $stmt = $this->db->prepare("SELECT * FROM otp_codes WHERE user_id = ? AND code = ? AND expires_at > NOW()");
        $stmt->execute([$user->getId(), $otpCode]);
        return $stmt->rowCount() > 0;
    }

    public function inValidOtp(User $user, $otpCode)
    {
        $stmt = $this->db->prepare("SELECT * FROM otp_codes WHERE user_id = ? AND code = ? AND expires_at < NOW()");
        $stmt->execute([$user->getId(), $otpCode]);
        return $stmt->rowCount() > 0;
    }


    private function invalidateToken(User $user, $resetToken)
    {
        $stmt = $this->db->prepare("DELETE FROM password_resets WHERE user_id = ? AND token = ?");
        $stmt->execute([$user->getId(), $resetToken]);
    }

    public function updateUserPassword($password, $userId)
    {

        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");

        $stmt->execute([$password, $userId]);

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    // Database retriving User data

    public function getUserId($email)
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");

        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            return $row['id'];
        } else {
            return false;
        }
    }

    public function getUser($email)
    {

        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            return $row;
        }
    }
}
