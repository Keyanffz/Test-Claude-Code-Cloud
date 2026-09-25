const ACCEPTED_TYPES = ['image/jpeg', 'image/png', 'image/webp'];

export default (current, maxKb) => ({
    src: current,
    fileName: '',
    error: '',

    preview(event) {
        const file = event.target.files[0];
        this.error = '';

        if (!file) {
            this.src = current;
            this.fileName = '';
            return;
        }

        // Mirrors the server rules so obvious mistakes are caught before a slow upload.
        if (!ACCEPTED_TYPES.includes(file.type)) {
            this.reject(event, 'Use a JPG, PNG or WebP image.');
            return;
        }
        if (file.size > maxKb * 1024) {
            this.reject(event, `This image is ${(file.size / 1048576).toFixed(1)} MB; the limit is ${maxKb / 1024} MB.`);
            return;
        }

        this.fileName = file.name;
        this.src = URL.createObjectURL(file);
    },

    reject(event, message) {
        event.target.value = '';
        this.error = message;
        this.src = current;
        this.fileName = '';
    },
});
