<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="login.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"> </script>

</head>

<body>
    <div class="container">
        <div class=" card">
            <form class="form-horizontal" role="form" id="registration_form">
                <h2>Registration Form</h2>
                <div class="form-group">
                    <label for="firstName" class="col-sm-3 control-label">Full Name : </label>
                    <div class="col-sm-9">
                        <input type="text" id="fullname" name="fullname" placeholder="Full Name" class="form-control" 
                         oninput="this.value = this.value.replace(/[^A-Za-z. ]/g, '')"  required>
                        <!-- <span class="help-block">Last Name, First Name, eg.: Smith, Harry</span> -->
                       
                    </div>
                </div>
                <div class="form-group">
                    <label for="uname" class="col-sm-3 control-label">Username :</label>
                    <div class="col-sm-9">
                        <input type="uname" id="uname" name="username" placeholder="Username" class="form-control"
                         oninput="this.value = this.value.replace(/[ ]/g, '')" required>
                  
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password : </label>
                    <div class="col-sm-9">
                        <input type="password" id="password" name="password" placeholder="Password" class="form-control" minlength="4" required>
                    
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm_password" class="col-sm-3 control-label">Confirm Password : </label>
                    <div class="col-sm-9">
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" class="form-control" minlength="4" required>
                    
                    </div>
                </div>
                <div class="form-group">
                    <label for="bio" class="col-sm-3 control-label">Bio : </label>
                  
                    <div class="col-sm-9">
                        <textarea name="bio" id="" cols="49" rows="5" maxlength="200" required></textarea>
                  
                    <small> allows upto 200 charcters</small>
                </div>
                </div> 
                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                        <button type="submit" class="btn btn-success btn-block">Register</button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                    <button type="button" class="btn btn-primary btn-block" onclick="this.form.reset();">Reset Form</button>

                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                    <button type="button" class="btn btn-primary btn-block" onclick>Reset Form</button>

                    </div>
                </div>
            </form>
            <script>
                $("#registration_form").submit(function(e) {
           
                    e.preventDefault(); // avoid to execute the actual submit of the form.

                    var form = $(this);
                    var actionUrl = form.attr('action');

                    pass =document.getElementById('password').value;
                    con_pass =document.getElementById('confirm_password').value;
                    
                    if (pass.localeCompare(con_pass) !== 0){
                        alert("Passwords do not match!");
                        return;
                    }

                    $.ajax({
                        type: "POST",
                        url: "form_validation.php",
                        data: "function=register&"+form.serialize(), // serializes the form's elements.
                        success: function(data) {
                           if(data == 1)
                           {
                            alert("you have sucessfully registserd!");
                            window.location.replace("login.php");
                           }
                           else{
                            alert(data);
                           }
                            
                        }
                    });

                });
            </script>
            <!-- /form -->
        </div> <!-- ./container -->
    </div> <!-- ./card -->
</body>

</html>