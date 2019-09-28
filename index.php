<?php
require_once "MainViewModel.php";

$viewModel = new MainViewModel(
    $_GET["db_name"] ?? NULL,
    $_GET["table_name"] ?? NULL,
    $_GET["row_offset"] ?? NULL
);

if ($viewModel->shouldRedirectToConnect()) {
    header("Location: connect.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
      <?= $viewModel->pageTitle() ?>
    </title>
  </head>
  <body>
    <header>
      <div>:-)db</div>
      <div>
        <p>Conectado à <span><?= $viewModel->hostName() ?></span></p>
        <a href="disconnect.php">Desconectar</a>
      </div>
    </header>
    <section>
      <h2>Bancos de Dados</h2>
      <div>
        <ul>
          <?php foreach ($viewModel->dbNames() as $databaseName): ?>
            <li>
              <a href="<?= $viewModel->selectDatabaseUrl($databaseName) ?>">
                <?= $databaseName ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>
    <section>
      <h2>Tabelas</h2>
      <div>
        <?php if (!$viewModel->hasSelectedDb()): ?>
          <p>Selecione um banco de dados para ver suas tabelas</p>
        <?php else: ?>
          <ul>
            <?php foreach ($viewModel->tableNames() as $tableName): ?>
              <li>
                <a href="<?= $viewModel->selectTableUrl($tableName) ?>">
                  <?= $tableName ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </section>
    <section>
      <h2>Conteúdo</h2>
      <div>
        <?php if (!$viewModel->hasSelectedTable()): ?>
          <p>Selecione uma tabela para ver seu conteúdo</p>
        <?php else: ?>
          <table>
            <tr>
              <?php foreach ($viewModel->tableSchema() as $column): ?>
                <th><?= $column ?></th>
              <?php endforeach; ?>
            </tr>
            <?php foreach ($viewModel->tableState() as $row): ?>
              <tr>
                <?php foreach ($row as $columnState): ?>
                  <td> <?= $columnState ?></td>
                <?php endforeach; ?>
              </tr>
            <?php endforeach; ?>
          </table>
        <?php endif; ?>
      </div>
      <div>
        <?php if ($viewModel->shouldShowPreviousButton()): ?>
          <a href="<?= $viewModel->previousPageUrl() ?>">Anterior</a>
        <?php endif; ?>
        <?php if ($viewModel->shouldShowNextButton()): ?>
          <a href="<?= $viewModel->nextPageUrl() ?>">Próximo</a>
        <?php endif; ?>
      </div>
    </section>
  </body>
</html>