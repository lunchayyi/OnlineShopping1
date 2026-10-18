<?php

$originalImages = [
    'images/banner1.jpg',
    'images/banner6.jpg',
    'images/banner3.jpg'
];

$displayImages = array_merge($originalImages, [$originalImages[0]]);
$totalOriginal = count($originalImages);
$totalDisplay = count($displayImages);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banner Slider</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

    <!-- Removed pt-[122px] so banner sits directly under the header -->
    <div class="relative w-full h-[300px] sm:h-[480px] md:h-[600px] overflow-hidden">
        <!-- Container for Slides -->
        <div 
            id="sliderTrack"
            class="flex h-full w-full transition-transform duration-700 ease-in-out"
            style="transform: translateX(0%);"
        >
            <?php foreach ($displayImages as $index =>$img): ?>
                <div class="w-full h-full flex-shrink-0">
                    <img 
                        src="<?php echo htmlspecialchars($img); ?>" 
                        alt="Banner <?php echo $index + 1; ?>" 
                        class="w-full h-full object-cover object-top"
                    />
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Prev Button -->
        <button 
            id="prevBtn"
            class="absolute top-1/2 left-4 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white w-9 h-9 md:w-10 md:h-10 rounded-full flex items-center justify-center z-10"
        >
            &#10094;
        </button>

        <!-- Next Button -->
        <button 
            id="nextBtn"
            class="absolute top-1/2 right-4 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white w-9 h-9 md:w-10 md:h-10 rounded-full flex items-center justify-center z-10"
        >
            &#10095;
        </button>

        <!-- Dots Indicator -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
            <?php for ($i = 0; $i < $totalOriginal; $i++): ?>
                <div
                    class="dot w-2.5 h-2.5 rounded-full cursor-pointer transition-all duration-300 <?php echo $i === 0 ? 'bg-white scale-125' : 'bg-white/50'; ?>"
                    data-index="<?php echo $i; ?>"
                ></div>
            <?php endfor; ?>
        </div>
    </div>

    <script>
        const displayCount = <?php echo $totalDisplay; ?>;
        const originalCount = <?php echo $totalOriginal; ?>;

        let currentIndex = 0;
        let timer = null;

        const track = document.getElementById('sliderTrack');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const dots = document.querySelectorAll('.dot');

        function setTransitioning(enabled) {
            if (enabled) {
                track.classList.add('transition-transform', 'duration-700', 'ease-in-out');
            } else {
                track.classList.remove('transition-transform', 'duration-700', 'ease-in-out');
            }
        }

        function updateDots() {
            const activeIndex = currentIndex % originalCount;
            dots.forEach((dot, index) => {
                if (index === activeIndex) {
                    dot.classList.add('bg-white', 'scale-125');
                    dot.classList.remove('bg-white/50');
                } else {
                    dot.classList.remove('bg-white', 'scale-125');
                    dot.classList.add('bg-white/50');
                }
            });
        }

        function updateSlidePosition() {
            track.style.transform = `translateX(-${currentIndex * 100}%)`;
            updateDots();
        }

        function nextSlide() {
            if (currentIndex >= displayCount - 1) return;
            setTransitioning(true);
            currentIndex++;
            updateSlidePosition();
        }

        function prevSlide() {
            if (currentIndex === 0) {
                setTransitioning(false);
                currentIndex = displayCount - 2;
                updateSlidePosition();

                setTimeout(() => {
                    setTransitioning(true);
                    currentIndex = displayCount - 3;
                    updateSlidePosition();
                }, 50);
            } else {
                setTransitioning(true);
                currentIndex--;
                updateSlidePosition();
            }
        }

        track.addEventListener('transitionend', () => {
            if (currentIndex === displayCount - 1) {
                setTransitioning(false);
                currentIndex = 0;
                updateSlidePosition();
            }
        });

        nextBtn.addEventListener('click', () => {
            nextSlide();
            resetTimer();
        });

        prevBtn.addEventListener('click', () => {
            prevSlide();
            resetTimer();
        });

        dots.forEach(dot => {
            dot.addEventListener('click', (e) => {
                const index = parseInt(e.target.getAttribute('data-index'));
                setTransitioning(true);
                currentIndex = index;
                updateSlidePosition();
                resetTimer();
            });
        });

        function startTimer() {
            timer = setInterval(() => {
                nextSlide();
            }, 3000);
        }

        function resetTimer() {
            clearInterval(timer);
            startTimer();
        }

        startTimer();
    </script>

</body>
</html>


