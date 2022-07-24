export const formatBirth = (birth) => {
  if (!birth) return null;
  const [year, month, day] = birth.split('-');
  return `${year}年${month}月${day}日`;
};
