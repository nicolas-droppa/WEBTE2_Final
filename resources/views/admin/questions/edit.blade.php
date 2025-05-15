@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto px-6 mt-16 mb-20">
    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-300 dark:border-red-500 text-red-600 dark:text-red-400 rounded-lg">
        <strong class="block text-sm font-semibold mb-2">{{ __('general.input_errors') }}</strong>
        <ul class="list-disc pl-5 text-sm space-y-1">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
        <h1 class="text-4xl font-bold text-slate-800 dark:text-gray-100">
            <i class="fa-solid fa-pen-to-square mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
            {{ __('questions.edit_title') }}
        </h1>
        <a href="{{ route('admin.questions.index') }}"
           class="bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-white px-4 py-2 rounded hover:bg-slate-300 dark:hover:bg-slate-600 transition shadow flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> {{ __('questions.back_to_list') }}
        </a>
    </div>

    <form method="POST" action="{{ route('admin.questions.update', $question->id) }}" id="question-form"
        class="bg-white dark:bg-[#1c1c1e] p-8 rounded-xl shadow-md border border-slate-200 dark:border-[#141414] space-y-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="assignment_sk" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                {{ __('questions.assignment_sk') }}
            </label>
            <input type="text" name="assignment_sk" id="assignment_sk" value="{{ old('assignment_sk', $question->assignment_sk) }}" class="w-full border border-slate-300 dark:border-slate-600 dark:bg-[#2a2a2a] dark:text-white rounded-md px-3 py-2 shadow-sm focus:ring-[#54b5ff] focus:border-[#54b5ff]" required>
            <div id="assignment_sk_preview" class="mt-2 text-slate-700 dark:text-slate-200 text-sm"></div>
        </div>

        <div class="mb-4">
            <label for="assignment_en" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                {{ __('questions.assignment_en') }}
            </label>
            <input type="text" name="assignment_en" id="assignment_en" value="{{ old('assignment_en', $question->assignment_en) }}" class="w-full border border-slate-300 dark:border-slate-600 dark:bg-[#2a2a2a] dark:text-white rounded-md px-3 py-2 shadow-sm focus:ring-[#54b5ff] focus:border-[#54b5ff]" required>
            <div id="assignment_en_preview" class="mt-2 text-slate-700 dark:text-slate-200 text-sm"></div>
        </div>

        <div class="mb-6">
            <input type="hidden" name="isMultiChoice" value="0">
            <input type="checkbox" id="multiChoice" name="isMultiChoice" value="1" {{ old('isMultiChoice', $question->isMultiChoice) ? 'checked' : '' }} class="rounded border-slate-300 dark:border-slate-500 text-blue-500 focus:ring-blue-400 dark:focus:ring-blue-600">
            <label for="multiChoice" class="text-sm text-slate-700 dark:text-slate-300">{{ __('questions.multi_choice') }}</label>
        </div>

        <div id="tags_container" class="space-y-2 mb-4">
            <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-100 mb-2">{{ __('questions.tags_label') }}</h3>
            <div id="tag-pairs">
                @foreach($question->tags as $index => $tag)
                <div class="tag-pair flex gap-2 items-center">
                    <input type="text" name="tags[{{ $index }}][name_en]" value="{{ $tag['name_en'] }}" placeholder="Tag (EN)" class="tag-en w-1/2 p-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-md" required>
                    <input type="text" name="tags[{{ $index }}][name_sk]" value="{{ $tag['name_sk'] }}" placeholder="Tag (SK)" class="tag-sk w-1/2 p-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-md" required>
                    <button type="button" class="remove-tag text-red-500 hover:text-red-700 dark:hover:text-red-400 text-sm"><i class="fas fa-trash"></i></button>
                </div>
                @endforeach
            </div>
            <button type="button" id="add-tag" class="flex items-center h-9 rounded-md overflow-hidden transition duration-300 group">
                <div class="relative flex items-center h-full bg-[#e6f4ff] dark:bg-[#1e2b3a] text-[#1e3a5f] dark:text-[#9ec9ff] text-sm font-semibold pl-4 pr-4 rounded-l-md transition-colors duration-300 group-hover:bg-[#d5ecfd] dark:group-hover:bg-[#253448]">
                    {{ __('questions.add_tag') }}
                </div>
                <div class="w-9 h-9 flex items-center justify-center bg-[#f7f7f7] dark:bg-[#1c1c1c] text-slate-800 dark:text-slate-100 transition-colors duration-300 group-hover:bg-[#ebebeb] dark:group-hover:bg-[#212121]">
                    <span class="text-lg font-bold leading-none">+</span>
                </div>
            </button>
        </div>

        <div id="answers" class="mt-3">
            <h3 class="text-lg font-semibold mb-4 text-slate-700 dark:text-slate-100">
                <i class="fas fa-check-circle mr-1 text-[#54b5ff]"></i> {{ __('questions.answers_label') }}
            </h3>
            @foreach($question->answers as $index => $answer)
            <div class="answer mb-4 border border-slate-200 dark:border-slate-600 p-4 rounded-lg bg-slate-50 dark:bg-[#2a2a2a] relative">
                <input type="text" name="answers[{{ $index }}][answer_sk]" value="{{ old('answers.' . $index . '.answer_sk', $answer->answer_sk) }}" placeholder="Odpoveď (SK)" class="answer-input answer-sk-input w-full border border-slate-300 dark:border-slate-600 bg-white dark:bg-[#2a2a2a] text-slate-800 dark:text-white p-2 rounded-md mb-2">
                <div class="answer-preview text-slate-700 dark:text-slate-200 text-sm mb-2"></div>
                <input type="text" name="answers[{{ $index }}][answer_en]" value="{{ old('answers.' . $index . '.answer_en', $answer->answer_en) }}" placeholder="Answer (EN)" class="answer-input answer-en-input w-full border border-slate-300 dark:border-slate-600 bg-white dark:bg-[#2a2a2a] text-slate-800 dark:text-white p-2 rounded-md mb-2">
                <div class="answer-preview text-slate-700 dark:text-slate-200 text-sm mb-2"></div>
                <input type="hidden" name="answers[{{ $index }}][id]" value="{{ $answer['id'] }}">
                <div class="flex items-center mb-4">
                    <input type="hidden" name="answers[{{ $index }}][isCorrect]" value="0">
                    <label for="isCorrect-{{ $index }}" class="inline-flex items-center cursor-pointer group">
                        <input type="checkbox" id="isCorrect-{{ $index }}" name="answers[{{ $index }}][isCorrect]" value="1" class="sr-only peer" {{ old('answers.' . $index . '.isCorrect', $answer->isCorrect) ? 'checked' : '' }} onchange="toggleCorrectText(this)">
                        <div class="w-5 h-5 mr-3 flex items-center justify-center border-2 rounded-md border-slate-300 dark:border-slate-600 bg-white dark:bg-[#2a2a2a] peer-checked:bg-green-500 peer-checked:border-green-500 transition duration-200">
                            <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span id="correctLabel-{{ $index }}" class="text-sm text-slate-700 dark:text-slate-300 select-none">
                            {{ old('answers.' . $index . '.isCorrect', $answer->isCorrect) ? __('questions.correct') : __('questions.incorrect') }}
                        </span>
                    </label>
                </div>
                <button type="button" class="remove-answer absolute bottom-2 right-2 text-sm text-red-500 hover:text-red-700 dark:hover:text-red-400">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            @endforeach
        </div>

        <button type="button" id="add-answer" class="flex items-center h-9 rounded-md overflow-hidden transition duration-300 group">
            <div class="relative flex items-center h-full bg-[#e6f4ff] dark:bg-[#1e2b3a] text-[#1e3a5f] dark:text-[#9ec9ff] text-sm font-semibold pl-4 pr-4 rounded-l-md transition-colors duration-300 group-hover:bg-[#d5ecfd] dark:group-hover:bg-[#253448]">
                {{ __('questions.add_answer') }}
            </div>
            <div class="w-9 h-9 flex items-center justify-center bg-[#f7f7f7] dark:bg-[#1c1c1c] text-slate-800 dark:text-slate-100 transition-colors duration-300 group-hover:bg-[#ebebeb] dark:group-hover:bg-[#212121]">
                <span class="text-lg font-bold leading-none">+</span>
            </div>
        </button>

        <div>
            <button type="submit" class="inline-block bg-[#54b5ff] text-white px-6 py-2 rounded hover:bg-[#3ca5ec] transition shadow w-full">
                <i class="fas fa-save mr-1"></i> {{ __('questions.save_button') }}
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/katex@0.15.3/dist/katex.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/katex@0.15.3/dist/contrib/auto-render.min.js"></script>

