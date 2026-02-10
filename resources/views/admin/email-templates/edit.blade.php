@extends('layouts.admin')

@section('header', 'Edit Email Template')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.email-templates.index') }}"
            class="text-slate-500 hover:text-primary transition-all flex items-center gap-2 text-sm font-bold">
            <i class='bx bx-arrow-back'></i> Back to Templates
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-2xl border border-slate-100 overflow-hidden">
        <div class="p-8">
            <h3 class="text-xl font-black text-slate-800 mb-6">Modify Template: {{ $emailTemplate->name }}</h3>

            <form action="{{ route('admin.email-templates.update', $emailTemplate) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Template Name</label>
                        <input type="text" name="name" value="{{ old('name', $emailTemplate->name) }}" required
                            class="w-full bg-slate-50 border border-slate-100 rounded-xl p-4 text-sm focus:ring-2 focus:ring-purple-500/20 outline-none transition-all"
                            placeholder="e.g. New Matching Property Alert">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Template Type</label>
                        <select name="type" required
                            class="w-full bg-slate-50 border border-slate-100 rounded-xl p-4 text-sm focus:ring-2 focus:ring-purple-500/20 outline-none transition-all">
                            <option value="matched_property" {{ $emailTemplate->type == 'matched_property' ? 'selected' : '' }}>Matched Property Notification</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Email Subject
                        Line</label>
                    <input type="text" name="subject" value="{{ old('subject', $emailTemplate->subject) }}" required
                        class="w-full bg-slate-50 border border-slate-100 rounded-xl p-4 text-sm focus:ring-2 focus:ring-purple-500/20 outline-none transition-all"
                        placeholder="e.g. {property_title} matches your interest!">
                    <p class="text-[10px] text-slate-400 mt-1">Available placeholders: {property_title}</p>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Email Body (HTML
                        Content)</label>
                    <textarea name="body" id="editor" class="hidden">{{ old('body', $emailTemplate->body) }}</textarea>
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-xl mt-4">
                        <p class="text-xs text-blue-700 font-bold mb-2">Use these placeholders to personalize the email:</p>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-[10px] font-mono text-blue-600">
                            <div>{user_name}</div>
                            <div>{property_title}</div>
                            <div>{price}</div>
                            <div>{bedrooms}</div>
                            <div>{bathrooms}</div>
                            <div>{address}</div>
                            <div>{property_url}</div>
                            <div>{thumbnail_url}</div>
                            <div>{area_size}</div>
                            <div>{year}</div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 py-4">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $emailTemplate->is_active) ? 'checked' : '' }}
                        class="w-5 h-5 text-purple-600 rounded border-slate-200 focus:ring-purple-500">
                    <label for="is_active" class="text-sm font-bold text-slate-700">Set as Primary Active Template</label>
                </div>

                <div class="pt-6 border-t border-slate-50 flex gap-4">
                    <button type="submit"
                        class="bg-[#8046F1] hover:bg-[#6D28D9] text-white font-black py-4 px-10 rounded-xl shadow-lg shadow-purple-100 transition-all active:scale-95 text-sm uppercase tracking-widest">
                        Update Template
                    </button>
                    <a href="{{ route('admin.email-templates.index') }}"
                        class="py-4 px-10 rounded-xl text-slate-400 font-bold text-sm uppercase tracking-widest hover:bg-slate-50 transition-all">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'],
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                    ]
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush