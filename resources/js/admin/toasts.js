const DISPLAY_MS = 4000;

export default (initial) => ({
    items: [],
    nextId: 0,

    init() {
        if (initial) {
            this.push(initial);
        }
    },

    push(detail) {
        const toast = typeof detail === 'string' ? { message: detail } : detail;
        const id = this.nextId++;
        this.items.push({ id, type: 'success', ...toast, visible: true });
        setTimeout(() => this.dismiss(id), DISPLAY_MS);
    },

    dismiss(id) {
        const toast = this.items.find((item) => item.id === id);
        if (!toast) return;
        toast.visible = false;
        setTimeout(() => (this.items = this.items.filter((item) => item.id !== id)), 250);
    },
});
