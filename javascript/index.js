const header = document.getElementsByClassName("page__header")[0];
if (header) {
  const headerHeight = header.offsetHeight;
  const { style: documentStyle } = document.documentElement;

  documentStyle.setProperty('--page-header-height', `${headerHeight}px`);
}