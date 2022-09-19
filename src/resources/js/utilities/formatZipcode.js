// 0000111形式の郵便番号を0000-111に変換する
export const formatZipcode = (zipcode) => {
  if (!zipcode) return '';
  return `${zipcode.slice(0, 3)}-${zipcode.slice(3)}`;
};
