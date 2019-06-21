<?php 
$ipAddy = $_SERVER['REMOTE_ADDR'];

/**
 * Simple form sanitization
 * 
 * @param str String to be stripped of html tags and slashes
 * @return str Clean string
 */
function checkInput($str) 
{
    $str = @strip_tags($str);
    $str = @stripslashes($str);
    return $str;
}

if ($_POST) {
    $output = '<div class="form-output">';
    $output .= '<h1>Results:</h1>';
    $output .= '<h2>Name: '.checkInput($_POST['name']).'</h2>';
    $output .= '<h2>Email: '.checkInput($_POST['email']).'</h2>';
    $output .= '<h2>Phone: '.checkInput($_POST['thePhone']).'</h2>';
    $output .= '<h2>Message: '.checkInput($_POST['message']).'</h2>';
    $output .= '</div>';
    $output .= '<hr />';
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Great Form</title>
    <!-- JQuery -->        
<script   src="https://code.jquery.com/jquery-3.1.0.slim.min.js"   integrity="sha256-cRpWjoSOw5KcyIOaZNo4i6fZ9tKPhYYb6i5T9RSVJG8="   crossorigin="anonymous"></script>
<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<style>
    .form-template, .form-output {
        min-width: 290px;
        max-width: 600px;
        margin: 0 auto;
}
.phone-number .col-xs-3::after{
    content: "-";
    position:absolute;
    right: 5px;
    color: black;
    border: 0px solid;
    top: 5px;
}
.phone-number .col-xs-4{
    width:25%;
}
.phone-number .col-xs-3, .phone-number .col-xs-4{
    padding-left:0;
}
.phone-number {
    padding-bottom:30px;
}
</style>
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Earthling Code Test</a>
        </div><!-- /.navbar-header -->
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="http://www.gunnard.org">Gunnard</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div><!-- /.container -->
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h2>Hello, person from: <?php echo $ipAddy; ?>!</h2>
        <p>Hi!, please fill out this form and I guarentee that you will not be added to any email lists at all!</p>
      </div>
    </div>
    <div class="container">
        <?php if ($output) {
            echo $output;
        } ?>  
        <div class="form-template">
            <h1>Please fill out this form.</h1>
            <form name="info-form" action="#" onsubmit="return validateForm()" method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" name="email">
                </div>
                <label for="phone">Phone:</label>
                <div class="form-group phone-number">
                    <div class="col-xs-3">
                        <input type="tel" placeholder="608" id="phone1" name="phone" class="form-control" value="" size="3" maxlength="3">
                    </div>
                    <div class="col-xs-3">
                        <input type="tel" placeholder="123" id="phone2" name="phone" class="form-control" value="" size="3" maxlength="3">
                    </div>
                    <div class="col-xs-4">
                        <input type="tel" placeholder="1234" id="phone3"name="phone" class="form-control" value="" size="4" maxlength="4">
                        <input type="hidden" id="thePhone"name="thePhone" class="form-control" value="" size="4" maxlength="4" title="">
                    </div>
                </div><!-- /.phone-number -->
                <div class="form-group">
                    <label for="email">Message:</label>
                    <textarea class="form-control" id="message" name="message" rows="4" cols="50"></textarea>           
                </div>
                <button type="button submit" class="btn btn-primary">Submit</button>
            </form>
        </div> <!-- /.form-template -->
    </div><!-- /.container -->
<script>
/**
* Validates email address
*
* @param email string Email to validate
* @return bool 
*/
function validateEmail(email) {
    var userEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return userEmail.test(email);
}

/**
* Validates all input fields in the form alerting with a compilation of errors, if any
*/
function validateForm() {
    var theName = $('#name').val();
    var theEmail = $('#email').val();
    var phone1 = $('#phone1').val();
    var phone2 = $('#phone2').val();
    var phone3 = $('#phone3').val();
    var thePhone = phone1.concat(phone2, phone3); 
    var theMessage = $('#message').val();
    var passed = true;
    var message = '';

    if (theName == null || theName == "") {
        message = "Oops!: Your name must be filled out\n";
        passed = false;
    }
    if (theEmail == null || theEmail == "" || validateEmail(theEmail) == false) {
        message += "Oops!: Your email must be filled out\n";
        passed = false;
    }
    if (thePhone == null || thePhone == "" || thePhone.length < 10) {
        message += "Oops! Your Phone Number must be filled out\n";
        passed = false;
    }
    if (theMessage == null || theMessage == "") {
        message += "Oops!: We love hearing from people but your message seems empty :(\n";
        passed = false;
    }
    if (!passed) {
        alert(message);
        return false;
    } else {
        $('#thePhone').val(thePhone);
    }
}
</script>
</body>
</html>
