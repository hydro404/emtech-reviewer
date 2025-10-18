@extends('layout')

@section('style')
    {{-- Use a more modern font and add the transition for the progress bar --}}
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
        }

        .progress-bar-fill {
            transition: width 0.5s ease-in-out;
        }
    </style>
@endsection

@section('content')
    <div class="flex flex-grow items-center justify-center p-4">
        <div>
            <div class="text-center mb-10 md:pt-0 pt-5">
                <h1 class="text-4xl sm:text-5xl font-bold text-indigo-600 dark:text-indigo-400">
                    Empowerment Technologies Reviewer
                </h1>
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">
                    Camalig National High School
                </p>
                {{-- <p class="text-sm text-gray-500">October 18, 2025</p> --}}
            </div>

            <!-- Selection Cards Grid -->
            <div class="w-full max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- Card 1: Multiple Choice -->
                <a href="/part1"
                    class="block p-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 ease-in-out border-t-4 border-indigo-500">
                    <h2 class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">Part I</h2>
                    <h3 class="text-xl font-semibold mt-2 text-gray-900 dark:text-white">Multiple Choice</h3>
                    <p class="mt-4 text-gray-600 dark:text-gray-300">
                        Read and understand each item carefully. Choose the letter of the best answer and write it on your
                        answer sheets.
                    </p>
                </a>

                <!-- Card 2: Enumeration -->
                <a href="/part2"
                    class="block p-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 ease-in-out border-t-4 border-teal-500">
                    <h2 class="text-2xl font-bold text-teal-600 dark:text-teal-400">Part II</h2>
                    <h3 class="text-xl font-semibold mt-2 text-gray-900 dark:text-white">Enumeration</h3>
                    <p class="mt-4 text-gray-600 dark:text-gray-300">
                        Provide the items required in the following questions.
                    </p>
                </a>

                <!-- Card 3: Concept Application -->
                <a href="/part3"
                    class="block p-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 ease-in-out border-t-4 border-rose-500">
                    <h2 class="text-2xl font-bold text-rose-600 dark:text-rose-400">Part III</h2>
                    <h3 class="text-xl font-semibold mt-2 text-gray-900 dark:text-white">Concept Application</h3>
                    <p class="mt-4 text-gray-600 dark:text-gray-300">
                        Identify what is asked on the following items based on the concepts you have learned.
                    </p>
                </a>

            </div>
        </div>
    </div>
    @include('partials.footer')
@endsection
