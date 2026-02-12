export const baseComponent = {
    alert: {
        show: false,
        message: '',
        type: 'success'
    },

    showAlert(message, type = 'success') {
        this.alert = { show: true, message, type };
        if (type === 'success') {
            setTimeout(() => { this.alert.show = false; }, 5000);
        }
    },

    initLucide() {
        if (window.lucide) {
            window.lucide.createIcons();
        }
    }
};

