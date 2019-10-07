<?php
require_once "classes/MainViewModel.php";

$viewModel = new MainViewModel(
    $_GET["db_name"] ?? NULL,
    $_GET["table_name"] ?? NULL,
    $_GET["row_offset"] ?? NULL
);

if ($viewModel->shouldRedirectToConnect()) {
    header("Location: connect.html");
    exit();
}

function getDbListItemClassName($dbName) {
  global $viewModel;

  $selectedClassName = $viewModel->matchesSelectedDatabase($dbName)
      ? "details-card__content__list-item--selected"
      : "";

  return "details-card__content__list-item " . $selectedClassName;
}

function getTableListItemClassName($tableName) {
  global $viewModel;

  $selectedClassName = $viewModel->matchesSelectedTable($tableName)
      ? "details-card__content__list-item--selected"
      : "";

  return "details-card__content__list-item " . $selectedClassName;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/scrollbar.css">
    <link rel="stylesheet" href="css/buttons.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/cards.css">
    <link rel="stylesheet" href="css/home.css">

    <title>
      <?= $viewModel->pageTitle() ?>
    </title>
  </head>
  <body>
    <header class="brand-header page__header">
      <div class="brand-header__logo">:-)db</div>
      <div>
        <span class="home-header__connected-to">
          Conectado à
          <span class="home-header__host-name">
            <?= $viewModel->hostName() ?>
          </span>
        </span>
        <a class="home-header__disconnect button" href="disconnect.php">Desconectar</a>
      </div>
    </header>

    <main class="page__content">
      <div class="home__cards-container">

        <div class="card card--elevation-2 home__left-card details-card">
          <section class="details-card__databases">
            <h2 class="details-card__databases__title">
              <img src="assets/icon__databases@3x.png" class="card-title-icon" alt="">
              Bancos de Dados
            </h2>
            <div class="details-card__content">
              <ul class="details-card__content__list">
                <?php foreach ($viewModel->dbNames() as $databaseName): ?>
                  <li>
                    <a class="<?= getDbListItemClassName($databaseName) ?>"
                       href="<?= $viewModel->selectDatabaseUrl($databaseName) ?>">
                      <?= $databaseName ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </section>
          <section class="details-card__tables">
            <h2 class="details-card__tables__title">
              <img src="assets/icon__tables@3x.png" class="card-title-icon" alt="">
              Tabelas
            </h2>
            <div class="details-card__content">
              <?php if (!$viewModel->hasSelectedDb()): ?>
                <p class="no-content-msg">
                  Selecione um banco de dados para ver suas tabelas
                </p>
              <?php else: ?>
                <ul class="details-card__content__list">
                  <?php foreach ($viewModel->tableNames() as $tableName): ?>
                    <li>
                      <a class="<?= getTableListItemClassName($tableName) ?>"
                         href="<?= $viewModel->selectTableUrl($tableName) ?>">
                        <?= $tableName ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
          </section>
        </div>

        <div class="card card--elevation-4 home__right-card table-contents-card">
          <h2 class="table-contents-card__title">
            <img src="assets/icon__content@3x.png" class="card-title-icon" alt="">
            Conteúdo
          </h2>
          <?php if (!$viewModel->hasSelectedTable()): ?>
            <p class="no-content-msg table-contents-card__no-content-msg">
              Selecione uma tabela para ver seu conteúdo
            </p>
          <?php else: ?>
            <div class="table-contents-card__container">
              <table class="table-contents-card__table">
                <tr class="table-contents-card__table__header">
                  <?php foreach ($viewModel->tableSchema() as $column): ?>
                    <th><?= $column ?></th>
                  <?php endforeach; ?>
                </tr>
                <?php foreach ($viewModel->tableState() as $row): ?>
                  <tr class="table-contents-card__table__row">
                    <?php foreach ($row as $columnState): ?>
                      <td> <?= $columnState ?></td>
                    <?php endforeach; ?>
                  </tr>
                <?php endforeach; ?>
              </table>

              <!--
                Because an inset border/shadow won't work in the table (the cells' backgrounds would cover it),
                and an outset border/shadow won't work either because it would be cropped by the table container,
                we need to have another element, overlaid on top of the table, that has the inset border/shadow.
              -->
              <div class="table-contents-card__container__border-overlay"></div>
            </div>
          <?php endif; ?>
          <div class="table-contents-card__bottom-nav">
            <?php if ($viewModel->shouldShowPreviousButton()): ?>
              <a class="button table-contents-card__bottom-nav__prev"
                 href="<?= $viewModel->previousPageUrl() ?>"
              >
                <img src="assets/caret--prev@3x.png" class="table-contents-card__bottom-nav__prev__icon" alt="">
                <span>Anterior</span>
              </a>
            <?php endif; ?>
            <?php if ($viewModel->shouldShowNextButton()): ?>
              <a class="button table-contents-card__bottom-nav__next"
                 href="<?= $viewModel->nextPageUrl() ?>"
              >
                <span>Próximo</span>
                <img src="assets/caret--next@3x.png" class="table-contents-card__bottom-nav__next__icon" alt="">
              </a>
            <?php endif; ?>
          </div>
        </div>

      </div>

    </main>

    <script src="javascript/index.js"></script>
  </body>
</html>