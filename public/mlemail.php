<?php
session_start();
error_reporting(-1);

$to = $from = $cc = $bcc = $subject = $message = $code = '';
$code = $_POST['code'];
if ($code == 'lushart48') {
    $to = $_POST['to_name'] . ' <' . $_POST['to_email'] . '>';
    $from = $_POST['from_name'] . ' <' . $_POST['from_email'] . '>';

    if (
        (isset($_POST['cc_name']) && !empty($_POST['cc_name'])) &&
        (isset($_POST['cc_email']) && !empty($_POST['cc_email']))
    ) {
        $cc = $_POST['cc_name'] . ' <' . $_POST['cc_email'] . '>';
    }

    if (
        (isset($_POST['bcc_name']) && !empty($_POST['bcc_name'])) &&
        (isset($_POST['bcc_email']) && !empty($_POST['bcc_email']))
    ) {
        $bcc = $_POST['bcc_name'] . ' <' . $_POST['bcc_email'] . '>';
    }
    $subject = $_POST['subject'];

    $message = '<html><head><title>ML Email Testing</title></head><body><p><strong>Details:</strong></p><p>' . $_POST['message'] . '</p></body></html>';

    $headers['MIME-Version'] = '1.0';
    $headers['Content-type'] = 'text/html; charset=utf-8';

    $headers['From'] = $from;
    $headers['Reply-To'] = $from;
    if (!empty($cc)) {
        $headers['Cc'] = $cc;
    }

    if (!empty($bcc)) {
        $headers['Bcc'] = $bcc;
    }

    $headers['X-Mailer'] = 'PHP/' . phpversion();

    if (mail($to, $subject, $message, $headers)) {
        $_SESSION['msg'] = 'Mail sent successfully!';
        $_SESSION['msg_type'] = 'success';
    } else {
        $_SESSION['msg'] = 'PHP Mail Function failed!';
        $_SESSION['msg_type'] = 'danger';
    }
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
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
                    <form class="needs-validation" novalidate="" method="POST" action="">
                        <div class="row g-3">

                            <div class="col-lg-6">
                                <label for="to_name" class="form-label">To Name:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="to_name" id="to_name" placeholder="John Doe" value="ML-Service" required="required">
                                <div class="invalid-feedback">
                                    To Name is required.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="to_email" class="form-label">To Email:<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="to_email" id="to_email" placeholder="johndoe@google.com" value="service@medialinkers.com" required="required">
                                <div class="invalid-feedback">
                                    To email address is required.
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="from_name" class="form-label">From Name:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="from_name" id="from_name" placeholder="John Doe" value="Sajjad" required="required">
                                <div class="invalid-feedback">
                                    From Name is required.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="from_email" class="form-label">From Email:<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="from_email" id="from_email" placeholder="johndoe@google.com" value="sajj@medialinkers.com" required="required">
                                <div class="invalid-feedback">
                                    From email address is required.
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="cc_name" class="form-label">Cc Name:</label>
                                <input type="text" class="form-control" name="cc_name" id="cc_name" placeholder="John Doe" value="John Doe">
                                <div class="invalid-feedback">
                                    Cc Name is required.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="cc_email" class="form-label">Cc Email:</label>
                                <input type="email" class="form-control" name="cc_email" id="cc_email" placeholder="johndoe@google.com" value="">
                                <div class="invalid-feedback">
                                    Cc email address is required.
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <label for="bcc_name" class="form-label">Bcc Name:</label>
                                <input type="text" class="form-control" name="bcc_name" id="bcc_name" placeholder="John Doe" value="John Doe">
                                <div class="invalid-feedback">
                                    Bcc Name is required.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="bcc_email" class="form-label">Bcc Email:</label>
                                <input type="email" class="form-control" name="bcc_email" id="bcc_email" placeholder="johndoe@google.com" value="">
                                <div class="invalid-feedback">
                                    Bcc email address is required.
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="subject" class="form-label">Subject:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" value="Testing Email Functionality" required="required">
                                <div class="invalid-feedback">
                                    Subject is required.
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="message" class="form-label">Message:<span class="text-danger">*</span></label>
                                <textarea class="form-control" name="message" id="message" placeholder="Message" required="required">Email recieved from <?php echo $_SERVER['HTTP_HOST']; ?></textarea>
                                <div class="invalid-feedback">
                                    Message is required.
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="code" class="form-label">Code:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="code" id="code" placeholder="Code" value="" required="required">
                                <div class="invalid-feedback">
                                    Code is required.
                                </div>
                            </div>

                            <button class="w-100 btn btn-primary btn-lg" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </main>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© <?php echo date('Y'); ?> Medialinkers.com</p>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
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
    </script>
</body>

</html>