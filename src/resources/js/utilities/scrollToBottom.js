export const scrollToBottom = (idName) => {
  const el = document.getElementById(idName);
  el.scrollTo(0, el.scrollHeight);
};
