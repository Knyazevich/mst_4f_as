import Abstract from './class.Abstract';

class AJAX {
  constructor() {
    if (this.constructor === AJAX) {
      throw new TypeError('Can not construct abstract class.');
    }
  }

  static post(options) {
    jQuery.ajax({
      type: 'POST',
      url: Abstract.getState().ajaxURL,
      data: {
        action: options.action,
        ...options.data,
      },
      beforeSend: options.beforeSend,
      complete: options.complete,
      success: options.success,
    });
  }
}

export default AJAX;
