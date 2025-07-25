<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
</head>
<body class="bg-light d-flex align-items-center" style="height:100vh;">
    <div class="container animate__animated animate__fadeInUp" style="max-width: 400px;">
        <div class="card shadow text-center">
            <div class="card-body">
                <h1 class="mb-4">Welcome to SI Kepegawaian</h1>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>
                <a href="http://localhost:8081/launch/kepegawaian" class="btn btn-primary btn-lg mb-2">
                    <i class="fas fa-id-badge mr-2"></i>Login with SSO
                </a>
                <div class="mb-2">or</div>
                <a href="<?= esc($authUrl) ?>" class="btn btn-danger btn-lg">
                    <i class="fab fa-google mr-2"></i>Sign in with Google
                </a>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
