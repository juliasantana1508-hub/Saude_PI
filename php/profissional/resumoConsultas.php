<?php
session_start();
header('Content-Type: application/json');
include("../config/conexao.php");

$id = $_SESSION['idUsuario'] ?? 0;

/* CONSULTAS HOJE */
$stmtHoje = $conn->prepare("
    SELECT COUNT(*) AS total
    FROM tblConsulta
    WHERE Profissional_idUsuario = ?
    AND DATE(dataConsulta) = CURDATE()
");
$stmtHoje->bind_param("i", $id);
$stmtHoje->execute();
$hoje = $stmtHoje->get_result()->fetch_assoc()['total'] ?? 0;

/* CONSULTAS SEMANA */
$stmtSemana = $conn->prepare("
    SELECT COUNT(*) AS total
    FROM tblConsulta
    WHERE Profissional_idUsuario = ?
    AND YEARWEEK(dataConsulta, 1) = YEARWEEK(CURDATE(), 1)
");
$stmtSemana->bind_param("i", $id);
$stmtSemana->execute();
$semana = $stmtSemana->get_result()->fetch_assoc()['total'] ?? 0;

/* PACIENTES ÚNICOS HOJE */
$stmtPacHoje = $conn->prepare("
    SELECT COUNT(DISTINCT Paciente_idUsuario) AS total
    FROM tblConsulta
    WHERE Profissional_idUsuario = ?
    AND DATE(dataConsulta) = CURDATE()
");
$stmtPacHoje->bind_param("i", $id);
$stmtPacHoje->execute();
$pacientesHoje = $stmtPacHoje->get_result()->fetch_assoc()['total'] ?? 0;

/* PACIENTES ÚNICOS SEMANA */
$stmtPacSemana = $conn->prepare("
    SELECT COUNT(DISTINCT Paciente_idUsuario) AS total
    FROM tblConsulta
    WHERE Profissional_idUsuario = ?
    AND YEARWEEK(dataConsulta, 1) = YEARWEEK(CURDATE(), 1)
");
$stmtPacSemana->bind_param("i", $id);
$stmtPacSemana->execute();
$pacientesSemana = $stmtPacSemana->get_result()->fetch_assoc()['total'] ?? 0;

echo json_encode([
    "status" => true,
    "hoje" => $hoje,
    "semana" => $semana,
    "pacientesHoje" => $pacientesHoje,
    "pacientesSemana" => $pacientesSemana
]);