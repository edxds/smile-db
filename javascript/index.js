const header = document.getElementsByClassName("page__header")[0];
if (header) {
  const headerHeight = header.offsetHeight;
  const { style: documentStyle } = document.documentElement;

  documentStyle.setProperty('--page-header-height', `${headerHeight}px`);
}

function updateTableContainerHeightVariable() {
  const tableContainer = document.getElementsByClassName('table-contents-card__container')[0];
  const tableContainerHeight = tableContainer.offsetHeight;
  const tableItemHeight = Math.max(tableContainerHeight / 11, 32);

  const { style: documentStyle } = document.documentElement;
  documentStyle.setProperty('--table-height', `${tableContainerHeight}px`);
  documentStyle.setProperty('--table-item-height', `${tableItemHeight}px`);

  updateCurrentTableDimensionsVariable();
}

function updateCurrentTableDimensionsVariable() {
  const table = document.getElementsByClassName('table-contents-card__table')[0];
  const tableHeight = table.offsetHeight;
  const tableWidth = table.offsetWidth;

  const { style: documentStyle } = document.documentElement;
  documentStyle.setProperty('--current-table-height', `${tableHeight}px`);
  documentStyle.setProperty('--current-table-width', `${tableWidth}px`);
}

window.addEventListener('resize', updateTableContainerHeightVariable);
updateTableContainerHeightVariable();
