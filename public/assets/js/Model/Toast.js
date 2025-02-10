export default class Toast {
    constructor() {
        this.toastEl = document.getElementById('notification-toast');
        this.toastMessage = document.getElementById('toast-message');
        this.toastInstance = null;
    }

    showToast(message, autohide = false) {
        this.toastMessage.textContent = message;
        if (this.toastInstance) {
            this.toastInstance.dispose();
        }
        this.toastInstance = new bootstrap.Toast(this.toastEl, { autohide: autohide });
        this.toastInstance.show();
    }

    updateToast(message, delay = 5000) {
        this.toastMessage.textContent = message;
        if (this.toastInstance) {
            this.toastInstance.dispose();
        }
        this.toastInstance = new bootstrap.Toast(this.toastEl, { autohide: true, delay: delay });
        this.toastInstance.show();
    }

    notify(message) {
        this.updateToast(message);
    }
}
