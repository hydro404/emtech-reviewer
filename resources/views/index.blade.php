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
    {{-- Initialize the theme controller for the entire page --}}
    <div x-data="themeController" x-init="init()" class="w-full text-gray-800 dark:text-gray-200">
        <div class="flex flex-col min-h-screen">
            <!-- Navigation Bar -->
            <nav class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-10">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center">
                            <svg class="h-8 w-8 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            <span class="ml-3 font-bold text-xl text-gray-900 dark:text-white">ICT Fundamentals Quiz</span>
                        </div>
                        <div class="flex items-center">
                            <button @click="toggleTheme()"
                                class="p-2 rounded-full text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                <span class="sr-only">Toggle dark mode</span>
                                <!-- Sun Icon -->
                                <svg x-show="!isDarkMode" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <!-- Moon Icon -->
                                <svg x-show="isDarkMode" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Quiz Content -->
            <main class="flex-grow flex items-center justify-center p-4">
                <div class="w-full max-w-2xl" x-data="quiz()">

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
                        <button @click="restartQuiz()"
                            class="mt-8 w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:ring-offset-gray-800">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h5M20 20v-5h-5"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 9a9 9 0 0114.13-6.364M20 15a9 9 0 01-14.13 6.364"></path>
                            </svg>
                            Restart Quiz
                        </button>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // This script handles the dark/light mode toggle.
        const themeController = {
            init() {
                // Default to light mode if no theme is saved in localStorage
                this.isDarkMode = localStorage.getItem('theme') === 'dark';
                this.applyTheme();
            },
            isDarkMode: false,
            toggleTheme() {
                this.isDarkMode = !this.isDarkMode;
                localStorage.setItem('theme', this.isDarkMode ? 'dark' : 'light');
                this.applyTheme();
            },
            applyTheme() {
                if (this.isDarkMode) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        };

        function quiz() {
            return {
                questions: {!! $questionsJson !!},
                currentQuestionIndex: 0,
                score: 0,
                selectedAnswer: null,
                answered: false,

                // Check if the quiz is finished
                isQuizFinished() {
                    return this.currentQuestionIndex >= this.questions.length;
                },

                // Handle answer selection
                selectAnswer(option) {
                    if (this.answered) return; // Prevent clicking multiple times

                    this.answered = true;
                    this.selectedAnswer = option;

                    if (option === this.questions[this.currentQuestionIndex].answer) {
                        this.score++;
                    }

                    // Wait for 1.5 seconds then move to the next question
                    setTimeout(() => {
                        this.currentQuestionIndex++;
                        this.answered = false;
                        this.selectedAnswer = null;
                    }, 1500);
                },

                // Determine the CSS class for each option button based on its state
                getOptionClass(option) {
                    // This can happen briefly as the next question loads
                    if (!this.questions[this.currentQuestionIndex]) return ''; 
                    
                    const correctAnswer = this.questions[this.currentQuestionIndex].answer;

                    if (!this.answered) {
                        return 'bg-white dark:bg-gray-700 hover:bg-indigo-50 dark:hover:bg-gray-600';
                    }

                    if (option === correctAnswer) {
                        return 'bg-green-500 text-white pointer-events-none';
                    }

                    if (this.selectedAnswer === option && option !== correctAnswer) {
                        return 'bg-red-500 text-white pointer-events-none';
                    }

                    return 'bg-white dark:bg-gray-700 pointer-events-none opacity-60';
                },

                // Restart the quiz
                restartQuiz() {
                    this.currentQuestionIndex = 0;
                    this.score = 0;
                    this.selectedAnswer = null;
                    this.answered = false;
                },

                // Get a feedback message based on the final score
                getFeedbackMessage() {
                    const percentage = (this.score / this.questions.length) * 100;
                    if (percentage === 100) return "Perfect Score! Excellent work!";
                    if (percentage >= 80) return "Great job! You know your stuff.";
                    if (percentage >= 50) return "Good effort! A little more practice will help.";
                    return "Keep practicing! You can do better.";
                }
            };
        }
    </script>
@endsection

