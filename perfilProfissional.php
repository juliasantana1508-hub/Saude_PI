<?php
session_start();
include("php/config/conexao.php");

$logado = isset($_SESSION['idLogin']);

if (!isset($_SESSION['idLogin'])) {
    header("Location: login.html");
    exit;
}

if ($_SESSION['tipo'] !== 'profissional') {
    header("Location: index.php");
    exit;
}

$id = $_SESSION['idUsuario'];

$stmt = $conn->prepare("
    SELECT *
    FROM tblUsuario
    WHERE idUsuario = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

/*DADOS DO MÉDICO*/

$nome = $usuario['nomeUsuario'] ?? '';
$email = $usuario['emailUsuario'] ?? '';
$telefone = $usuario['telefoneUsuario'] ?? '';
$cpf = $usuario['cpfUsuario'] ?? '';
$endereco = $usuario['enderecoUsuario'] ?? '';

/* CAMPOS PROFISSIONAIS */
$crm = $usuario['crmMedico'] ?? '';
$especialidade = $usuario['especialidadeMedico'] ?? '';
$hospital = $usuario['hospitalMedico'] ?? '';
$biografia = $usuario['biografiaMedico'] ?? '';

/* FOTO */

$fotoBanco = $usuario['foto'] ?? null;

if (!empty($fotoBanco) && file_exists("uploads/" . $fotoBanco)) {
    $foto = "uploads/" . $fotoBanco;
} else {
    $foto = "Img/defaultUser.png";
}

/* ALERTAS */

if (isset($_GET['sucesso'])): ?>
    <script>
        window.history.replaceState({}, document.title, window.location.pathname);
        alert("Perfil atualizado com sucesso!");
    </script>
<?php endif;

if (isset($_GET['erro'])): ?>
    <script>
        const erro = "<?= $_GET['erro'] ?>";

        if (erro === "senhasDiferentes") {
            alert("As senhas não coincidem.");
        }

        if (erro === "preenchaAmbasSenhas") {
            alert("Preencha ambos os campos de senha.");
        }
    </script>
<?php endif; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-Estar 360 | Perfil Médico</title>

    <!-- CSS -->
    <link rel="stylesheet" href="Css/estilo.css">
    <link rel="stylesheet" href="Css/estiloPerfilUser.css">

    <!-- Bootstrap -->
    <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <!-- Header -->
    <header class="TopoSite">
        <div class="Logo">
            <img class="ImgLogo" id="logoSite" src="./Img/logoBemEstar-clara.png" alt="Logo BemEstar360">
        </div>

        <button class="menu-toggle" aria-label="Abrir menu">☰</button>

        <nav class="Navegacao">
            <ul>
                    <li><a href="./index.php" data-lang="home">Home</a></li>
                    <li><a href="./monitoramento.php" data-lang="monitoring">Monitoramento</a></li>
                    <li><a href="./calendario.php" data-lang="calendar">Agenda</a></li>
                    <li><a href="./servicos.php" data-lang="services">Serviços</a></li>
                    <li><a href="./quemSomos.php" data-lang="about">Quem somos</a></li>
                    <li><a href="./login.php" data-lang="login">Login</a></li>

                <?php if ($logado): ?>

                    <li class="perfil-menu">

                        <a href="perfilMedico.php" id="perfil-btn" class="perfil-link">
                            <img src="<?= $foto ?>" alt="Foto de perfil" class="foto-perfil">
                            <span class="nome-perfil"><?= $nome ?></span>
                        </a>
                    </li>

                <?php else: ?>

                    <li><a href="./login.html">Login</a></li>

                <?php endif; ?>

                <!-- Menu de Configurações -->
                <li class="config-menu">

                    <button id="config-btn">
                        ⚙️
                    </button>

                    <div class="dropdown">
                        <button id="toggle-theme">
                            🌙 Modo Escuro
                        </button>

                        <button id="change-lang">
                            🌎 Trocar Idioma
                        </button>
                    </div>

                </li>

            </ul>
        </nav>

    </header>

    <!-- SCRIPTS -->
    <script src="script.js"></script>
    <script src="scriptTraducao.js"></script>
    <script src="scriptShowLogin.js"></script>

    <script>

        /* TELEFONE */
        document.addEventListener("DOMContentLoaded", function () {
            const telefone = document.getElementById("telefone");
            telefone.addEventListener("input", function (e) {

                let v = e.target.value.replace(/\D/g, "");

                if (v.length > 11) {
                    v = v.slice(0, 11);
                }

                if (v.length > 10) {
                    v = v.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1) $2-$3");
                }

                else if (v.length > 6) {
                    v = v.replace(/^(\d{2})(\d{4})(\d+)/, "($1) $2-$3");
                }

                else if (v.length > 2) {
                    v = v.replace(/^(\d{2})(\d+)/, "($1) $2");
                }

                e.target.value = v;

            });

        });

        /* SENHAS */

        const formPerfil = document.querySelector(
            'form[action="php/usuario/updatePerfilMedico.php"]'
        );

        const novaSenha = document.getElementById("novaSenha");
        const confirmarSenha = document.getElementById("confirmarSenha");
        const erroSenha = document.getElementById("erroSenha");

        formPerfil.addEventListener("submit", function (e) {

            erroSenha.textContent = "";

            const senha = novaSenha.value.trim();
            const confirmacao = confirmarSenha.value.trim();

            if (senha !== "" || confirmacao !== "") {

                if (senha === "" || confirmacao === "") {

                    e.preventDefault();

                    erroSenha.textContent =
                        "Preencha os dois campos para alterar a senha.";

                    return;
                }

                if (senha !== confirmacao) {

                    e.preventDefault();

                    erroSenha.textContent =
                        "As senhas não coincidem.";

                    return;
                }
            }
        });

    </script>

    <!-- LAYOUT -->
    <div class="perfil-layout">

        <!-- SIDEBAR -->
        <aside class="sidebar">

            <div class="profile-box">

                <img src="<?= $foto ?>"
                    alt="Foto perfil"
                    class="foto-sidebar">

                <!-- UPLOAD FOTO -->
                <form action="php/usuario/uploadFoto.php"
                    method="POST"
                    enctype="multipart/form-data"
                    class="upload-form">

                    <label for="fotoInput" class="btn-upload">
                        Alterar foto
                    </label>

                    <input type="file"
                        id="fotoInput"
                        name="foto"
                        accept="image/png, image/jpeg, image/jpg, image/webp"
                        onchange="this.form.submit()"
                        hidden>

                </form>

                <h2><?= $nome ?></h2>

                <p>Médico(a)</p>

            </div>

            <!-- MENU -->
            <div class="sidebar-accordion">

                <details open class="sidebar-details">

                    <summary>Informações</summary>

                    <div class="menu">

                        <a href="#dados-pessoais">
                            Dados Pessoais
                        </a>

                        <a href="#dados-profissionais">
                            Dados Profissionais
                        </a>

                        <a href="#contato">
                            Contato
                        </a>

                        <a href="#seguranca">
                            Segurança
                        </a>

                    </div>

                </details>

                <!-- LOGOUT -->
                <form action="php/usuario/logout.php"
                    method="POST"
                    class="logout-form">

                    <button type="submit"
                        class="logout-btn">

                        Sair da Conta

                    </button>

                </form>

            </div>

        </aside>

        <!-- CONTEÚDO -->
        <main class="content">

            <details class="main-accordion" open>

                <summary>
                    Perfil Profissional
                </summary>

                <div class="card">
                    <form action="php/usuario/updatePerfilMedico.php" method="POST">

                        <!-- DADOS PESSOAIS -->
                        <details id="dados-pessoais"
                            class="accordion-item"
                            open>

                            <summary>
                                Dados Pessoais
                            </summary>

                            <div class="grid">
                                <div class="field">
                                    <label> Nome completo</label>
                                    <input type="text" name="nome" value="<?= $nome ?>">
                                </div>

                                <div class="field">
                                    <label>Email</label>
                                    <input type="email" name="email" value="<?= $email ?>">
                                </div>

                                <div class="field">
                                    <label>Telefone</label>
                                    <input type="text" id="telefone" name="telefone" value="<?= $telefone ?>" maxlength="15">
                                </div>

                                <div class="field">
                                    <label> CPF</label>
                                    <input type="text" name="cpf" value="<?= $cpf ?>">
                                </div>
                            </div>
                        </details>

                        <!-- DADOS PROFISSIONAIS -->
                        <details id="dados-profissionais"
                            class="accordion-item">

                            <summary>
                                Dados Profissionais
                            </summary>

                            <div class="grid">

                                <div class="field">

                                    <label>
                                        CRM
                                    </label>

                                    <input type="text"
                                        name="crm"
                                        value="<?= $crm ?>">

                                </div>

                                <div class="field">

                                    <label>
                                        Especialidade
                                    </label>

                                    <input type="text"
                                        name="especialidade"
                                        value="<?= $especialidade ?>">

                                </div>

                                <div class="field">

                                    <label>
                                        Hospital / Clínica
                                    </label>

                                    <input type="text"
                                        name="hospital"
                                        value="<?= $hospital ?>">

                                </div>

                            </div>

                            <div class="field mt-3">

                                <label>
                                    Biografia profissional
                                </label>

                                <textarea name="biografia"
                                    rows="5"><?= $biografia ?></textarea>

                            </div>

                        </details>

                        <!-- CONTATO -->
                        <details id="contato"
                            class="accordion-item">

                            <summary>
                                Endereço
                            </summary>

                            <div class="field">

                                <label>
                                    Endereço profissional
                                </label>

                                <input type="text"
                                    name="endereco"
                                    value="<?= $endereco ?>">

                            </div>

                        </details>

                        <!-- SEGURANÇA -->
                        <details id="seguranca"
                            class="accordion-item">

                            <summary>
                                Segurança
                            </summary>

                            <div class="grid">

                                <div class="field">

                                    <label>
                                        Nova senha
                                    </label>

                                    <input type="password"
                                        id="novaSenha"
                                        name="novaSenha">

                                </div>

                                <div class="field">

                                    <label>
                                        Confirmar senha
                                    </label>

                                    <input type="password"
                                        id="confirmarSenha"
                                        name="confirmarSenha">

                                </div>

                            </div>

                            <span id="erroSenha"
                                style="color:red;">
                            </span>

                        </details>

                        <!-- BOTÃO -->
                        <button type="submit"
                            class="btn-salvar">

                            Salvar Alterações

                        </button>

                    </form>

                </div>

            </details>

        </main>

    </div>

</body>

</html>