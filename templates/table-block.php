<?php
// $logo_table = carbon_get_theme_option('logo_table');
// // $text_title = carbon_get_theme_option('text_title');
// $info_1 = carbon_get_theme_option('info_1');
// $info_2 = carbon_get_theme_option('info_2');
// $info_3 = carbon_get_theme_option('info_3');
// $ = carbon_get_theme_option('');
// $ = carbon_get_theme_option('');
// $ = carbon_get_theme_option('');
// $ = carbon_get_theme_option('');
// $ = carbon_get_theme_option('');
// $ = carbon_get_theme_option('');
?>

<?php
$complex_table = carbon_get_theme_option('complex_table');
foreach ($complex_table as $i) { ?>


    <div class="casino-container">
        <!-- Casino Card 1 -->
        <div class="casino-card">
            <div style="background-image: url('<?php echo $i['logo_table']; ?>');" class="logo"></div>
            <div class="casino-info">
                <h2><?php echo $i['text_title']; ?></h2>
                <div class="casino-rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">☆</span>
                    <span class="star">☆</span>
                    <span class="star">☆</span>
                </div>
                <ul class="casino-notes">
                    <li><?php echo $i['info_1']; ?></li>
                    <li><?php echo $i['info_2']; ?></li>
                    <li><?php echo $i['info_3']; ?></li>
                </ul>
            </div>

            <div class="casino-side">
                <div class="bonus">
                    <span class="bonus-amount"><?php echo $i['bonus_1']; ?></span>
                    <?php echo $i['bonus_2']; ?>
                </div>
                <a href="<?php echo $i['go_to_btn_link']; ?>"> <button class="play-btn" type="button"><?php echo $i['go_to_btn']; ?> </button>
                </a>
            </div>
        </div>
    </div>

<?php } ?>

<script>
    /**
     * Casino Card Component JavaScript
     * Handles play button functionality and component initialization
     */
    (function() {
        'use strict';

        // Function to handle play button clicks
        function handlePlayButtonClick(event) {
            event.preventDefault();

            // Find the casino name from the clicked button's card
            const casinoCard = event.target.closest('.casino-card');
            const casinoName = casinoCard ? casinoCard.querySelector('h2').textContent : 'Casino';

            // Show popup message
            alert(`Play now at ${casinoName}!`);

            // Future extension point: replace alert with modal, navigation, etc.
            // Example: window.location.href = '/casino/' + casinoName.toLowerCase().replace(/\s+/g, '-');
        }

        // Function to initialize casino card components
        function initializeCasinoCards() {
            // Find all play buttons
            const playButtons = document.querySelectorAll('.play-btn');

            // Add event listeners to each play button
            playButtons.forEach(function(button) {
                // Remove existing listeners to prevent duplicate handlers
                button.removeEventListener('click', handlePlayButtonClick);
                // Add the click event listener
                button.addEventListener('click', handlePlayButtonClick);
            });

            console.log(`Initialized ${playButtons.length} casino card(s)`);
        }

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeCasinoCards);
        } else {
            initializeCasinoCards();
        }

        // Expose initialization function for dynamic content
        window.initializeCasinoCards = initializeCasinoCards;

        // Function to create a new casino card dynamically (for future use)
        function createCasinoCard(data) {
            const cardHTML = `
                    <div class="casino-card">
                        <div class="logo">
                        </div>
                        
                        <div class="casino-info">
                            <h2>${data.name}</h2>
                            <div class="casino-rating">
                                ${generateStars(data.rating)}
                            </div>
                            <ul class="casino-notes">
                                ${data.features.map(feature => `<li>${feature}</li>`).join('')}
                            </ul>
                        </div>
                        
                        <div class="casino-side">
                            <div class="bonus">
                                <span class="bonus-amount">${data.bonus.amount}</span>
                                ${data.bonus.description}
                            </div>
                            <button class="play-btn" type="button">Play Now</button>
                        </div>
                    </div>
                `;

            return cardHTML;
        }

        // Helper function to generate star rating HTML
        function generateStars(rating) {
            let starsHTML = '';
            for (let i = 1; i <= 5; i++) {
                const starClass = i <= rating ? 'star' : 'star empty';
                starsHTML += `<span class="${starClass}">★</span>`;
            }
            return starsHTML;
        }

        // Expose utility functions for external use
        window.CasinoCard = {
            init: initializeCasinoCards,
            create: createCasinoCard,
            generateStars: generateStars
        };

    })();
</script>