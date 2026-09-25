import { send } from './http';

export default (previewUrl) => ({
    tab: 'write',
    html: '',
    loading: false,

    async showPreview() {
        this.tab = 'preview';
        this.loading = true;

        try {
            ({ html: this.html } = await send(previewUrl, { body: { markdown: this.$refs.source.value } }));
        } catch (error) {
            this.html = `<p>${error.message}</p>`;
        } finally {
            this.loading = false;
        }
    },
});
