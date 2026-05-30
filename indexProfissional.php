<?php
session_start();
include("php/config/conexao.php");

/* VERIFICA LOGIN */
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

$nome = $usuario['nomeUsuario'] ?? '';
$email = $usuario['emailUsuario'] ?? '';
$telefone = $usuario['telefoneUsuario'] ?? '';
$cpf = $usuario['cpfUsuario'] ?? '';
$endereco = $usuario['enderecoUsuario'] ?? '';

if (empty($usuario['codigoVinculo'])) {
    $codigo = 'BSTR-' . strtoupper(substr(md5(uniqid()), 0, 6));

    $stmtCodigo = $conn->prepare("
        UPDATE tblUsuario 
        SET codigoVinculo = ? 
        WHERE idUsuario = ?
    ");
    $stmtCodigo->bind_param("si", $codigo, $id);
    $stmtCodigo->execute();

    $usuario['codigoVinculo'] = $codigo;
}

$codigoVinculo = $usuario['codigoVinculo'] ?? '';

$fotoBanco = $usuario['foto'] ?? null;

if (!empty($fotoBanco) && file_exists("uploads/" . $fotoBanco)) {
    $foto = "uploads/" . $fotoBanco;
} else {
    $foto = "Img/defaultUser.png";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-Estar 360 - Home Page </title>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const menuToggle = document.querySelector('.menu-toggle');
            const navegacao = document.querySelector('.Navegacao');

            menuToggle.addEventListener('click', () => {
                navegacao.classList.toggle('ativo');
            });

            document.querySelectorAll('.Navegacao a').forEach(link => {
                link.addEventListener('click', () => {
                    navegacao.classList.remove('ativo');
                });
            });
        });
    </script>

    <!-- API (Usabilidade) -->
    <script src="https://seeb-widget.pages.dev/widget.js" defer></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="icon/icon_BemEstar360.ico">

    <!-- CSS externo -->
    <link rel="stylesheet" href="Css/estilo.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_forward" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
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
                <li><a href="./indexProfissional.php" data-lang="home">Home</a></li>
                <li><a href="./calendario.php" data-lang="">Dashboard</a></li>
                <li><a href="./calendario.php" data-lang="">Agenda</a></li>

                <?php if ($logado): ?>
                    <li class="perfil-menu">
                        <a href="/Saude_PI_DSM-main/perfil.php" id="perfil-btn" class="perfil-link">
                            <img src="<?= $foto ?>" alt="Foto de perfil" class="foto-perfil">
                            <span class="nome-perfil">Dr(a) <?= $nome ?></span>
                        </a>
                    </li>
                    <button id="btnNotificacao" class="notificacao-btn">
                        <img id="iconeNotificacao" src="Img/Corres_Fechada.png" alt="Notificações" class="Notificacao">
                    </button>
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

    <script src="script.js"></script>
    <script src="scriptTraducao.js"></script>

    <section class="pro-welcome">
        <div class="pro-hero">
            <div class="pro-hero-text">
                <h1>
                    Bem-vindo(a), <span>Dr(a).
                        <?= $nome ?? 'Profissional' ?>
                    </span>
                </h1>

                <p>
                    Seu painel clínico central está pronto.
                    Gerencie consultas, acompanhe pacientes e visualize indicadores de forma rápida e precisa.
                </p>

                <div class="pro-actions">

                    <button class="btn-consulta" id="abrirConsulta">
                        <i class="fa-solid fa-stethoscope"></i>
                        Iniciar Consulta
                    </button>

                    <a href="consultas.php" class="btn-primary">
                        📅 Consultas do dia
                    </a>

                    <a href="dashboard.php" class="btn-secondary">
                        📊 Acessar Dashboard
                    </a>
                </div>

            </div>

            <div class="pro-hero-card">
                <h3>Resumo rápido</h3>
                <div class="mini-stats">
                    <div>
                        <span>Hoje</span>
                        <strong>0 Consultas</strong>
                    </div>

                    <div>
                        <span>Semana</span>
                        <strong>0 Pacientes</strong>
                    </div>

                    <div>
                        <span>Status</span>
                        <strong>Online</strong>
                    </div>
                </div>

            </div>

        </div>

    </section>

    <div class="modal-consulta" id="modalBuscaPaciente">

        <div class="modal-content-consulta">

            <span class="fechar-modal" id="fecharBusca">&times;</span>

            <h2>Iniciar Consulta</h2>

            <p>
                Digite o código único do paciente.
            </p>

            <input type="text" id="codigoPaciente" placeholder="Ex: BSTR-EDC293">

            <button type="button" id="buscarPacienteBtn">
                Buscar Paciente
            </button>
            <div id="resultadoBusca"></div>

        </div>

    </div>

    <div class="modal-prontuario" id="modalProntuario">
        <div class="prontuario-content">
            <div class="topo-prontuario">
                <img id="fotoPaciente" src="Img/defaultUser.png" class="foto-paciente">
                <div>
                    <h2 id="nomePaciente"></h2>
                    <p>
                        Código:
                        <span id="codigoPacienteTexto"></span>
                    </p>

                    <p>
                        Tipo sanguíneo:
                        <span id="tipoSanguineoTexto"></span>
                    </p>
                </div>
            </div>

            <div class="alertas-medicos">
                <div class="alerta-card">
                    <h3>Alergias</h3>
                    <p id="alergiasPaciente"></p>
                </div>

                <div class="alerta-card">
                    <h3>Doenças Crônicas</h3>
                    <p id="doencasPaciente"></p>
                </div>
            </div>

            <div class="acoes-consulta">

                <button class="btn-secundario" id="btnHistorico">
                    Histórico Completo
                </button>

                <button class="btn-secundario" id="btnGraficos">
                    Ver Gráficos
                </button>

                <button class="btn-secundario" id="btnMedicamento">
                    Adicionar medicamento
                </button>

            </div>

            <div id="areaDinamicaConsulta"></div>



            <br><br>
            <textarea id="observacoesConsulta" placeholder="Observações médicas..."></textarea>

            <input type="file" id="receitaConsulta">

            <button class="btn-finalizar">
                Finalizar Consulta
            </button>

        </div>

    </div>


    <script>

        const modalBusca =
            document.getElementById("modalBuscaPaciente");

        const modalProntuario =
            document.getElementById("modalProntuario");

        const btnAbrirConsulta =
            document.getElementById("abrirConsulta");

        const btnFecharBusca =
            document.getElementById("fecharBusca");

        const btnBuscarPaciente =
            document.getElementById("buscarPacienteBtn");



        // ABRIR MODAL BUSCA

        btnAbrirConsulta.addEventListener("click", () => {

            modalBusca.style.display = "flex";

        });

        btnFecharBusca.addEventListener("click", () => {
            modalBusca.style.display = "none";

        });

        btnBuscarPaciente.addEventListener(
            "click",
            buscarPaciente
        );

        async function buscarPaciente() {

            const codigo =
                document.getElementById("codigoPaciente")
                    .value
                    .trim();

            const resultadoBusca =
                document.getElementById("resultadoBusca");



            if (codigo === "") {

                resultadoBusca.innerHTML = `
                <p style="color:red;">
                    Digite o código do paciente.
                </p>
            `;
                return;
            }

            resultadoBusca.innerHTML = `
            <p style="color:#ccc;">
                Buscando paciente...
            </p>
        `;

            try {

                const response = await fetch(
                    "php/profissional/buscarPaciente.php",
                    {
                        method: "POST",

                        headers: {
                            "Content-Type":
                                "application/x-www-form-urlencoded"
                        },

                        body:
                            "codigo=" +
                            encodeURIComponent(codigo)
                    }
                );



                const data = await response.json();

                console.log(data);



                if (data.status) {

                    resultadoBusca.innerHTML = `
                    <p style="color:#4caf50;">
                        Paciente encontrado.
                    </p>
                `;

                    abrirProntuario(data.usuario);

                }

                else {

                    resultadoBusca.innerHTML = `
                    <p style="color:red;">
                        ${data.mensagem}
                    </p>
                `;

                }

            }

            catch (error) {

                console.error(error);

                resultadoBusca.innerHTML = `
                <p style="color:red;">
                    Erro ao buscar paciente.
                </p>
            `;

            }

        }



        // ABRIR PRONTUÁRIO

        function abrirProntuario(usuario) {


            console.log(usuario);
            window.idPacienteAtual = usuario.idUsuario;
            modalProntuario.style.display = "flex";

            // FOTO

            let fotoPaciente = "Img/defaultUser.png";

            if (
                usuario.foto &&
                usuario.foto !== ""
            ) {

                if (
                    usuario.foto.includes("Img/")
                ) {

                    fotoPaciente =
                        usuario.foto;

                }

                else {

                    fotoPaciente =
                        "uploads/" +
                        usuario.foto;

                }

            }


            // PREENCHER DADOS
            document
                .getElementById("fotoPaciente")
                .src = fotoPaciente;

            document
                .getElementById("nomePaciente")
                .innerText =
                usuario.nomeUsuario;

            document
                .getElementById("codigoPacienteTexto")
                .innerText =
                usuario.codigoVinculo;

            document
                .getElementById("tipoSanguineoTexto")
                .innerText =
                usuario.tipoSanguineo ||
                "Não informado";

            document
                .getElementById("alergiasPaciente")
                .innerText =
                usuario.alergias ||
                "Nenhuma";

            document
                .getElementById("doencasPaciente")
                .innerText =
                usuario.doencasCronicas ||
                "Nenhuma";



            // BOTÕES

            document
                .getElementById("btnHistorico")
                .onclick = abrirHistorico;

            document
                .getElementById("btnGraficos")
                .onclick = abrirGraficos;

            document
                .getElementById("btnMedicamento")
                .onclick = abrirMedicamento;

        }

        // HISTÓRICO

        async function abrirHistorico(idUsuario) {

            const area = document.getElementById(
                "areaDinamicaConsulta"
            );

            area.innerHTML = `
        <p style="color:white;">
            Carregando histórico...
        </p>
    `;

            try {

                const response = await fetch(
                    "php/profissional/buscarHistorico.php",
                    {
                        method: "POST",

                        headers: {
                            "Content-Type":
                                "application/x-www-form-urlencoded"
                        },

                        body:
                            "idUsuario=" +
                            encodeURIComponent(idUsuario)
                    }
                );

                const data = await response.json();

                if (!data.status) {

                    area.innerHTML = `
                <p style="color:#ff4d4d;">
                    Nenhum histórico encontrado.
                </p>
            `;

                    return;
                }

                let html = `

        <div class="box-dinamica">

            <h2>
                Histórico Completo
            </h2>

            <table class="tabela-historico">

                <thead>

                    <tr>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Data</th>
                        <th>Observação</th>
                    </tr>

                </thead>

                <tbody>
        `;

                data.historico.forEach(item => {

                    html += `
                <tr>

                    <td>
                        ${item.tipo}
                    </td>

                    <td>
                        ${item.valor}
                    </td>

                    <td>
                        ${item.data}
                    </td>

                    <td>
                        ${item.observacao || '-'}
                    </td>

                </tr>
            `;
                });

                html += `
                </tbody>
            </table>

        </div>
        `;

                area.innerHTML = html;

            } catch (error) {

                console.error(error);

                area.innerHTML = `
            <p style="color:red;">
                Erro ao carregar histórico.
            </p>
        `;
            }


            document
                .getElementById("btnHistorico")
                .onclick = () => abrirHistorico(usuario.idUsuario);
        }



        // GRÁFICOS

        function abrirGraficos() {

            document
                .getElementById("areaDinamicaConsulta")
                .innerHTML = `

            <div class="box-dinamica">

                <h2>
                    Gráficos do Paciente
                </h2>

                <canvas
                    id="graficoPaciente"
                    height="100"
                ></canvas>

            </div>

        `;

        }



        // MEDICAMENTO

        function abrirMedicamento() {

            document
                .getElementById("areaDinamicaConsulta")
                .innerHTML = `

            <div class="box-dinamica">

                <h2>
                    Adicionar Medicamento
                </h2>

                <input
                    type="text"
                    placeholder="Nome do medicamento"
                    class="input-consulta"
                >

                <input
                    type="text"
                    placeholder="Dosagem"
                    class="input-consulta"
                >

                <input
                    type="text"
                    placeholder="Via de administração"
                    class="input-consulta"
                >

                <input
                    type="text"
                    placeholder="Finalidade"
                    class="input-consulta"
                >

                <input
                    type="time"
                    class="input-consulta"
                >

                <input
                    type="text"
                    placeholder="Frequência"
                    class="input-consulta"
                >

                <textarea
                    placeholder="Observações"
                    class="input-consulta"
                ></textarea>

                <button class="btn-finalizar">
                    Salvar Medicamento
                </button>

            </div>

        `;

        }

    </script>

    <br><br>

    <!-- Rodapé -->
    <footer class="footer">
        <div class="footerContainer">
            <!-- Logo e nome -->
            <div class="footerBrand">
                <img src="Img/2.png" alt="Bem Estar 360" class="footerLogo">

            </div>

            <div class="footerLinks">
                <ul>
                    <li><a href="./index.html" data-lang="footerHome">Home</a></li>
                    <li><a href="./monitoramento.html" data-lang="footerMonitoring">Monitoramento</a></li>
                    <li><a href="./servicos.html" data-lang="footerServices">Serviços</a></li>
                    <li><a href="./quemSomos.html" data-lang="about">Quem somos</a></li>
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
            <p data-lang="footerCopy" data-lang="textFooter">&copy; 2025 Bem-Estar 360. Todos os direitos
                reservados.
            </p>
        </div>
    </footer>

</body>

</html>