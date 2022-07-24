export const formatZipcode = (zipcode) => {
  if (zipcode) {
    return `${zipcode.slice(0, 3)}-${zipcode.slice(3)}`;
  }
  return '';
};
