<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo Em Dia</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>

<body>
    <div class="container">
        <img src="./img/logo.png" alt="Logo ToDo Em Dia" style="width: 230px;">

        <!-- Botão de adicionar tarefa (pequeno e acima das colunas) -->
        <div class="add-task-container">
            <button id="btn-add" class="btn add-task-btn">
                <i class="bi bi-plus"></i>
                Nova Tarefa
            </button>
        </div>

        <!-- Modal de Adicionar Tarefa -->
        <div id="modal" class="modal">
            <div class="modal-content">
                <div style="display: flex; justify-content: space-between">
                    <h2>Nova Tarefa</h2>
                    <button id="close-modal" class="close" aria-label="Fechar">
                        <i class="bi bi-x"></i>
                    </button>
                </div>

                <form action="actions.php" method="POST" class="form-modal">
                    <input type="text" name="nome" placeholder="Nome do Afazer" required>
                    <textarea name="descricao" placeholder="Descrição" required></textarea>
                    <input type="date" name="data" required>
                    <select name="status">
                        <option value="Pendente">Pendente</option>
                        <option value="Em Andamento">Em Andamento</option>
                        <option value="Concluído">Concluído</option>
                    </select>
                    <button type="submit" name="add" class="btn">Salvar</button>
                </form>
            </div>
        </div>

        <!-- Tarefas divididas em 3 colunas -->
        <div class="kanban-board">
            <div class="column">
                <h2>Pendente</h2>
                <div class="task-list">
                    <?php renderTasks("Pendente"); ?>
                </div>
            </div>
            <div class="column">
                <h2>Em Andamento</h2>
                <div class="task-list">
                    <?php renderTasks("Em Andamento"); ?>
                </div>
            </div>
            <div class="column">
                <h2>Concluído</h2>
                <div class="task-list">
                    <?php renderTasks("Concluído"); ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    function renderTasks($status)
    {
        $tarefas = file_exists("tarefas.json") ? json_decode(file_get_contents("tarefas.json"), true) : [];

        foreach ($tarefas as $index => $tarefa) {
            if ($tarefa['status'] == $status) {
                echo "<div class='tarefa-card'>
                    <div class='task-header'>
                        <h3>{$tarefa['nome']}</h3>
                        <form action='actions.php' method='POST' class='delete-form'>
                            <input type='hidden' name='index' value='{$index}'>
                            <button type='submit' name='delete' class='delete'>
                                <i class='bi bi-trash'></i>
                            </button>
                        </form>
                    </div>
                    <p>{$tarefa['descricao']}</p>
                    <span class='data'>" . date('d/m/Y', strtotime($tarefa['data'])) . "</span>
                    <form action='actions.php' method='POST'>
                        <input type='hidden' name='index' value='{$index}'>
                        <select name='novo_status' onchange='this.form.submit()'>
                            <option value='Pendente' " . ($tarefa['status'] == "Pendente" ? "selected" : "") . ">Pendente</option>
                            <option value='Em Andamento' " . ($tarefa['status'] == "Em Andamento" ? "selected" : "") . ">Em Andamento</option>
                            <option value='Concluído' " . ($tarefa['status'] == "Concluído" ? "selected" : "") . ">Concluído</option>
                        </select>
                    </form>
                </div>";
            }
        }
    }
    ?>

    <!-- Script para controlar o modal -->
    <script>
        document.getElementById("btn-add").addEventListener("click", function() {
            document.getElementById("modal").style.display = "block";
        });

        document.getElementById("close-modal").addEventListener("click", function() {
            document.getElementById("modal").style.display = "none";
        });

        window.onclick = function(event) {
            if (event.target == document.getElementById("modal")) {
                document.getElementById("modal").style.display = "none";
            }
        };
    </script>
</body>

</html>
