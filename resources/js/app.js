import './bootstrap';

import Alpine from 'alpinejs';

/**
 * Alpine.js component for handling the theme (dark/light mode).
 */
Alpine.data('themeController', () => ({
    // Initialize with the theme from localStorage or default to light mode
    isDarkMode: localStorage.getItem('theme') === 'dark',

    init() {
        // Apply the theme immediately when the component loads
        this.applyTheme();
    },

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
}));

/**
 * Alpine.js component for the main quiz functionality.
 * This function now accepts an 'initialData' object to receive the questions.
 */
Alpine.data('quiz', (initialData) => ({
    // Initialize questions as an empty array. It will be populated by init().
    questions: [],
    currentQuestionIndex: 0,
    score: 0,
    selectedAnswer: null,
    answered: false,

    /**
     * init() is called by Alpine.js when the component is ready.
     * We'll set up our questions data from the data passed in.
     */
    init() {
        const questionsData = initialData.questions || [];
        
        // The proxy remains as a safeguard against edge-case rendering errors.
        this.questions = new Proxy(questionsData, {
            get(target, prop) {
                if (typeof prop === 'symbol') {
                    return target[prop];
                }
                if (prop in target) {
                    return target[prop];
                }
                if (String(parseInt(prop)) === prop && prop >= target.length) {
                     return { question: '', options: [] };
                }
                return target[prop];
            }
        });
    },

    // Check if the quiz is finished
    isQuizFinished() {
        // Ensure questions array has a length before checking
        return this.questions.length > 0 && this.currentQuestionIndex >= this.questions.length;
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
        if (!this.questions[this.currentQuestionIndex] || this.isQuizFinished()) return ''; 
        
        const correctAnswer = this.questions[this.currentQuestionIndex].answer;

        if (!this.answered) {
            return 'bg-white dark:bg-gray-700 hover:bg-indigo-50 dark:hover:bg-gray-600 cursor-pointer';
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
        if (this.questions.length === 0) return "Loading Quiz...";
        const percentage = (this.score / this.questions.length) * 100;
        if (percentage === 100) return "Perfect Score! Excellent work!";
        if (percentage >= 80) return "Great job! You know your stuff.";
        if (percentage >= 50) return "Good effort! A little more practice will help.";
        return "Keep practicing! You can do better.";
    }
}));

window.Alpine = Alpine;
Alpine.start();

