<?php

session_start();

header('Content-Type: application/json');

include("../config/conexao.php");

$idProfissional =
    $_SESSION['idUsuario'] ?? 0;

$idPaciente =
    $_POST['idPaciente'] ?? 0;

$observacoes =
    $_POST['observacoes'] ?? '';

$receitaNome = null;

/* =========================
UPLOAD RECEITA
========================= */

if (
    isset($_FILES['receita']) &&
    $_FILES['receita']['error'] === 0
) {

    $pasta = "../../uploads/receitas/";

    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $nomeArquivo =
        time() .
        "_" .
        basename($_FILES['receita']['name']);

    $caminho =
        $pasta . $nomeArquivo;

    if (
        move_uploaded_file(
            $_FILES['receita']['tmp_name'],
            $caminho
        )
    ) {

        $receitaNome = $nomeArquivo;

    }

}

/* =========================
SALVAR CONSULTA
========================= */

$sql = "

INSERT INTO tblConsulta (

    Profissional_idUsuario,
    Paciente_idUsuario,
    observacoes,
    receita

)

VALUES (?, ?, ?, ?)

";

$stmt = $conn->prepare($sql);

$stmt->bind_param(

    "iiss",

    $idProfissional,
    $idPaciente,
    $observacoes,
    $receitaNome

);

if ($stmt->execute()) {

    echo json_encode([
        "status" => true
    ]);

} else {

    echo json_encode([
        "status" => false,
        "mensagem" => "Erro ao salvar consulta."
    ]);

}


$conn->query("
UPDATE tblUsuario
SET consultasHoje = consultasHoje + 1,
    consultasSemana = consultasSemana + 1
WHERE idUsuario = $idProfissional
");