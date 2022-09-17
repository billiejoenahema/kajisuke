// Y-m-d 形式の日付をY年m月d日に変換する
export const formatDate = (date) => {
  if (!date) return null;
  const [year, month, day] = date.split('-');
  return `${year}年${month}月${day}日`;
};
