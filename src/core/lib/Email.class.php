<?php
  require_once(BASE_URI."core/lib/PHPMailer/PHPMailer.php");
  require_once(BASE_URI."core/lib/PHPMailer/Exception.php");
  require_once(BASE_URI."core/lib/PHPMailer/SMTP.php");
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  /**
   * Email
   */
  class Email
  {
    private $to;
    private $subject;
    private $body;
    private $altBody;

    function __construct($to, $subject, $body, $altBody)
    {
      $this->to = $to;
      $this->subject = $subject;
      $this->body = $body;
      $this->altBody = $altBody;
    }

    function send() {
      $mail = new PHPMailer(true);
      try {
          //Server settings
          $mail->SMTPDebug = 0;
          $mail->isSMTP();
          $mail->Host = SMTP_SERVER;
          $mail->SMTPAuth = SMTP_AUTH;
          $mail->Username = SMTP_USER;
          $mail->Password = SMTP_PASSWORD;
          $mail->SMTPSecure = SMTP_SECURE;
          $mail->Port = SMTP_PORT;

          //Recipients
          $mail->setFrom(SMTP_FROM, SMTP_NAME);
          $mail->addAddress($this->to);

          //Content
          $mail->isHTML(true);
          $mail->Subject = $this->subject;
          $mail->Body    = $this->body;
          $mail->AltBody = $this->altBody;

          $mail->send();
          return true;
      } catch (Exception $e) {
          //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
          return false;
      }
    }
  }

?>
