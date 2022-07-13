export const isOverDate = (diff) => {
  if (diff < 0) {
    return 'is-over-date';
  } else if (diff < 7) {
    return 'is-over-date-soon';
  } else {
    return '';
  }
};
