import { MAX_LENGTH } from '../consts/maxLength';

export const determineIsOver = (prop, length) => {
  const warningRate = 0.9;
  if (MAX_LENGTH[prop] * warningRate < length && length <= MAX_LENGTH[prop]) {
    return 'warn';
  } else if (MAX_LENGTH[prop] < length) {
    return 'error';
  } else {
    return '';
  }
};
