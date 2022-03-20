<?php
session_start();
if(!isset($_SESSION['user'])){
    echo 'Not logged in';
    header('Location: ./login.html');
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
      body{
            background-color: #FFC0CB;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: #9F1111;
        }



    </style>

  </head>
  <body>
    <section id="propage">
    <div class="container">
        <form action="../PHP/update_profile.php" method="post" enctype="multipart/form-data">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="p-5 bg">
                        <h5>Date Preference</h5>
                        <label for="MaxCost" hidden>Maximum Cost</label>
                        <input name="MaxCost" class="form-control left-align my-2 p-2" id="MaxCost" type="text" placeholder="Maximum Cost"/>

                        <label for="MaxDist" hidden>Maximum Distance</label>
                        <input name="MaxDist" class="form-control left-align my-2 p-2" id="MaxDist" type="text" placeholder="Maximum Distance"/>

                        <label for="PreDateLen" hidden>Preferred date length (hours)</label>
                        <input name="PreDateLen" class="form-control left-align my-2 p-2" id="PreDateLen" type="text" placeholder="Preferred Date Length (hrs)"/>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="p-5 bg">
                        <h5>Personal Details</h5>
                        <label for="CngFN" hidden>Change your first name</label>
                        <input name="CngFN" class="form-control left-align my-2 p-2" id="CngFN" type="text" placeholder="Change your first name"/>

                        <label for="CngLN" hidden>Change your last name</label>
                        <input name="CngLN" class="form-control left-align my-2 p-2" id="CngLN" type="text" placeholder="Change your last name"/>

                        <label for="CngZip" hidden>Change your zip code</label>
                        <input name="CngZip" class="form-control left-align my-2 p-2" id="CngZip" type="text" placeholder="Change your zip code"/>

                        <label for="CngDob" hidden>Change your date of birth</label>
                        <input name="CngDob" class="form-control left-align my-2 p-2" id="CngDob" type="text" placeholder="Change your date of birth"/>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="p-5 bg">
                        <h5>Security</h5>
                        <label for="OldPwd" hidden>Old password</label>
                        <input name="OldPwd" class="form-control left-align my-2 p-2" id="OldPwd" type="text" placeholder="Old password"/>

                        <label for="NewPwd" hidden>New password</label>
                        <input name="NewPwd" class="form-control left-align my-2 p-2" id="NewPwd" type="text" placeholder="New password"/>

                        <label for="RenPwd" hidden>Re-enter password</label>
                        <input name="RenPwd" class="form-control left-align my-2 p-2" id="RenPwd" type="text" placeholder="Re-enter password"/>

                        <label for="CngEmail" hidden>Change your email</label>
                        <input name="CngEmail" class="form-control left-align my-2 p-2" id="CngEmail" type="text" placeholder="Change your email"/>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="p-5 bg">
                        <h5></h5>
                    <div class="text-center">
                        
                    </div>
                        <p class="lead text-center text-black"><h1><?php echo $_SESSION['user']['name']; ?></h1></p>
                        <h7></h7>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="p-5 bg">
                        <h5 class="font-weight-bold text-black">Preferred Catagories</h5>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" name="Entertainment" id="Entertainment">
                        <label class="form-check-label text-black h6" for="Entertainment">
                        Entertainment
                        </label>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" name="Concerts" id="Concerts">
                        <label class="form-check-label text-black h6" for="Concerts">
                        Concerts
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" name="Hiking" id="Hiking">
                        <label class="form-check-label text-black h6" for="Hiking">
                        Hiking
                        </label>
                        </div>
                        <div class="form-check">
                        <!-- <input class="form-check-input" type="checkbox" value="true" name="Bars" id="Bars">
                        <label class="form-check-label text-black h6" for="Bars">
                        Bars
                        </label> -->
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="p-5 bg">
                        <h5 class="font-weight-bold text-black mt-4">    </h5>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" name="Entertainment" id="Entertainment">
                        <label class="form-check-label text-black h6" for="Entertainment">
                        Food
                        </label>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" name="Restaurant" id="Restaurant">
                        <label class="form-check-label text-black h6" for="Restaurant">
                        Restaurant
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" name="Cafe" id="Cafe">
                        <label class="form-check-label text-black h6" for="Cafe">
                        Cafe
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" name="FastFood" id="FastFood">
                        <label class="form-check-label text-black h6" for="FastFood">
                        Fast Food
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" name="Alcohol" id="Alcohol">
                        <label class="form-check-label text-black h6" for="Alcohol">
                        Alcohol
                        </label>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="p-5 bg">
                        <h5 class="font-weight-bold text-black mt-4"></h5>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" name="Venue" id="Venue">
                        <label class="form-check-label text-black h6" for="Venue">
                        Venue
                        </label>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" name="Indoors" id="Indoors">
                        <label class="form-check-label text-black h6" for="Indoors">
                        Indoors
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" name="Outdoors" id="Outdoors">
                        <label class="form-check-label text-black h6" for="Outdoors">
                        Outdoors
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" name="SocialEvents" id="SocialEvents">
                        <label class="form-check-label text-black h6" for="SocialEvents">
                        Social Events
                        </label>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="p-5 bg">
                        <h5 class="font-weight-bold text-black mt-4"></h5>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" name="Anytime" id="Anytime">
                        <label class="form-check-label text-black h6" for="Anytime">
                        Anytime
                        </label>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" name="Morning" id="Morning">
                        <label class="form-check-label text-black h6" for="Morning">
                        Morning
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" name="Afternoon" id="Afternoon">
                        <label class="form-check-label text-black h6" for="Afternoon">
                        Afternoon
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" name="Evening" id="Evening">
                        <label class="form-check-label text-black h6" for="Evening">
                            Evening
                        </label>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-4 mt-4 pe-4">
                <button type="submit" class="btn btn-success">Save Changes</button>
                <button type="button" class="btn btn-danger">Delete Account</button>
                </div>
            </div>
        </form>
</div>
</section>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
