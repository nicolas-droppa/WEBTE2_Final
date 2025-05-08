@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-20 px-4 text-center">
        <h1 class="text-4xl font-bold mb-6 dark:text-white">Welcome to the Math Platform!</h1>
        <p class="text-lg text-gray-700 dark:text-gray-300 mb-10">
            Discover a wide range of math problems, exercises, and tests designed to sharpen your skills.
        </p>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-8 text-left space-y-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">How to Use This Application</h2>

            <div class="space-y-4">
                <div>
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">🗺️ Language & Theme Switch</h3>
                    <p class="text-gray-700 dark:text-gray-400">
                        In the top navigation bar, you can switch between supported languages (e.g., English / Slovak).
                        You can also toggle between light and dark themes to suit your visual preferences.
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">📝 Question Types</h3>
                    <ul class="list-disc list-inside text-gray-700 dark:text-gray-400">
                        <li>Multiple-choice questions with only one correct answer.</li>
                        <li>Open-ended numerical questions where you type in the result.</li>
                        <li>Decimal numbers can be written using either a <strong>dot (1.25)</strong> or a <strong>comma (1,25)</strong>.</li>
                        <li>Unless stated otherwise, you should round your answer to <strong>two decimal places</strong>.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">⏱️ Timing & Question Flow</h3>
                    <p class="text-gray-700 dark:text-gray-400">
                        A timer starts as soon as a question is displayed. Each question is shown individually — no skipping ahead.
                        Answer promptly, as speed also counts in your evaluation!
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">🔐 No Login Required</h3>
                    <p class="text-gray-700 dark:text-gray-400">
                        You <strong>don’t need to log in</strong> to take the tests. Your results are stored anonymously along with your approximate city and country location.
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">📊 Results & Feedback</h3>
                    <ul class="list-disc list-inside text-gray-700 dark:text-gray-400">
                        <li>At the end of each test, you'll see which answers were correct and which were not — along with explanations.</li>
                        <li>We’ll recommend which topics you should revise based on your performance.</li>
                        <li>You’ll also see the <strong>average solving time</strong> of other users for each question.</li>
                        <li>Results can be <strong>exported to a PDF file</strong> for your reference or printing.</li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-base text-gray-600 dark:text-gray-400">Ready to start? <span class="font-semibold">Jump into a math challenge now!</span></p>
            </div>
        </div>
    </div>
@endsection
