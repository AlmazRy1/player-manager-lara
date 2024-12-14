<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Manager</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary" href="/">Player Manager</a>
        </div>
    </nav>

    <div class="container p-3 mt-4 text-center">
        <h1 class="display-5 fw-bold text-primary">Добро пожаловать в Player Manager</h1>
        <div class="row mt-4 justify-content-center">
            @auth
            <div class="col-12 col-md-6 mb-3">
                <a href="/players" class="btn btn-primary btn-lg w-100 py-3">
                    <i class="bi bi-person"></i> Управление игроками
                </a>
            </div>
            <div class="col-12 col-md-6">
                <a href="/games" class="btn btn-success btn-lg w-100 py-3">
                    <i class="bi bi-controller"></i> Управление играми
                </a>
            </div>
            @else
            <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
                <h1 class="text-center mb-4">Вход</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control" 
                            placeholder="Введите ваш email" 
                            required 
                        >
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-control" 
                            placeholder="Введите ваш пароль" 
                            required 
                        >
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Войти</button>
                </form>
            </div>
            @endauth
        </div>
    </div>

    <footer class="bg-light text-center py-3 mt-5">
        <p class="mb-0 text-muted">© {{ date('Y') }} Player Manager. Все права защищены.</p>
    </footer>
</body>
</html>
