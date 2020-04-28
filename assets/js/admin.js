import AJAX from './classes/class.AJAX';

class Admin {
  constructor() {
    this.preloadScreenshotsButton = document.querySelector('.preload-screenshots');
    this.forceScreenshotsButton = document.querySelector('.force-screenshots');
    this.forceComparisonButton = document.querySelector('.force-comparison');

    this.run();
  }

  run() {
    this._initEventListeners();
  }

  _initEventListeners() {
    if (this.preloadScreenshotsButton) {
      this.preloadScreenshotsButton.addEventListener('click', () => this._initPreloadScreenshotsButton());
    }

    if (this.forceScreenshotsButton) {
      this.forceScreenshotsButton.addEventListener('click', () => this._initForceScreenshotsButton());
    }

    if (this.forceComparisonButton) {
      this.forceComparisonButton.addEventListener('click', () => this._initForceComparisonButton());
    }
  }

  _initPreloadScreenshotsButton() {
    const _this = this;

    AJAX.post({
      action: 'mst_4f_preload_screenshots',
      beforeSend() {
        _this.preloadScreenshotsButton.disabled = true;
      },
      complete() {
        _this.preloadScreenshotsButton.disabled = false;
      },
      success() {
        alert('Completed successfully');
      },
    });
  }

  _initForceScreenshotsButton() {
    const _this = this;

    AJAX.post({
      action: 'mst_4f_force_screenshots',
      beforeSend() {
        _this.forceScreenshotsButton.disabled = true;
      },
      complete() {
        _this.forceScreenshotsButton.disabled = false;
      },
      success() {
        alert('Completed successfully');
      },
    });
  }

  _initForceComparisonButton() {
    const _this = this;

    AJAX.post({
      action: 'mst_4f_force_comparison',
      beforeSend() {
        _this.forceComparisonButton.disabled = true;
      },
      complete() {
        _this.forceComparisonButton.disabled = false;
      },
      success() {
        alert('Completed successfully');
      },
    });
  }
}

document.addEventListener('DOMContentLoaded', () => new Admin());
