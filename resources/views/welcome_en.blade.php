@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-16 mb-20 px-6">
        <h1 class="text-4xl font-bold mb-6 text-slate-800 dark:text-gray-100">Welcome to the M3th Page!</h1>
        <p class="text-lg text-slate-600 dark:text-gray-300 mb-10">
            Discover a variety of math problems, exercises, and tests that will help you improve your skills.
        </p>

        <div class="bg-white dark:bg-[#1c1c1e] rounded-xl shadow-md p-8 space-y-8 border border-slate-200 dark:border-[#141414]">
            <h2 class="text-2xl font-semibold text-[#54b5ff] dark:text-[#54b5ff] border-b pb-2 dark:border-[#141414]">
                <i class="fas fa-compass mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                How to Use the App
            </h2>

            <section class="space-y-2">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
                    <i class="fas fa-globe mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                    Switching Language and Theme
                </h3>
                <p class="text-slate-700 dark:text-gray-400">
                    In the top bar, you can change the app language (e.g., Slovak / English) and also toggle between
                    <strong>light/dark mode</strong> using the icons.
                </p>
            </section>

            <section class="space-y-2">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
                    <i class="fas fa-question-circle mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                    Types of Questions in the Test
                </h3>
                <ul class="list-disc list-inside text-slate-700 dark:text-gray-400 space-y-1">
                    <li>Multiple choice questions – only <strong>one correct answer</strong>.</li>
                    <li>Open-ended questions where you enter a <strong>numeric answer</strong>.</li>
                    <li>Write numbers with either a dot or a comma (<code>1.25</code> / <code>1,25</code>).</li>
                    <li>It is recommended to <strong>round to 2 decimal places</strong> if not specified otherwise.</li>
                </ul>
            </section>

            <section class="space-y-2">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
                    <i class="fas fa-stopwatch mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                    Time Limit
                </h3>
                <p class="text-slate-700 dark:text-gray-400">
                    As soon as the question appears, the <strong>timer starts</strong>. Questions appear one by one, and the speed of your answers is part of the scoring.
                </p>
            </section>

            <section class="space-y-2">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
                    <i class="fas fa-unlock-alt mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                    No Registration Required
                </h3>
                <p class="text-slate-700 dark:text-gray-400">
                    You can fill out the test <strong>without registration</strong>. The results will be saved anonymously, along with your location information (city and country).
                </p>
            </section>

            <section class="space-y-2">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
                    <i class="fas fa-chart-bar mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                    Results and Recommendations
                </h3>
                <ul class="list-disc list-inside text-slate-700 dark:text-gray-400 space-y-1">
                    <li>We will display the correct and incorrect answers along with explanations.</li>
                    <li>You will receive a <strong>recommendation for repeating specific topics</strong>.</li>
                    <li>You can compare your <strong>completion time with the average of other users</strong>.</li>
                    <li>You can <strong>download your results as a PDF</strong> for further analysis or printing.</li>
                </ul>
            </section>

            <div class="pt-4">
                <p class="text-base text-slate-600 dark:text-gray-400">
                    Are you ready? <span class="font-semibold text-[#54b5ff] dark:text-[#54b5ff]">Start your math training now!</span>
                </p>
            </div>
        </div>
    </div>
@endsection
