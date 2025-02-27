<?php
if (isset($_POST['add'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $data = $_POST['data'];
    $status = $_POST['status'];

    $tarefas = file_exists("tarefas.json") ? json_decode(file_get_contents("tarefas.json"), true) : [];
    $tarefas[] = ['nome' => $nome, 'descricao' => $descricao, 'data' => $data, 'status' => $status];
    file_put_contents("tarefas.json", json_encode($tarefas, JSON_PRETTY_PRINT));

    header("Location: index.php");
    exit();
}

if (isset($_POST['delete'])) {
    $index = $_POST['index'];
    $tarefas = json_decode(file_get_contents("tarefas.json"), true);
    unset($tarefas[$index]);
    file_put_contents("tarefas.json", json_encode(array_values($tarefas), JSON_PRETTY_PRINT));

    header("Location: index.php");
    exit();
}

if (isset($_POST['novo_status'])) {
    $index = $_POST['index'];
    $tarefas = json_decode(file_get_contents("tarefas.json"), true);
    
    if (isset($tarefas[$index])) {
        $tarefas[$index]['status'] = $_POST['novo_status'];
        file_put_contents("tarefas.json", json_encode($tarefas, JSON_PRETTY_PRINT));
    }

    header("Location: index.php");
    exit();
}
?>
