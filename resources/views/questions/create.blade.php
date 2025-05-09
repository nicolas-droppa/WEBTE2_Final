@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white dark:bg-[#1c1c1e] rounded-2xl shadow-sm mt-6 border border-gray-200 dark:border-gray-700">
    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-300 dark:border-red-500 text-red-600 dark:text-red-400 rounded-lg">
        <strong class="block text-sm font-semibold mb-2">There were some problems with your input:</strong>
        <ul class="list-disc pl-5 text-sm space-y-1">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <h2 class="text-2xl font-semibold mb-6 text-gray-700 dark:text-gray-100">Create New Question</h2>

    <form method="POST" action="{{ route('questions.store') }}" id="question-form">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Assignment (SK)</label>
            <input type="text" name="assignment_sk" id="assignment_sk" class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600" required>
            <div id="assignment_sk_preview" class="mt-2 text-gray-700 dark:text-gray-200"></div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Assignment (EN)</label>
            <input type="text" name="assignment_en" id="assignment_en" class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600" required>
            <div id="assignment_en_preview" class="mt-2 text-gray-700 dark:text-gray-200"></div>
        </div>

        <div class="flex items-center mb-6 space-x-2">
            <input type="hidden" name="isMultiChoice" value="0">
            <input type="checkbox" id="multiChoice" name="isMultiChoice" value="1" {{ old('isMultiChoice') ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-500 text-blue-500 focus:ring-blue-400 dark:focus:ring-blue-600">
            <label for="multiChoice" class="text-sm text-gray-700 dark:text-gray-300">Is Multi Choice?</label>
        </div>

        <div id="tags_container" class="space-y-2 mb-4">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-100 mb-2">Tags</h3>
            <div id="tag-pairs">
                <!-- Will be dynamically filled -->
            </div>
            <button type="button" id="add-tag" class="text-blue-500 hover:text-blue-700 dark:hover:text-blue-400 text-sm">Add Tag</button>
        </div>

        <div id="answers" class="mt-3">
            <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-100">Answers</h3>

            <div class="answer mb-4 border border-gray-200 dark:border-gray-600 p-4 rounded-lg bg-gray-50 dark:bg-gray-800 relative">
                <input type="text" name="answers[0][answer]" placeholder="Answer text" class="answer-input w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 p-2 rounded-md mb-2 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-500">
                <div class="answer-preview mt-2 text-gray-700 dark:text-gray-200"></div>
                <div class="flex items-center space-x-2">
                    <input type="hidden" name="answers[0][isCorrect]" value="0">
                    <input id="answers[0][isCorrect]" type="checkbox" name="answers[0][isCorrect]" value="1" {{ old('answers.0.isCorrect') ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-500 text-green-600 focus:ring-green-400 dark:focus:ring-green-500">
                    <label class="text-sm text-gray-700 dark:text-gray-300" for="answers[0][isCorrect]">Is Correct?</label>
                </div>
                <button type="button" class="remove-answer absolute bottom-2 right-2 text-sm text-red-500 hover:text-red-700 dark:hover:text-red-400">
                    Delete
                </button>
            </div>
        </div>

        <button type="button" id="add-answer" class="px-4 py-2 dark:bg-[#54b5ff] dark:text-blue-100 text-[#54b5ff] rounded-md bg-blue-100 transition mb-6">
            + Add Another Answer
        </button>

        <div>
            <button type="submit" class="inline-block bg-[#54b5ff] text-white px-6 py-2 rounded hover:bg-[#3ca5ec] transition shadow w-full">
                Save Question
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/katex@0.15.3/dist/katex.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/katex@0.15.3/dist/contrib/auto-render.min.js"></script>

<script>
    let answerCount = 1;

    document.getElementById("add-answer").addEventListener("click", () => {
        const container = document.createElement('div');
        container.classList.add('answer', 'mb-4', 'border', 'border-gray-200', 'p-4', 'rounded-lg', 'bg-gray-50', 'relative', 'dark:bg-gray-800', 'dark:border-gray-600');

        container.innerHTML = `
            <input type="text" name="answers[${answerCount}][answer]" placeholder="Answer text" class="answer-input w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 p-2 rounded-md mb-2 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-500">
            <div class="answer-preview mt-2 text-gray-700 dark:text-gray-200"></div>
            <div class="flex items-center space-x-2">
                <input type="hidden" name="answers[${answerCount}][isCorrect]" value="0">
                <input id="answers[${answerCount}][isCorrect]" type="checkbox" name="answers[${answerCount}][isCorrect]" value="1" class="rounded border-gray-300 dark:border-gray-500 text-green-600 focus:ring-green-500 dark:focus:ring-green-500">
                <label for="answers[${answerCount}][isCorrect]" class="text-sm text-gray-700 dark:text-gray-300">Is Correct?</label>
            </div>
            <button type="button" class="remove-answer absolute bottom-2 right-2 text-sm text-red-500 hover:text-red-700 dark:hover:text-red-400">Delete</button>
        `;


        document.getElementById("answers").appendChild(container);
        answerCount++;
    });


    document.getElementById("answers").addEventListener("click", function(e) {
        if (e.target.classList.contains('remove-answer')) {
            const answerBlock = e.target.closest('.answer');
            answerBlock.remove();
        }
    });

    const form = document.getElementById("question-form");
    form.addEventListener("submit", function(e) {
        const tagInput = document.getElementById("tags_input");
        const tags = tagInput.value.split(",").map(tag => tag.trim()).filter(tag => tag.length > 0);

        const tagsContainer = document.getElementById("tags_container");
        tagsContainer.innerHTML = "";

        tags.forEach(tag => {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "tags[]";
            input.value = tag;
            tagsContainer.appendChild(input);
        });
    });


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
        skInput.addEventListener("input", function() {
            try {
                skPreview.innerHTML = katex.renderToString(skInput.value, {
                    throwOnError: false,
                    displayMode: false
                });
            } catch (e) {
                skPreview.innerHTML = '<span class="text-red-500">Invalid LaTeX</span>';
            }
        });

        const enInput = document.getElementById("assignment_en");
        const enPreview = document.getElementById("assignment_en_preview");
        enInput.addEventListener("input", function() {
            try {
                enPreview.innerHTML = katex.renderToString(enInput.value, {
                    throwOnError: false,
                    displayMode: false
                });
            } catch (e) {
                enPreview.innerHTML = '<span class="text-red-500">Invalid LaTeX</span>';
            }
        });

        // Initial setup for existing answer inputs
        setupAnswerPreviews();

        // After new answers are added, re-bind
        document.getElementById("add-answer").addEventListener("click", () => {
            setTimeout(() => setupAnswerPreviews(), 100); // Delay slightly to ensure DOM is updated
        });
    });

    let tagIndex = 0;

    function createTagPair(name_en = '', name_sk = '') {
        const div = document.createElement('div');
        div.classList.add('tag-pair', 'flex', 'gap-2', 'items-center');
        div.innerHTML = `
            <input type="text" name="tags[${tagIndex}][name_en]" value="${name_en}" placeholder="Tag (EN)" class="tag-en w-1/2 p-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-md" required>
            <input type="text" name="tags[${tagIndex}][name_sk]" value="${name_sk}" placeholder="Tag (SK)" class="tag-sk w-1/2 p-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-md" required>
            <button type="button" class="remove-tag text-red-500 hover:text-red-700 dark:hover:text-red-400 text-sm">✖</button>
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

    // Initialize one tag-pair on page load
    document.addEventListener("DOMContentLoaded", () => {
        createTagPair();
    });
</script>
@endsection