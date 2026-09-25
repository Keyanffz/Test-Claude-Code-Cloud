<x-admin.layout title="Certificates">
    <x-admin.page-header title="Certificates" description="Listed newest first. The section is hidden on the site while this list is empty.">
        <x-slot:actions>
            <x-admin.button :href="route('admin.certificates.create')" icon="plus">Add certificate</x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    @if ($certificates->isEmpty())
        <x-admin.empty-state title="No certificates yet" :action="route('admin.certificates.create')" action-label="Add certificate" />
    @else
        <x-admin.table>
            <x-slot:head>
                <th class="py-3 pr-4">Certificate</th>
                <th class="py-3 pr-4">Issued</th>
                <th class="py-3 pr-4">Credential</th>
                <th class="py-3 text-right"><span class="sr-only">Actions</span></th>
            </x-slot:head>

            @foreach ($certificates as $certificate)
                <tr>
                    <td>
                        <a href="{{ route('admin.certificates.edit', $certificate) }}" class="font-medium hover:text-signal">{{ $certificate->title }}</a>
                        <p class="text-muted">{{ $certificate->issuer }}</p>
                    </td>
                    <td class="font-mono tabular-nums text-muted">{{ $certificate->issued_at->format('M Y') }}</td>
                    <td>
                        @if ($credential = $certificate->credentialUrl())
                            <a href="{{ $credential }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-muted hover:text-ink">
                                {{ $certificate->file_path ? 'PDF' : 'Link' }} <x-icon name="external-link" :size="14" />
                            </a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex justify-end gap-1">
                            <x-admin.edit-link :href="route('admin.certificates.edit', $certificate)" />
                            <x-admin.delete-button :action="route('admin.certificates.destroy', $certificate)" />
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-admin.table>
    @endif
</x-admin.layout>
