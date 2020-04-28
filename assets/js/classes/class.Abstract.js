/* global mst_4f_as_state */

class Abstract {
  constructor() {
    if (this.constructor === Abstract) {
      throw new TypeError('Can not construct abstract class.');
    }
  }

  static isFunction(f) {
    return typeof f === 'function';
  }

  static getState() {
    return mst_4f_as_state; // eslint-disable-line camelcase
  }

  static getI18n() {
    return mst_4f_as_state.i18n; // eslint-disable-line camelcase
  }
}

export default Abstract;
