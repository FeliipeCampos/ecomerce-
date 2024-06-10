<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">Painel Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="criar_produto.php">Criar Produto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="visualizar_produtos.php">Visualizar Produtos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="vendas.php">Ver Vendas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="visualizar_usuarios.php">Visualizar Usuários</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="relatorios.php">Relatórios</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo($_SESSION['usuario_nome']) . ' ' .($_SESSION['usuario_sobrenome']); ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="editar_perfil.php">Editar Perfil</a></li>
                        <li><a class="dropdown-item" href="actions/logout.php">Sair</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Entrar</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
