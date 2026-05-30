<?php
session_start();
include("../config/conexao.php");

/*VERIFICA LOGIN */
if (!isset($_SESSION['idUsuario'])) {
    die("Usuário não autenticado.");
}

$id = $_SESSION['idUsuario'];

/* DADOS RECEBIDOS*/
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$cpf = trim($_POST['cpf'] ?? '');
$endereco = trim($_POST['endereco'] ?? '');

$crm = trim($_POST['crm'] ?? '');
$especialidade = trim($_POST['especialidade'] ?? '');
$hospital = trim($_POST['hospital'] ?? '');
$biografia = trim($_POST['biografia'] ?? '');

$novaSenha = trim($_POST['novaSenha'] ?? '');
$confirmarSenha = trim($_POST['confirmarSenha'] ?? '');

/* VALIDAÇÃO SENHA */
if (!empty($novaSenha) || !empty($confirmarSenha)) {

    if (empty($novaSenha) || empty($confirmarSenha)) {
        header("Location: ../../perfilProfissional.php?erro=preenchaAmbasSenhas");
        exit;
    }

    if ($novaSenha !== $confirmarSenha) {
        header("Location: ../../perfilProfissional.php?erro=senhasDiferentes");
        exit;
    }
}

/* UPDATE PERFIL */
$conn->begin_transaction();

try {

    $stmt = $conn->prepare("
        UPDATE tblUsuario
        SET
            nomeUsuario = ?,
            emailUsuario = ?,
            telefoneUsuario = ?,
            cpfUsuario = ?,
            enderecoUsuario = ?,
            crmMedico = ?,
            especialidadeMedico = ?,
            hospitalMedico = ?,
            biografiaMedico = ?
        WHERE idUsuario = ?
    ");

    $stmt->bind_param(
        "sssssssssi",
        $nome,
        $email,
        $telefone,
        $cpf,
        $endereco,
        $crm,
        $especialidade,
        $hospital,
        $biografia,
        $id
    );

    $stmt->execute();

    /* ALTERAR SENHA */
    if (!empty($novaSenha)) {

        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        $stmtSenha = $conn->prepare("
            UPDATE tblLogin
            SET senha = ?
            WHERE Usuario_idUsuario = ?
        ");

        $stmtSenha->bind_param("si", $senhaHash, $id);
        $stmtSenha->execute();
    }

    $conn->commit();

    header("Location: ../../perfilProfissional.php?sucesso=1");
    exit;

} catch (Exception $e) {

    $conn->rollback();

    die("Erro: " . $e->getMessage());
}
?>