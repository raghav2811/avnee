<x-admin-layout>
    <div class="px-6 py-8 sm:px-10">
        <div class="max-w-[1400px] mx-auto">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 text-center md:text-left">
                <div class="space-y-1">
                    <h1 class="text-3xl font-heading font-normal tracking-tight bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">
                        Concierge Inbox
                    </h1>
                    <p class="text-sm text-gray-400 leading-relaxed max-w-lg mx-auto md:ml-0">Review and respond to luxury lifestyle enquiries from your clients.</p>
                </div>
            </div>

            <div class="bg-[#1c181d] border border-white/5 rounded-2xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/5 bg-white/5">
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Sender</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Subject</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Status</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Sent Date</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 text-right">Manifest</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($messages as $msg)
                            <tr class="group hover:bg-white/[0.02] transition-colors {{ $msg->status === 'unread' ? 'border-l-2 border-l-[#b87333]' : '' }}">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-white tracking-wide uppercase">{{ $msg->name }}</span>
                                        <span class="text-[11px] text-gray-500 tracking-wider lowercase italic">{{ $msg->email }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-xs text-gray-300 tracking-wide">{{ $msg->subject ?? 'General Enquiry' }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $msg->status === 'unread' ? 'bg-[#b87333]/20 text-[#b87333]' : 'bg-green-500/20 text-green-500' }}">
                                        {{ $msg->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-xs text-gray-500 tracking-widest uppercase">
                                    {{ $msg->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex justify-end gap-4">
                                        <a href="{{ route('admin.contact-messages.show', $msg) }}" class="p-2 text-gray-500 hover:text-white transition-colors" title="View Message">
                                            <span class="material-symbols-outlined text-lg">visibility</span>
                                        </a>
                                        <form action="{{ route('admin.contact-messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('Archive this enquiry?');" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-500 hover:text-red-500 transition-colors">
                                                <span class="material-symbols-outlined text-lg">archive</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($messages->isEmpty())
                <div class="p-20 text-center">
                    <span class="material-symbols-outlined text-gray-800 text-6xl mb-4">mail_outline</span>
                    <p class="text-gray-600 uppercase tracking-widest text-[10px] font-black">All silent in the luxury studio</p>
                </div>
                @endif

                @if($messages->hasPages())
                <div class="p-6 border-t border-white/5">
                    {{ $messages->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
