<!doctype html>
<html lang="en">
<?php
include("../config/database.php"); // Database Connection
include("../includes/session.php"); // Session Starting file
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php print $Development; ?></title>
    <meta name="author" content="name">
    <meta name="description" content="description here">
    <meta name="keywords" content="keywords,here">

    <link rel="stylesheet" href="../public/css/all.css">

     <!--Replace with your tailwind.css once created-->
    <link href="../public/css/emoji.css" rel="stylesheet"> 

    <!---Font Awesome CDN-->
<script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

<link href="../public/css/tailwind.min.css" rel=" stylesheet">
	<!--Replace with your tailwind.css once created-->



    <!--Jquery CDN-->
    <script src="../public/js/jquery-3.5.0.min.js"></script>

        <!-- Modal JS -->
    <script src="../public/js/alpine.min.js" defer></script>

    <!--SweetAlert2 animate css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
    /* blink color */
	.blink-bg{
		/* color: #fff; */
		/* padding: 10px; */
		/* display: inline-block; */
		border-radius: 5px;
		animation: blinking 2s infinite;
	}
	@keyframes blinking{
		0%		{ color: #10c018;}
		25%		{ color: #1056c0;}
		50%		{ color: #ef0a1a;}
		75%		{ color: #254878;}
		100%	{ color: #04a1d5;}
	}
</style>
</head><body class="h-screen overflow-hidden flex items-center justify-center" style="background: #edf2f7;">
    <!-- This is an example component -->
    <div class="font-sans">
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center bg-gray-100 ">

            <div class="relative sm:max-w-sm w-full mt-20">
                <div class="card bg-blue-400 shadow-lg  w-full h-full rounded-3xl absolute  transform -rotate-6"></div>
                <div class="card bg-red-400 shadow-lg  w-full h-full rounded-3xl absolute  transform rotate-6"></div>
                <div class="relative w-full rounded-3xl  px-6 py-4 bg-gray-100 shadow-md">
                    <label for="" class="block mt-6 text-xl text-gray-700 text-center font-semibold">
                    <?php print $Development; ?> (Control Panel)</label>
                    <form role="form" action="../actions/loginExecute.php" method="post">
                    <input type="hidden" name="CSRF_token" value="<?= $_SESSION['CSRF'] ?>">
                        <div>
                            <input type="text" placeholder="User" required name="User"
                                class="mt-1 block w-full border-none bg-gray-100 h-11 rounded-xl shadow-lg hover:bg-blue-100 focus:bg-blue-100 focus:ring-0" value="<?php if(!empty($_COOKIE['User'])){ print $_COOKIE['User']; }?>">
                        </div>

                        <div class="mt-7">
                            <input type="Password" placeholder="Password" required name="Password"
                                class="mt-1 block w-full border-none bg-gray-100 h-11 rounded-xl shadow-lg hover:bg-blue-100 focus:bg-blue-100 focus:ring-0" value="<?php if(!empty($_COOKIE['Password'])){ print $_COOKIE['Password']; }?>">
                        </div>

                        <div class="mt-7">
                            <input type="checkbox" <?php if(!empty($_COOKIE['User']) && !empty($_COOKIE['Password'])){ print "Checked"; } ?> name="remember" id="remember" class="inline-block mr-2">
                            <label for="remember" class="text-sm text-gray-900">
                                Remember Me
                            </label>
                         
                        </div>

                        
                        <div class="mt-7">
                            <input type="submit" name="submit" id="submit"
                                class="bg-blue-500 w-full py-3 rounded-xl text-white shadow-xl hover:shadow-inner focus:outline-none transition duration-500 ease-in-out  transform hover:-translate-x hover:scale-105"
                                value="Login">
                                <a href=""  class="text-sm text-gray-900"><b>Forgotten password?</b></a> 
                        </div>
                    </form>

                </div>
            </div>

            <div class="flex justify-center items-center mt-6">
                <a target="blank" href="<?php print $DevelopmentLink; ?>"> <span
                        class="inline-flex font-semibold px-5 ">Developed By <?php print $Development; ?> <br> &copy; 2024 To
                        <?php print date("Y"); ?></span></a>
            </div>
        </div>

    </div>

    <?php 
    //Validation
    if(!empty($_GET['notify']) and $_GET['notify']=='logout'){ ?>
    <script>
        $(document).ready(function () {
            logout_toster();
        });
    </script>

    <?php } else if(!empty($_GET['notify']) and $_GET['notify']=='login_faield'){ ?>
    <script>
        $(document).ready(function () {
            login_failed_toster();
        });
    </script>

<?php } else if(!empty($_GET['notify']) and $_GET['notify']=='ad'){ ?>
    <script>
        $(document).ready(function () {
            access_denied_toster();
        });
    </script>

<?php } else if(!empty($_GET['notify']) and $_GET['notify']=='inactive'){ ?>
    <script>
        $(document).ready(function () {
            inactive_toster();
        });
    </script>
 
 <?php } ?>

<!-- partial -->
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js'></script>

<script type="text/javascript">


    /*Toggle dropdown list*/
    function toggleDD(myDropMenu) {
        document.getElementById(myDropMenu).classList.toggle("invisible");
    }
    /*Filter dropdown options*/
    function filterDD(myDropMenu, myDropMenuSearch) {
        var input, filter, ul, li, a, i;
        input = document.getElementById(myDropMenuSearch);
        filter = input.value.toUpperCase();
        div = document.getElementById(myDropMenu);
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }
    }
    // Close the dropdown menu if the User clicks outside of it
    window.onclick = function (event) {
        if (!event.target.matches('.drop-button') && !event.target.matches('.drop-search')) {
            var dropdowns = document.getElementsByClassName("dropdownlist");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (!openDropdown.classList.contains('invisible')) {
                    openDropdown.classList.add('invisible');
                }
            }
        }
    }


    //Sweetalert bottom 
    function bottom_toster() {

        Swal.fire({
            toast: true,
            icon: 'success',
            title: 'Posted successfully',
            animation: false,
            position: 'bottom',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    }


//Login Failed !
function login_failed_toster() {

Swal.fire({
    toast: true,
    icon: 'error',
    title: 'Login Failed !',
    footer: 'Please Check Your User Name And Password.',
    animation: true,
    position: 'top',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
}


//Browser Failed !
function browser_failed_toster() {

Swal.fire({
    toast: true,
    icon: 'error',
    title: 'Firefox Ditected !!!',
    footer: 'Please Using Chrome / Microsoft Edge For Better Experience .',
    animation: true,
    position: 'top',
    showConfirmButton: false,

});
}

//logged out
function logout_toster() {

Swal.fire({
    toast: true,
    icon: 'success',
    title: 'Hello User !',
    text: 'You have logged out.',
    footer: 'Thank You For Using Our System.',
    animation: true,
    position: 'top',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
}



//logged out
function welcome() {

Swal.fire({
    toast: true,
    icon: 'info',
    title: 'Welcome ! ',
    text: 'You Can Now Access Your Account.',
    footer: 'Have A Nice Day !!',
    animation: true,
    position: 'top',
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
}


//Access Denied 
function access_denied_toster() {

Swal.fire({
    toast: true,
    icon: 'warning',
    title: 'Access Denied',
    text: ' You Do Not Have Access To This Resource .!',
    footer: 'Please Login Again.',
    animation: true,
    position: 'top',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
}


//Inactive Access
function inactive_toster() {

Swal.fire({
    toast: true,
    icon: 'info',
    title: 'Access Denied',
    text: 'Your Maintenance Is Over.!',
    footer: ' Please Contact Us 01883008651',
    animation: true,
    position: 'top',
    showConfirmButton: false,
    timer: 10000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
}

//Online & offline Status Checker
window.addEventListener('load', function() {

function updateOnlineStatus(event) {

  var condition = navigator.onLine ? "online" : "offline";

//   alert('you are in ' + condition);
 

if (condition == "online") {

let timerInterval
Swal.fire({
  icon: 'success',
  title: 'You Are In Offline!',
  html: 'I will close in <b></b> milliseconds.',
  timer: 4000,
  timerProgressBar: true,
  didOpen: () => {
    Swal.showLoading()
    const b = Swal.getHtmlContainer().querySelector('b')
    timerInterval = setInterval(() => {
      b.textContent = Swal.getTimerLeft()
    }, 100)
  },
  willClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
  /* Read more about handling dismissals below */
  if (result.dismiss === Swal.DismissReason.timer) {
    console.log('I was closed by the timer')
  }
})

}else{

    Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'You are In Offline!',
    footer: 'Checking your network cables, modem, and routers'
    })

}


}

window.addEventListener('online',  updateOnlineStatus);

window.addEventListener('offline', updateOnlineStatus);

});


//Firefox Ditector
if (navigator.userAgent.indexOf("Firefox") != -1) {
    browser_failed_toster();
    document.getElementById('submit').disabled = true;
  
}

</script>
</body>

</html>