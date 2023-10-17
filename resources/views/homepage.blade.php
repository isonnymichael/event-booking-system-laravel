<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Savinc | {{$title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

    <link rel="icon" href="/favicon.png" />
</head>

<body>
    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
        @if (session('error'))
            <div class="row">
                <div class="alert alert-danger" role="alert">
                    {{session('error')}}
                </div>
            </div>
        @endif

        <div class="row align-items-center g-lg-5 py-5">
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="display-4 fw-bold lh-1 mb-3">Welcome</h1>
                <p class="col-lg-10 fs-4">
                   <img src="/img/savinc-logo.png" alt="">
                </p>
            </div>

            <div id="container-login" class="col-md-10 mx-auto col-lg-6">
                <form class="p-4 p-md-5 border rounded-3 bg-light" method="post" action="/">
                    @csrf
                    <div class="form-floating mb-3">
                        <input name="email" type="email" class="form-control" id="email" placeholder="Email" required>
                        <label for="email">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="password" type="password" class="form-control" id="password"
                            placeholder="password" required>
                        <label for="password">Password</label>
                    </div>
                    <button class="w-100 btn btn-lg btn-primary" type="submit">Sign In</button>

                    <p class="mb-0 mt-3">Don't have an account yet? <button onclick="registerPage()" type="button" class="btn btn-link px-0">Create One.</button> </p>
                </form>
            </div>
            <div id="container-register" class="col-md-10 mx-auto col-lg-6 d-none">
                <form class="p-4 p-md-5 border rounded-3 bg-light" method="post" action="/register">
                    @csrf
                    <div class="form-floating mb-3">
                        <input name="name" type="text" class="form-control" id="name" placeholder="Name" required>
                        <label for="name">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="email" type="email" class="form-control" id="email" placeholder="Email" required>
                        <label for="email">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="password" type="password" class="form-control" id="password"
                            placeholder="password">
                        <label for="password" required>Password</label>
                    </div>
                    <button class="w-100 btn btn-lg btn-primary" type="submit">Sign Up</button>

                    <p class="mb-0 mt-3">Already have account? <button onclick="loginPage()" type="button" class="btn btn-link px-0">Login Here.</button> </p>
                </form>
            </div>

        </div>
    </div>
</body>

</html>

<script>
    function loginPage()
    {
        $("#container-register").addClass("d-none");
        $("#container-login").removeClass("d-none");
    }

    function registerPage()
    {
        $("#container-login").addClass("d-none");
        $("#container-register").removeClass("d-none");
    }
</script>
