<?php require(__DIR__ . "/../partials/header.php"); ?>

<main class="container mt-4 position-relative" style="min-height: 70vh; overflow: hidden;">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4 mb-4">Cookie Policy</h1>
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="mb-4">The only cookies you'll find here are these...</h2>
                    <p class="lead my-3">Our website doesn't use tracking cookies to collect your information.</p>
                    <p>We believe in privacy and transparency, so we've decided to keep things simple.</p>
                    <p>Instead, please enjoy these delicious virtual cookies falling down your screen - click them to eat!</p>

                    <!-- Cookie counter - hidden initially -->
                    <div class="card mb-4 mx-auto" style="max-width: 250px; display: none;" id="stats-card">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <small>Cookies eaten:</small>
                                <span class="badge bg-primary rounded-pill" id="stats-counter">0</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="/" class="btn btn-primary">Back to Homepage</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cookie animation elements will be inserted here by JavaScript -->
    <div id="cookie-container"></div>
</main>

<!-- Cookie Animation JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cookieContainer = document.getElementById('cookie-container');
        const containerWidth = cookieContainer.offsetWidth;
        const containerHeight = window.innerHeight;
        const statsCounter = document.getElementById('stats-counter');
        const statsCard = document.getElementById('stats-card');

        let score = 0;
        let totalCookies = 0;
        let spawnInterval = null;
        let spawnRate = 3000; // Start slow: one cookie every 3 seconds
        const minSpawnRate = 1000; // Maximum spawn rate: one cookie per second
        const spawnDecreaseRate = 100; // Decrease spawn time by 100ms after each spawn

        // Cookie emojis and images
        const cookies = [
            '🍪', // Cookie emoji
            '<img src="https://cdn-icons-png.flaticon.com/512/541/541732.png" width="32" height="32" alt="Cookie">',
            '<img src="https://cdn-icons-png.flaticon.com/512/1047/1047711.png" width="32" height="32" alt="Chocolate Chip Cookie">'
        ];

        // Create initial cookies at a slow rate
        createCookie(); // Create first cookie immediately

        // Start spawning cookies at an increasing rate
        spawnInterval = setInterval(manageSpawnRate, spawnRate);

        function manageSpawnRate() {
            // Create a new cookie
            if (document.querySelectorAll('.cookie-element').length < 50) {
                createCookie();
            }

            // Gradually increase spawn rate until we reach the minimum spawn time
            if (spawnRate > minSpawnRate) {
                spawnRate -= spawnDecreaseRate;
                clearInterval(spawnInterval);
                spawnInterval = setInterval(manageSpawnRate, spawnRate);
            }
        }

        function createCookie() {
            const cookie = document.createElement('div');
            const cookieIndex = Math.floor(Math.random() * cookies.length);

            cookie.innerHTML = cookies[cookieIndex];
            cookie.className = 'cookie-element';
            cookie.style.position = 'absolute';
            cookie.style.left = `${Math.random() * 100}%`;
            cookie.style.top = `-50px`;
            cookie.style.opacity = Math.random() * 0.5 + 0.5;
            cookie.style.fontSize = `${Math.random() * 20 + 20}px`;
            cookie.style.transform = `rotate(${Math.random() * 360}deg)`;
            cookie.style.zIndex = '1000';
            cookie.style.cursor = 'pointer';

            // Make the entire cookie element clickable (including for image cookies)
            cookie.style.pointerEvents = 'all';

            cookieContainer.appendChild(cookie);
            totalCookies++;

            // Make cookie clickable - ensuring one-click response
            cookie.onclick = function(e) {
                e.stopPropagation();
                // Immediately remove click handler to prevent multiple triggers
                this.onclick = null;
                // Make sure we can't click it again
                this.style.pointerEvents = 'none';
                // Eat the cookie
                eatCookie(this);
            };

            // Animation properties
            const duration = Math.random() * 10 + 5; // 5-15 seconds
            const horizontalMovement = Math.random() * 100 - 50; // -50px to 50px

            // Apply animation
            const animation = cookie.animate([{
                    transform: `translateY(0) translateX(0) rotate(0deg)`
                },
                {
                    transform: `translateY(${containerHeight}px) translateX(${horizontalMovement}px) rotate(${Math.random() * 360}deg)`
                }
            ], {
                duration: duration * 1000,
                iterations: Infinity,
                easing: 'linear'
            });

            // Remove cookies that fall out of view and create new ones
            setTimeout(() => {
                if (cookie.parentNode === cookieContainer) {
                    cookie.remove();
                    createCookie();
                }
            }, duration * 1000);
        }

        function eatCookie(cookie) {
            // Show counter after first cookie is eaten
            if (score === 0) {
                statsCard.style.display = 'block';
                statsCard.classList.add('fade-in');
            }

            // Increment score
            score++;
            statsCounter.textContent = score;

            // Highlight counter with animation
            statsCounter.classList.add('highlight');
            setTimeout(() => {
                statsCounter.classList.remove('highlight');
            }, 300);

            // Check achievements
            checkAchievements();

            // Show bite animation
            cookie.style.pointerEvents = 'none';

            // Create crumb particles
            createCrumbs(cookie);

            // Remove cookie with a shrinking effect
            cookie.animate([{
                    transform: cookie.style.transform,
                    opacity: cookie.style.opacity
                },
                {
                    transform: `${cookie.style.transform} scale(0.5)`,
                    opacity: 0
                }
            ], {
                duration: 300,
                easing: 'ease-out'
            }).onfinish = () => {
                cookie.remove();

                // Create a new cookie to replace the eaten one
                setTimeout(createCookie, Math.random() * 2000);
            };
        }

        function createCrumbs(cookie) {
            const rect = cookie.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;

            // Create 5-8 crumbs
            const crumbCount = Math.floor(Math.random() * 4) + 5;

            for (let i = 0; i < crumbCount; i++) {
                const crumb = document.createElement('div');
                crumb.className = 'cookie-crumb';
                crumb.style.position = 'fixed';
                crumb.style.width = `${Math.random() * 6 + 2}px`;
                crumb.style.height = `${Math.random() * 6 + 2}px`;
                crumb.style.backgroundColor = '#a87655';
                crumb.style.borderRadius = '50%';
                crumb.style.left = `${centerX}px`;
                crumb.style.top = `${centerY}px`;
                crumb.style.zIndex = '999';

                document.body.appendChild(crumb);

                // Random direction for crumbs
                const angle = Math.random() * Math.PI * 2;
                const distance = Math.random() * 50 + 20;
                const destX = Math.cos(angle) * distance;
                const destY = Math.sin(angle) * distance;

                // Animate crumb
                crumb.animate([{
                        transform: 'translate(0, 0) rotate(0deg)',
                        opacity: 1
                    },
                    {
                        transform: `translate(${destX}px, ${destY}px) rotate(${Math.random() * 360}deg)`,
                        opacity: 0
                    }
                ], {
                    duration: Math.random() * 500 + 300,
                    easing: 'cubic-bezier(0.075, 0.82, 0.165, 1)'
                }).onfinish = () => {
                    crumb.remove();
                };
            }
        }

        function checkAchievements() {
            const achievements = [{
                    count: 10,
                    message: "Cookie Rookie!"
                },
                {
                    count: 25,
                    message: "Cookie Monster Apprentice!"
                },
                {
                    count: 50,
                    message: "Cookie Demolisher!"
                },
                {
                    count: 100,
                    message: "Ultimate Cookie Monster!"
                }
            ];

            for (const achievement of achievements) {
                if (score === achievement.count) {
                    showAchievement(achievement.message);
                    break;
                }
            }
        }

        function showAchievement(message) {
            const achievement = document.createElement('div');
            achievement.className = 'achievement-notification';
            achievement.innerHTML = `
                <div class="card shadow-lg">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fa fa-trophy text-warning fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Achievement Unlocked!</h5>
                                <p class="mb-0">${message}</p>
                            </div>
                            <button type="button" class="btn-close ms-auto" onclick="this.parentNode.parentNode.parentNode.remove()"></button>
                        </div>
                    </div>
                </div>
            `;
            achievement.style.position = 'fixed';
            achievement.style.bottom = '20px';
            achievement.style.left = '50%';
            achievement.style.transform = 'translateX(-50%)';
            achievement.style.zIndex = '2001';
            achievement.style.width = '350px';
            achievement.style.maxWidth = '90%';

            document.body.appendChild(achievement);

            // Remove after 5 seconds
            setTimeout(() => {
                achievement.style.opacity = '0';
                achievement.style.transform = 'translateX(-50%) translateY(20px)';
                achievement.style.transition = 'opacity 0.5s, transform 0.5s';
                setTimeout(() => achievement.remove(), 500);
            }, 5000);
        }
    });
</script>

<?php require(__DIR__ . "/../partials/footer.php"); ?>