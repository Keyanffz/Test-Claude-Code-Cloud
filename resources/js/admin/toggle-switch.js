import { send, toast } from './http';

export default (url, field, initial) => ({
    on: initial,
    busy: false,

    async flip() {
        this.on = !this.on;
        this.busy = true;

        try {
            const { message } = await send(url, { method: 'PATCH', body: { field, value: this.on } });
            toast(message);
        } catch (error) {
            this.on = !this.on;
            toast(error.message, 'error');
        } finally {
            this.busy = false;
        }
    },
});