<script>
    function toggleCorrectText(checkbox) {
        const id = checkbox.id.replace("isCorrect", "correctLabel");
        const label = document.getElementById(id);

        if (!label) return;

        const correct = @json(__('questions.correct'));
        const incorrect = @json(__('questions.incorrect'));

        label.textContent = checkbox.checked ? correct : incorrect;
    }
</script>

<script>
    let answerCount = {{count($question->answers)}};

    document.getElementById("add-answer").addEventListener("click", () => {
        const container = document.createElement('div');
        container.classList.add('answer', 'mb-4', 'border', 'border-gray-200', 'p-4', 'rounded-lg', 'bg-gray-50', 'relative', 'dark:bg-gray-800', 'dark:border-gray-600');

        container.innerHTML = `
            <input type="text" name="answers[${answerCount}][answer_en]" placeholder="Answer (EN)" class="answer-input answer-sk-input w-full border border-slate-300 dark:border-slate-600 bg-white dark:bg-[#2a2a2a] text-slate-800 dark:text-white p-2 rounded-md mb-2">
            <div class="answer-preview mt-2 mb-2 text-gray-700 dark:text-gray-200"></div>
            <input type="text" name="answers[${answerCount}][answer_sk]" placeholder="Answer (SK)" class="answer-input answer-en-input w-full border border-slate-300 dark:border-slate-600 bg-white dark:bg-[#2a2a2a] text-slate-800 dark:text-white p-2 rounded-md mb-2">
            <div class="answer-preview mt-2 mb-2 text-gray-700 dark:text-gray-200"></div>
            <div class="flex items-center space-x-2">
                <input type="hidden" name="answers[${answerCount}][isCorrect]" value="0">
                <input id="answers[${answerCount}][isCorrect]" type="checkbox" name="answers[${answerCount}][isCorrect]" value="1" class="rounded border-gray-300 dark:border-gray-500 text-green-600 focus:ring-green-500 dark:focus:ring-green-500">
                <label for="answers[${answerCount}][isCorrect]" class="text-sm text-gray-700 dark:text-gray-300">Is Correct?</label>
            </div>
            <button type="button" class="remove-answer absolute bottom-2 right-2 text-sm text-red-500 hover:text-red-700 dark:hover:text-red-400"><i class="fas fa-trash"></i></button>
        `;

        document.getElementById("answers").appendChild(container);
        answerCount++;

        // Now we need to apply KaTeX rendering to the newly added answer's input
        setupAnswerPreviews();
    });

    const form = document.getElementById("question-form");
    form.addEventListener("submit", function(e) {
        const tagInput = document.getElementById("tags_input");
        const tags = tagInput.value.split(",").map(tag => tag.trim()).filter(tag => tag.length > 0);

        // Clear the existing hidden tag inputs
        const tagsContainer = document.getElementById("tags_container");
        tagsContainer.innerHTML = "";

        // Create hidden input fields for each tag
        tags.forEach(tag => {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "tags[]"; // Ensure this is named "tags[]" for an array
            input.value = tag;
            tagsContainer.appendChild(input);
        });
    });

    document.getElementById("answers").addEventListener("click", function (e) {
        const removeBtn = e.target.closest('.remove-answer');
        if (removeBtn) {
            const answerBlock = removeBtn.closest('.answer');
            if (answerBlock) answerBlock.remove();
        }
    });

    // KaTeX rendering for preview on input fields
    function setupAnswerPreviews() {
        document.querySelectorAll('.answer-input').forEach(input => {
            const preview = input.nextElementSibling;
            input.addEventListener('input', () => {
                try {
                    preview.innerHTML = katex.renderToString(input.value, {
                        throwOnError: false,
                        displayMode: false
                    });
                } catch (e) {
                    preview.innerHTML = '<span class="text-red-500">Invalid LaTeX</span>';
                }
            });

            // Initial rendering for already existing answers
            try {
                preview.innerHTML = katex.renderToString(input.value, {
                    throwOnError: false,
                    displayMode: false
                });
            } catch (e) {
                preview.innerHTML = '<span class="text-red-500">Invalid LaTeX</span>';
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        renderMathInElement(document.body, {
            delimiters: [{
                    left: "$",
                    right: "$",
                    display: false
                },
                {
                    left: "$$",
                    right: "$$",
                    display: true
                }
            ]
        });

        // Setup assignment previews
        const skInput = document.getElementById("assignment_sk");
        const skPreview = document.getElementById("assignment_sk_preview");
        const enInput = document.getElementById("assignment_en");
        const enPreview = document.getElementById("assignment_en_preview");

        function renderAssignment(input, preview) {
            try {
                preview.innerHTML = katex.renderToString(input.value, {
                    throwOnError: false,
                    displayMode: false
                });
            } catch (e) {
                preview.innerHTML = '<span class="text-red-500">Invalid LaTeX</span>';
            }
        }

        // Trigger initial rendering
        renderAssignment(skInput, skPreview);
        renderAssignment(enInput, enPreview);

        skInput.addEventListener("input", () => renderAssignment(skInput, skPreview));
        enInput.addEventListener("input", () => renderAssignment(enInput, enPreview));

        // Setup answer previews and render initial content for existing answers
        setupAnswerPreviews(); // Initial render for existing inputs
    });

    let tagIndex = 0;

    function createTagPair(name_en = '', name_sk = '') {
        const div = document.createElement('div');
        div.classList.add('tag-pair', 'flex', 'gap-2', 'items-center');
        div.innerHTML = `
            <input type="text" name="tags[${tagIndex}][name_en]" value="${name_en}" placeholder="Tag (EN)" class="tag-en w-1/2 p-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-md" required>
            <input type="text" name="tags[${tagIndex}][name_sk]" value="${name_sk}" placeholder="Tag (SK)" class="tag-sk w-1/2 p-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-md" required>
            <button type="button" class="remove-tag text-red-500 hover:text-red-700 dark:hover:text-red-400 text-sm"><i class="fas fa-trash"></i></button>
        `;
        document.getElementById("tag-pairs").appendChild(div);

        div.querySelector('.remove-tag').addEventListener('click', () => {
            div.remove();
        });

        tagIndex++;
    }

    document.getElementById("add-tag").addEventListener("click", () => {
        createTagPair();
    });
</script>
@endsection