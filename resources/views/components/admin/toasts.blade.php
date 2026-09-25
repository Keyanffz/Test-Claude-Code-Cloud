<div
    x-data="toasts(@js(session('toast')))"
    @toast.window="push($event.detail)"
    class="pointer-events-none fixed right-4 bottom-4 z-50 flex w-[min(360px,calc(100vw-2rem))] flex-col gap-2"
    role="status"
    aria-live="polite"
>
    <template x-for="toast in items" :key="toast.id">
        <div
            x-show="toast.visible"
            x-transition:enter="transition duration-300 ease-(--ease-out-expo)"
            x-transition:enter-start="translate-y-2 opacity-0"
            x-transition:leave="transition duration-200"
            x-transition:leave-end="opacity-0"
            class="pointer-events-auto flex items-start gap-3 border border-line bg-ink px-4 py-3 text-paper"
        >
            <span class="mt-1.5 size-1.5 shrink-0 rounded-full" :class="toast.type === 'error' ? 'bg-signal' : 'bg-paper'"></span>
            <p class="flex-1" x-text="toast.message"></p>
            <button type="button" class="opacity-60 hover:opacity-100" @click="dismiss(toast.id)">
                <span class="sr-only">Dismiss</span>
                <x-icon name="x" />
            </button>
        </div>
    </template>
</div>
