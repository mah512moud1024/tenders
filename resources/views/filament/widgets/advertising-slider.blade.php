<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <!-- Slider Container -->
    <div x-data="{
        currentSlide: 0,
        slides: [
            {
                id: 1,
                image: 'https://images.unsplash.com/photo-1503387769-9cB742aa8d8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                title: 'Premium Construction Services',
                description: 'Professional construction solutions for your projects',
                cta: 'Learn More'
            },
            {
                id: 2,
                image: 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                title: 'Expert Engineering Team',
                description: 'Skilled professionals for complex engineering challenges',
                cta: 'Our Services'
            },
            {
                id: 3,
                image: 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                title: 'Quality Materials Guaranteed',
                description: 'We use only the highest quality materials for lasting results',
                cta: 'View Portfolio'
            }
        ],
        next() {
            this.currentSlide = (this.currentSlide + 1) % this.slides.length;
        },
        prev() {
            this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
        },
        goToSlide(index) {
            this.currentSlide = index;
        }
    }" class="relative">
        <!-- Slides -->
        <div class="relative h-80 overflow-hidden rounded-t-xl">
            <template x-for="(slide, index) in slides" :key="slide.id">
                <div
                    x-show="currentSlide === index"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="absolute inset-0"
                >
                    <img
                        :src="slide.image"
                        :alt="slide.title"
                        class="w-full h-full object-cover"
                    >
                    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                        <h3 class="text-2xl font-bold mb-2" x-text="slide.title"></h3>
                        <p class="text-lg mb-4" x-text="slide.description"></p>
                        <button class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors">
                            <span x-text="slide.cta"></span>
                        </button>
                    </div>
                </div>
            </template>
        </div>

        <!-- Navigation Arrows -->
        <button
            @click="prev()"
            class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full p-2 shadow-lg transition-all"
        >
            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <button
            @click="next()"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full p-2 shadow-lg transition-all"
        >
            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <!-- Indicators -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
            <template x-for="(slide, index) in slides" :key="slide.id">
                <button
                    @click="goToSlide(index)"
                    class="w-3 h-3 rounded-full transition-all"
                    :class="currentSlide === index ? 'bg-white' : 'bg-white bg-opacity-50'"
                ></button>
            </template>
        </div>
    </div>

    <!-- Auto-play script -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('slider', () => ({
                currentSlide: 0,
                slides: [],
                init() {
                    // Auto-advance slides every 5 seconds
                    setInterval(() => {
                        this.next();
                    }, 5000);
                },
                next() {
                    this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                },
                prev() {
                    this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
                },
                goToSlide(index) {
                    this.currentSlide = index;
                }
            }));
        });
    </script>
</div>
