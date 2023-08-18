<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
/******************************** */
require_once 'functions.php';
$pass_code = 'lushart48';
$cookie_name = "mlemail";

if (isset($_POST['code']) && !empty($_POST['code']) && $_POST['code'] == $pass_code) {
    sendMailThroughSMTP($_POST);
    /*********************** */
    $cookie_value = json_encode($_POST);
    setcookie($cookie_name, $cookie_value, time() + (60*60*24*365), "/");
    /********************** */
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

$send_with = 'mail';
$smtp_host = $_SERVER['HTTP_HOST'];
$smtp_port = 465;
$smtp_username = 'admin@' . $_SERVER['HTTP_HOST'];
$smtp_password = '4)eEwJTb$Er2';
$smtp_encryption = 'ssl';
$to_name = 'ML-Service';
$to_email = 'service@medialinkers.com';
$from_name = 'Admin Department';
$from_email = 'admin@' . $_SERVER['HTTP_HOST'];
$cc_name = 'John Doe';
$cc_email = 'johndoe@' . $_SERVER['HTTP_HOST'];
$bcc_name = 'John Smith';
$bcc_email = 'johnsmith@' . $_SERVER['HTTP_HOST'];
$subject = 'Testing Email Functionality';
$message = 'Email recieved from ' . $_SERVER['HTTP_HOST'];
$code = '';

if (isset($_COOKIE[$cookie_name])) {
    $cookieArray = json_decode($_COOKIE[$cookie_name]);

    $send_with = $cookieArray->send_with;
    $smtp_host = $cookieArray->smtp_host;
    $smtp_port = $cookieArray->smtp_port;
    $smtp_username = $cookieArray->smtp_username;
    $smtp_password = $cookieArray->smtp_password;
    $smtp_encryption = $cookieArray->smtp_encryption;
    $to_name = $cookieArray->to_name;
    $to_email = $cookieArray->to_email;
    $from_name = $cookieArray->from_name;
    $from_email = $cookieArray->from_email;
    $cc_name = $cookieArray->cc_name;
    $cc_email = $cookieArray->cc_email;
    $bcc_name = $cookieArray->bcc_name;
    $bcc_email = $cookieArray->bcc_email;
    $subject = $cookieArray->subject;
    $message = $cookieArray->message;
    $code = '';//$cookieArray->code;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ML-EMAIL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container">
        <main>
            <div class="py-5 text-center">
                <img class="d-block mx-auto mb-4" src="https://www.medialinkers.com/front/images/medialinkers_logo.png">
                <h2>Email Form</h2>
            </div>
            <?php if (!empty($_SESSION['msg'])) { ?>
                <div class="row g-5">
                    <div class="offset-lg-2 col-lg-8">
                        <div class="alert alert-<?php echo $_SESSION['msg_type']; ?>" role="alert">
                            <?php echo $_SESSION['msg']; ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            $_SESSION['msg'] = '';
            $_SESSION['msg_type'] = '';
            ?>
            <div class="row g-5">
                <div class="offset-lg-2 col-lg-8">
                    <h4 class="mb-3">Email Details</h4>
                    <form class="needs-validation" novalidate="" method="POST" action="" id="frm">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <label for="send_with" class="form-label">Send With:<span class="text-danger">*</span></label>
                                <select class="form-control" name="send_with" id="send_with" required="required">
                                    <option value="smtp" <?php echo ($send_with == 'smtp') ? 'selected="selected"' : ''; ?>>SMTP</option>
                                    <option value="mail" <?php echo ($send_with == 'mail') ? 'selected="selected"' : ''; ?>>Mail</option>
                                </select>
                                <div class="invalid-feedback">
                                    Send with is required.
                                </div>
                            </div>
                            <div class="col-lg-6 smtp_details">
                                <label for="smtp_host" class="form-label">SMTP Host:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="smtp_host" id="smtp_host" placeholder="<?php echo $smtp_host; ?>" value="<?php echo $smtp_host; ?>" required="required">
                                <div class="invalid-feedback">
                                    SMTP Host is required.
                                </div>
                            </div>
                            <div class="col-lg-6 smtp_details">
                                <label for="smtp_port" class="form-label">SMTP Port:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="smtp_port" id="smtp_port" placeholder="<?php echo $smtp_port; ?>" value="<?php echo $smtp_port; ?>" required="required">
                                <div class="invalid-feedback">
                                    SMTP Port is required.
                                </div>
                            </div>
                            <div class="col-lg-6 smtp_details">
                                <label for="smtp_username" class="form-label">SMTP Username:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="smtp_username" id="smtp_username" placeholder="<?php echo $smtp_username; ?>" value="<?php echo $smtp_username; ?>" required="required">
                                <div class="invalid-feedback">
                                    SMTP Username is required.
                                </div>
                            </div>
                            <div class="col-lg-6 smtp_details">
                                <label for="smtp_password" class="form-label">SMTP Password:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="smtp_password" id="smtp_password" placeholder="<?php echo $smtp_password; ?>" value="<?php echo $smtp_password; ?>" required="required">
                                <div class="invalid-feedback">
                                    SMTP Password is required.
                                </div>
                            </div>
                            <div class="col-lg-6 smtp_details">
                                <label for="smtp_encryption" class="form-label">SMTP Encryption:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="smtp_encryption" id="smtp_encryption" placeholder="<?php echo $smtp_encryption; ?>" value="<?php echo $smtp_encryption; ?>" required="required">
                                <div class="invalid-feedback">
                                    SMTP Encryption is required.
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="text-danger">
                                    <hr />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="to_name" class="form-label">To Name:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="to_name" id="to_name" placeholder="<?php echo $to_name; ?>" value="<?php echo $to_name; ?>" required="required">
                                <div class="invalid-feedback">
                                    To Name is required.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="to_email" class="form-label">To Email:<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="to_email" id="to_email" placeholder="<?php echo $to_email; ?>" value="<?php echo $to_email; ?>" required="required">
                                <div class="invalid-feedback">
                                    To email address is required.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="from_name" class="form-label">From Name:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="from_name" id="from_name" placeholder="<?php echo $from_name; ?>" value="<?php echo $from_name; ?>" required="required">
                                <div class="invalid-feedback">
                                    From Name is required.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="from_email" class="form-label">From Email:<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="from_email" id="from_email" placeholder="<?php echo $from_email; ?>" value="<?php echo $from_email; ?>" required="required">
                                <div class="invalid-feedback">
                                    From email address is required.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="cc_name" class="form-label">Cc Name:</label>
                                <input type="text" class="form-control" name="cc_name" id="cc_name" placeholder="<?php echo $cc_name; ?>" value="<?php echo $cc_name; ?>">
                                <div class="invalid-feedback">
                                    Cc Name is required.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="cc_email" class="form-label">Cc Email:</label>
                                <input type="email" class="form-control" name="cc_email" id="cc_email" placeholder="<?php echo $cc_email; ?>" value="<?php echo $cc_email; ?>">
                                <div class="invalid-feedback">
                                    Cc email address is required.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="bcc_name" class="form-label">Bcc Name:</label>
                                <input type="text" class="form-control" name="bcc_name" id="bcc_name" placeholder="<?php echo $bcc_name; ?>" value="<?php echo $bcc_name; ?>">
                                <div class="invalid-feedback">
                                    Bcc Name is required.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="bcc_email" class="form-label">Bcc Email:</label>
                                <input type="email" class="form-control" name="bcc_email" id="bcc_email" placeholder="<?php echo $bcc_email; ?>" value="<?php echo $bcc_email; ?>">
                                <div class="invalid-feedback">
                                    Bcc email address is required.
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="text-danger">
                                    <hr />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label for="subject" class="form-label">Subject:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="<?php echo $subject; ?>" value="<?php echo $subject; ?>" required="required">
                                <div class="invalid-feedback">
                                    Subject is required.
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label for="message" class="form-label">Message:<span class="text-danger">*</span></label>
                                <textarea class="form-control" name="message" id="message" placeholder="<?php echo $message; ?>" required="required"><?php echo $message; ?></textarea>
                                <div class="invalid-feedback">
                                    Message is required.
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="text-danger">
                                    <hr />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label for="code" class="form-label">Code:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="code" id="code" placeholder="<?php echo $code; ?>" value="<?php echo $code; ?>" required="required">
                                <div class="invalid-feedback">
                                    Code is required.
                                </div>
                            </div>
                            <button class="w-100 btn btn-primary btn-lg" type="button" id="submit_btn">Submit</button>
                    </form>
                </div>
            </div>
        </main>
        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© <?php echo date('Y'); ?> Medialinkers.com</p>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
            'use strict'
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')
            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()

        $('document').ready(function() {
            showHideSmtpDetails();
        });
        $('#send_with').on('change', function() {
            showHideSmtpDetails();
        });

        function showHideSmtpDetails() {
            if ($('#send_with').val() == 'mail') {
                $('.smtp_details').hide();
            } else {
                $('.smtp_details').show();
            }
        }
        $('#submit_btn').on('click', function(){
            $('#submit_btn').attr('diabled', true);
            $('#submit_btn').removeClass('btn-primary');
            $('#submit_btn').addClass('btn-secondary');
            $('#submit_btn').html('Sending email; Please wait...');
            $('#frm').submit();
        });
    </script>
</body>

</html>