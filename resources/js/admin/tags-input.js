export default (initial) => ({
    tags: initial,
    entry: '',

    add() {
        const value = this.entry.trim().replace(/,$/, '');
        const exists = this.tags.some((tag) => tag.toLowerCase() === value.toLowerCase());

        if (value && !exists) {
            this.tags.push(value);
        }
        this.entry = '';
    },

    remove(index) {
        this.tags.splice(index, 1);
    },
});
