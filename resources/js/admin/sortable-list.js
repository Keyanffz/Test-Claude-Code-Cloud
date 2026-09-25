import Sortable from 'sortablejs';
import { send, toast } from './http';

export default (url) => ({
    init() {
        Sortable.create(this.$el, {
            handle: '[data-drag-handle]',
            animation: 180,
            easing: 'cubic-bezier(0.215, 0.61, 0.355, 1)',
            ghostClass: 'opacity-40',
            onEnd: ({ oldIndex, newIndex }) => oldIndex !== newIndex && this.save(),
        });
    },

    async save() {
        const ids = [...this.$el.querySelectorAll('[data-id]')].map((row) => Number(row.dataset.id));

        try {
            const { message } = await send(url, { method: 'PATCH', body: { ids } });
            toast(message);
        } catch (error) {
            toast(`${error.message} Reload to see the saved order.`, 'error');
        }
    },
});
