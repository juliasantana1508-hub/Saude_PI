<?php
session_start();
include("php/config/conexao.php");

$logado = isset($_SESSION['idLogin']);

if (!$logado) {
    header("Location: login.html");
    exit;
}

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saúde 360 - Serviços</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="icon/icon_BemEstar360.ico">

    <!-- CSS -->
    <link rel="stylesheet" href="./Css/estiloServico.css">
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
                        <a href="/Saude_PI_DSM-main/perfil.php" id="perfil-btn" class="perfil-link">
                            <img src="<?= $foto ?>" alt="Foto de perfil" class="foto-perfil">
                            <span class="nome-perfil">
                                <?= $nome ?>
                            </span>
                        </a>
                    </li>

                <?php else: ?>
                    <li><a href="./login.html" data-lang="login">Login</a></li>
                <?php endif; ?>

                <!-- Menu de Configurações -->
                <li class="config-menu">
                    <button id="config-btn" aria-haspopup="true" aria-expanded="false">⚙️</button>

                    <div class="dropdown" role="menu">
                        <button id="toggle-theme">🌙 Modo Escuro</button>
                        <button id="change-lang">🌎 Trocar Idioma</button>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <main class="conteudo">

        <!-- GUIA RÁPIDO -->
        <section class="guia-rapido">

            <h2>Onde Procurar Ajuda?</h2>

            <div class="guia-cards">

                <div class="guia-card">
                    <h3>🏥 UBS</h3>

                    <p>
                        Sintomas leves, consultas de rotina, vacinação,
                        acompanhamento de doenças crônicas.
                    </p>
                </div>

                <div class="guia-card">
                    <h3>🚑 UPA</h3>

                    <p>
                        Emergências, febre alta persistente,
                        dores intensas, acidentes e fraturas.
                    </p>
                </div>

                <div class="guia-card">
                    <h3>📱 SUS Digital</h3>

                    <p>
                        Agendamentos online, carteira de vacinação digital
                        e histórico médico.
                    </p>
                </div>

            </div>

        </section>

        <!-- SERVIÇOS -->
        <section class="servicos-container">

            <h2>Serviços Oferecidos</h2>

            <div class="accordion">

                <!-- UBS -->
                <button class="accordion-btn">
                    UBS – Unidade Básica de Saúde
                </button>

                <div class="accordion-content">

                    <ul>
                        <li>🩺 Consultas com clínico geral e especialistas</li>

                        <li>💉 Vacinação</li>

                        <li>🧪 Exames de rotina</li>

                        <li>
                            ❤️‍🩹 Acompanhamento de hipertensão e diabetes
                        </li>

                        <li>
                            <button onclick="abrirMapa('UBS')">
                                📍 Ver no Mapa
                            </button>
                        </li>
                    </ul>

                </div>

                <!-- UPA -->
                <button class="accordion-btn">
                    UPA – Unidade de Pronto Atendimento
                </button>

                <div class="accordion-content upa-content">

                    <div id="container-upas" class="container-upas"></div>

                </div>

                <!-- SUS DIGITAL -->
                <button class="accordion-btn">
                    SUS Digital
                </button>

                <div class="accordion-content">

                    <ul>

                        <li>📅 Agendamento de consultas</li>

                        <li>📲 Carteira de vacinação digital</li>

                        <li>📑 Acompanhamento de exames e receitas</li>

                        <li>
                            <a href="https://www.gov.br/saude/pt-br"
                               target="_blank">

                                🌐 Acessar site oficial

                            </a>
                        </li>

                    </ul>

                </div>

            </div>

        </section>

        <br><br>

        <!-- FEEDBACK -->
        <section class="feedback-servicos">

            <h3>
                Você conseguiu encontrar o serviço que procurava?
            </h3>

            <div class="feedback-buttons">

                <button class="btn-feedback" data-feedback="sim">
                    ✅ Sim
                </button>

                <button class="btn-feedback" data-feedback="nao">
                    ❌ Não
                </button>

                <button class="btn-feedback" data-feedback="parcial">
                    ⚠️ Parcialmente
                </button>

            </div>

            <div id="alert-container"></div>

        </section>

    </main>

    <!-- Rodapé -->
    <footer class="footer">
        <div class="footerContainer">
            <!-- Logo e nome -->
            <div class="footerBrand">
                <img src="./Img/Footer.png" alt="Bem Estar 360" class="footerLogo">
            </div>

            <div class="footerLinks">
                <ul>
                    <li><a href="./index.php" data-lang="home">Home</a></li>
                    <li><a href="./monitoramento.php" data-lang="monitoring">Monitoramento</a></li>
                    <li><a href="./calendario.php" data-lang="calendar">Agenda</a></li>
                    <li><a href="./servicos.php" data-lang="services">Serviços</a></li>
                    <li><a href="./quemSomos.php" data-lang="about">Quem somos</a></li>
                    <li><a href="./login.php" data-lang="login">Login</a></li>
                </ul>
            </div>

            <!-- Contato -->
            <div class="footerContato">
                <h4 data-lang="footerContactTitle">Contato</h4>
                <p data-lang="footerEmail">Email: contato@bemestar360.com</p>
                <p data-lang="footerPhone">Telefone: (11) 1234-5678</p>
                <div class="footerSocials">
                    <a href="#"><img src="./Img/face_icon.png" alt="Facebook"></a>
                    <a href="#"><img src="./Img/insta_icon.webp" alt="Instagram"></a>
                    <a href="#"><img src="./Img/X_icon.svg.png" alt="Twitter"></a>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="footerBottom">
            <p data-lang="footerCopy" data-lang="textFooter">&copy; 2025 Bem-Estar 360. Todos os direitos reservados.
            </p>
        </div>
    </footer>

    <script src="./JS/script.js"></script>
    <script src="./JS/scriptTraducao.js"></script>
    <script src="./JS/scriptAccordions.js"></script>
    <script src="./JS/scriptAlert.js"></script>

    <!-- MENU MOBILE -->
    <script>

        const toggle = document.querySelector(".menu-toggle");

        const menu = document.querySelector(".Navegacao ul");

        toggle.addEventListener("click", () => {

            menu.classList.toggle("show");

        });

    </script>

</body>
</html>