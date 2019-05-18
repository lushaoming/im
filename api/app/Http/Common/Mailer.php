<?php
/**
 * Desc: 邮件发送
 * User: Ming
 * Date: 2019/1/18
 * Time: 5:02 PM
 */
namespace App\Http\Common;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public function send($to, $subject, $body, $is_html = false)
    {
        $mail = new PHPMailer();

        try {
            //服务器配置
            $mail->CharSet ="UTF-8";                     //设定邮件编码
            $mail->SMTPDebug = 0;                        // 调试模式输出
            $mail->isSMTP();                             // 使用SMTP
            $mail->Host = 'smtp.qq.com';                // SMTP服务器
            $mail->SMTPAuth = true;                      // 允许 SMTP 认证
            $mail->Username = 'shaoming6.lu@qq.com';                // SMTP 用户名  即邮箱的用户名
            $mail->Password = 'rqqxsnwczxcjbcjf';             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
            $mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
            $mail->Port = 465;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持
            $mail->setFrom('shaoming6.lu@qq.com', '系统管理员');  //发件人

            // 多个收件人使用数组
            if (is_array($to)) {
                foreach ($to as $v) $mail->addAddress($v);  // 收件人
            } else {
                $mail->addAddress($to);  // 收件人
            }

            $mail->isHTML($is_html);                                  // 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
            $mail->Subject = $subject;
            $mail->Body    = $body;
//        $mail->AltBody = '如果邮件客户端不支持HTML则显示此内容';
            $mail->send();
            return true;
        } catch (\Exception $e) {
            echo $mail->ErrorInfo;
            exit;
        }



    }
}