<x-admin-layout>
    <div class="px-6 py-8 sm:px-10">
        <div class="max-w-[1000px] mx-auto">
            <div class="mb-12 flex items-center justify-between border-b border-white/5 pb-8">
                <div>
                    <a href="{{ route('admin.contact-messages.index') }}" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 hover:text-white flex items-center gap-2 mb-4 transition-colors">
                        <span class="material-symbols-outlined text-sm">arrow_back</span> Return to Inbox
                    </a>
                    <h1 class="text-3xl font-heading font-normal tracking-tight text-white uppercase italic">
                        {{ $contactMessage->subject ?? 'Enquiry Manifest' }}
                    </h1>
                </div>
                <div class="flex items-center gap-4">
                     <span class="px-5 py-2 rounded-full text-[9px] font-black uppercase tracking-widest bg-[#b87333]/10 text-[#b87333] border border-[#b87333]/20">
                        Status: {{ $contactMessage->status }}
                    </span>
                    <form action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" method="POST" onsubmit="return confirm('Archive this enquiry?');" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-6 py-3 bg-red-500/10 text-red-500 text-[9px] font-black uppercase tracking-widest rounded-full border border-red-500/20 hover:bg-red-500 hover:text-white transition-all">
                            Archive Manifest
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Client Details -->
                <div class="space-y-8">
                    <div class="bg-white/5 backdrop-blur-md p-8 rounded-2xl border border-white/5">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.4em] text-gray-500 mb-8 border-b border-white/5 pb-4">Client Dossier</h3>
                        <div class="space-y-6">
                            <div class="space-y-1">
                                <span class="text-[9px] font-black uppercase tracking-widest text-[#b87333]">Representative</span>
                                <p class="text-base text-white font-bold tracking-wide uppercase">{{ $contactMessage->name }}</p>
                            </div>
                            <div class="space-y-1">
                                <span class="text-[9px] font-black uppercase tracking-widest text-[#b87333]">Communication Channel</span>
                                <p class="text-sm text-gray-300 tracking-wider">{{ $contactMessage->email }}</p>
                                @if($contactMessage->phone)
                                    <p class="text-sm text-gray-300 tracking-wider italic">{{ $contactMessage->phone }}</p>
                                @endif
                            </div>
                            <div class="space-y-1 pt-4">
                                <span class="text-[9px] font-black uppercase tracking-widest text-gray-500">Dispatch Synchronized</span>
                                <p class="text-xs text-gray-500 uppercase tracking-widest">{{ $contactMessage->created_at->format('d M Y | H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message Content -->
                <div class="lg:col-span-2">
                    <div class="bg-white/5 backdrop-blur-md p-10 rounded-2xl border border-white/5 shadow-2xl relative overflow-hidden min-h-[400px]">
                        <div class="absolute top-0 right-0 p-8 opacity-5">
                            <span class="material-symbols-outlined text-8xl">format_quote</span>
                        </div>
                        
                        <h3 class="text-[10px] font-black uppercase tracking-[0.4em] text-gray-500 mb-10 border-b border-white/5 pb-4">Communication Body</h3>
                        <div class="prose prose-invert max-w-none">
                            <p class="text-lg text-gray-200 leading-relaxed italic tracking-wide">
                                "{{ $contactMessage->message }}"
                            </p>
                        </div>

                        <div class="mt-16 pt-10 border-t border-white/5 flex gap-6">
                            <a href="mailto:{{ $contactMessage->email }}?subject=Re: {{ $contactMessage->subject }}" class="px-8 py-4 bg-white text-black text-[10px] font-black uppercase tracking-[0.4em] hover:bg-[#b87333] hover:text-white transition-all active:scale-95 shadow-2xl">
                                Construct Response
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
