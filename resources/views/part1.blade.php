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
    <main class="flex-grow flex items-center justify-center p-4">
        <div class="w-full max-w-2xl" x-data='quiz({ questions: @json($questionsJson) })'>

            <!-- Quiz Container -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 sm:p-8 transition-all duration-500"
                x-show="!isQuizFinished()">

                <!-- Header: Question Number and Score -->
                <div class="flex justify-between items-center mb-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Question <span x-text="currentQuestionIndex + 1"></span> of <span
                            x-text="questions.length"></span>
                    </p>
                    <p
                        class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-100 dark:bg-gray-700 px-3 py-1 rounded-full">
                        Score: <span x-text="score"></span>
                    </p>
                </div>

                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mb-6">
                    <div class="bg-indigo-600 dark:bg-indigo-400 h-2.5 rounded-full progress-bar-fill"
                        :style="`width: ${((currentQuestionIndex + 1) / questions.length) * 100}%`"></div>
                </div>

                <!-- Question Text -->
                <div class="mb-6">
                    <p class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white"
                        x-text="questions[currentQuestionIndex].question"></p>
                </div>

                <!-- Options -->
                <div class="space-y-4">
                    <template x-for="(option, index) in questions[currentQuestionIndex].options" :key="index">
                        <button @click="selectAnswer(option)" :class="getOptionClass(option)"
                            class="w-full text-left p-4 rounded-lg border border-gray-300 dark:border-gray-600 font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <div class="flex items-center justify-between">
                                <span x-text="option"></span>
                                <!-- Icon for feedback -->
                                <span x-show="answered && getOptionClass(option).includes('bg-green-500')">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </span>
                                <span x-show="answered && getOptionClass(option).includes('bg-red-500')">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </span>
                            </div>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Final Score Screen -->
            <div class="text-center bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 transition-opacity duration-500" x-show="isQuizFinished()">
                <svg class="w-24 h-24 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mt-4">Quiz Complete!</h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 mt-2">You've reached the end of the quiz.</p>
                <p class="text-4xl font-bold text-indigo-600 dark:text-indigo-400 mt-6">
                    Your Score: <span x-text="score"></span> / <span x-text="questions.length"></span>
                </p>
                <p class="text-xl font-medium mt-2" x-text="getFeedbackMessage()"></p>
                <div class="mt-8 flex flex-col sm:flex-row sm:justify-center sm:gap-4">

                    <button @click="restartQuiz()"
                            class="cursor-pointer w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:ring-offset-gray-800">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h5M20 20v-5h-5"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 9a9 9 0 0114.13-6.364M20 15a9 9 0 01-14.13 6.364"></path>
                        </svg>
                        Restart Quiz
                    </button>

                    <a href="/"
                    class="mt-4 sm:mt-0 w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:ring-offset-gray-800">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        Return to Home
                    </a>
                    
                </div>
                {{-- Go back home --}}

            </div>
        </div>
    </main>
    @include('partials.footer')
@endsection